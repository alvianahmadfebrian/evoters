<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Candidate;
use App\Models\Token;
use App\Models\Vote;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\DokuService;

class VotingController extends Controller
{
    protected DokuService $dokuService;

    public function __construct(DokuService $dokuService)
    {
        $this->dokuService = $dokuService;
    }
    /**
     * Show the landing page.
     */
    public function index(Request $request)
    {
        $query = Event::where('status', 'active');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $activeEvents = $query->orderBy('created_at', 'desc')->get();

        return view('welcome', compact('activeEvents'));
    }

    /**
     * Show the event voting ballot.
     */
    public function showEvent($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        
        // Load candidates
        $event->load('candidates');

        return view('voting.event', compact('event'));
    }

    /**
     * Request OTP for email-based voting.
     */
    public function requestOtp(Request $request, $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        if (!$event->isOpen()) {
            return response()->json([
                'success' => false,
                'message' => 'Voting untuk event ini sedang ditutup atau belum dimulai.',
            ], 422);
        }

        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        
        // Prevent double voting check before sending OTP
        $voterIdentifier = sha1(strtolower($email));
        $hasVoted = Vote::where('event_id', $event->id)
            ->where('voter_identifier', $voterIdentifier)
            ->exists();

        if ($hasVoted) {
            return response()->json([
                'success' => false,
                'message' => 'Email ini sudah digunakan untuk memilih dalam event ini.',
            ], 422);
        }

        // Generate 6 digit OTP code
        $code = rand(100000, 999999);

        // Delete any existing OTPs for this email in this event
        Otp::where('email', $email)->where('event_id', $event->id)->delete();

        // Create new OTP
        Otp::create([
            'email' => $email,
            'code' => $code,
            'event_id' => $event->id,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Mock OTP Flow for easy local testing:
        // We write to logs, and we also store it in the session so the frontend can retrieve
        // and display it in a toast block. Super convenient!
        Log::info("Voting OTP for {$email} in event '{$event->title}': {$code}");
        
        // Save to session so we can display it in local mode
        session()->put('last_otp_code_' . str_replace('.', '_', $email), $code);

        return response()->json([
            'success' => true,
            'message' => 'OTP berhasil dikirim ke email Anda. Silakan periksa kotak masuk.',
            'mock' => config('app.env') === 'local' ? $code : null, // expose OTP in local env response
        ]);
    }

    /**
     * Submit vote.
     */
    public function submitVote(Request $request, $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        if (!$event->isOpen()) {
            return back()->withErrors(['voting' => 'Voting untuk event ini sedang ditutup atau belum dimulai.']);
        }

        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $candidateId = $request->input('candidate_id');
        $candidate = Candidate::where('id', $candidateId)->where('event_id', $event->id)->firstOrFail();

        // 1. Paid Voting Flow (Direct Payment with Quantity)
        if ($event->price > 0) {
            $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer|min:1',
            ]);

            $name = $request->input('name');
            $quantity = (int)$request->input('quantity');
            $voterIdentifier = sha1(strtolower($name) . '-' . time() . '-' . uniqid());

            $amount = $event->price * $quantity;
            $paymentRef = 'EV-VOTE-' . strtoupper(uniqid());

            // Create Vote transaction
            $vote = Vote::create([
                'event_id' => $event->id,
                'candidate_id' => $candidate->id,
                'voter_identifier' => $voterIdentifier,
                'payment_status' => 'pending',
                'amount' => $amount,
                'payment_ref' => $paymentRef,
                'payment_url' => null,
                'quantity' => $quantity,
                'voted_at' => now(),
            ]);

            $paymentUrl = $this->dokuService->createCheckoutUrl($vote, $candidate, $event, $name, $quantity);
            if ($paymentUrl) {
                $vote->update(['payment_url' => $paymentUrl]);
            }

            return redirect()->route('vote.pay', $vote->id);
        }

        // 2. Free Voting Flow (price == 0)
        $request->validate([
            'voting_type' => 'required|in:public_email,token_only',
        ]);

        $voterIdentifier = '';
        $email = null;
        $otp = null;
        $token = null;

        if ($event->voting_type === 'public_email') {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|string|size:6',
            ]);

            $email = strtolower($request->input('email'));
            $otpCode = $request->input('otp');

            // Find OTP
            $otp = Otp::where('email', $email)
                ->where('event_id', $event->id)
                ->where('code', $otpCode)
                ->first();

            if (!$otp || $otp->isExpired()) {
                return back()->withErrors(['otp' => 'Kode OTP salah atau telah kedaluwarsa.'])->withInput();
            }

            $voterIdentifier = sha1($email);
        } else {
            // Token-based voting
            $request->validate([
                'token' => 'required|string',
            ]);

            $tokenCode = trim($request->input('token'));
            $voterIdentifier = sha1($tokenCode);

            // Find token
            $token = Token::where('event_id', $event->id)
                ->where('code', $tokenCode)
                ->first();

            if (!$token) {
                return back()->withErrors(['token' => 'Kode Token tidak valid.'])->withInput();
            }

            if ($token->is_used) {
                return back()->withErrors(['token' => 'Kode Token ini sudah pernah digunakan.'])->withInput();
            }
        }

        // Double check vote uniqueness for free events (completed votes only)
        $hasVoted = Vote::where('event_id', $event->id)
            ->where('voter_identifier', $voterIdentifier)
            ->where('payment_status', 'completed')
            ->exists();

        if ($hasVoted) {
            if ($otp) $otp->delete();
            return back()->withErrors(['email' => 'Anda sudah memberikan suara untuk event ini.'])->withInput();
        }

        // Create Vote
        $vote = Vote::create([
            'event_id' => $event->id,
            'candidate_id' => $candidate->id,
            'voter_identifier' => $voterIdentifier,
            'payment_status' => 'completed',
            'amount' => 0,
            'payment_ref' => null,
            'quantity' => 1,
            'voted_at' => now(),
        ]);

        // Cleanup and markings
        if ($event->voting_type === 'public_email') {
            $otp->delete();
            session()->forget('last_otp_code_' . str_replace('.', '_', $email));
        } else {
            $token->update([
                'is_used' => true,
                'voted_at' => now(),
            ]);
        }

        session()->put('voted_event_' . $event->id, true);
        return redirect()->route('event.results', $event->slug)->with('success', 'Suara Anda berhasil dikirim! Terima kasih atas partisipasi Anda.');
    }

    /**
     * Show event results.
     */
    public function showResults($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        // Control results access based on event settings
        $canView = false;

        if ($event->show_results === 'always') {
            $canView = true;
        } elseif ($event->show_results === 'after_voting' && session()->has('voted_event_' . $event->id)) {
            $canView = true;
        } elseif ($event->show_results === 'after_closed' && $event->status === 'closed') {
            $canView = true;
        } elseif (auth()->check()) {
            // Admin can always view
            $canView = true;
        }

        if (!$canView) {
            $message = 'Hasil voting untuk event ini tidak dipublikasikan secara umum.';
            if ($event->show_results === 'after_voting') {
                $message = 'Anda harus memberikan suara terlebih dahulu untuk melihat hasil voting.';
            } elseif ($event->show_results === 'after_closed') {
                $message = 'Hasil voting akan dibuka setelah event ini resmi ditutup.';
            }
            
            return view('voting.results', [
                'event' => $event,
                'error' => $message,
                'candidates' => collect()
            ]);
        }

        // Fetch candidates with vote quantities summed (only paid votes are counted via filtered relation)
        $candidates = $event->candidates()->withSum('votes', 'quantity')->get();
        $totalVotes = (int)$event->votes()->sum('quantity');

        return view('voting.results', compact('event', 'candidates', 'totalVotes'));
    }

    /**
     * Show the QRIS checkout page.
     */
    public function showPayment($id)
    {
        $vote = Vote::findOrFail($id);

        if ($vote->payment_status === 'completed') {
            return redirect()->route('event.results', $vote->event->slug)->with('success', 'Pembayaran untuk vote ini sudah selesai.');
        }

        $event = $vote->event;
        $candidate = $vote->candidate;

        // If payment URL is missing for some reason, try to generate it now
        if (!$vote->payment_url) {
            $paymentUrl = $this->dokuService->createCheckoutUrl($vote, $candidate, $event, 'Voter', $vote->quantity);
            if ($paymentUrl) {
                $vote->update(['payment_url' => $paymentUrl]);
            }
        }

        return view('voting.payment', compact('vote', 'event', 'candidate'));
    }

    /**
     * Confirm mock QRIS payment.
     */
    public function confirmPayment($id)
    {
        $vote = Vote::findOrFail($id);

        if ($vote->payment_status === 'completed') {
            return redirect()->route('event.results', $vote->event->slug)->with('success', 'Pembayaran untuk vote ini sudah selesai.');
        }

        // Update vote status to completed
        $vote->update([
            'payment_status' => 'completed',
            'voted_at' => now(),
        ]);

        // Mark session that user has voted
        session()->put('voted_event_' . $vote->event_id, true);

        return redirect()->route('event.results', $vote->event->slug)->with('success', 'Pembayaran QRIS berhasil! Suara Anda telah resmi terekam.');
    }

    /**
     * Handle DOKU Payment Webhook / Notification.
     */
    public function handleNotification(Request $request)
    {
        try {
            // Verify signature
            if (!$this->dokuService->verifySignature($request)) {
                Log::warning('DOKU Webhook signature verification failed.');
                return response()->json(['message' => 'Invalid signature.'], 401);
            }

            $payload = $request->all();
            $invoiceNumber = $payload['order']['invoice_number'] ?? null;
            $transactionStatus = $payload['transaction']['status'] ?? null;

            Log::info("DOKU Webhook Received - Invoice: {$invoiceNumber}, Status: {$transactionStatus}");

            if (!$invoiceNumber) {
                return response()->json(['message' => 'Invoice number not found in payload.'], 400);
            }

            // Find the corresponding Vote
            $vote = Vote::where('payment_ref', $invoiceNumber)->first();

            if (!$vote) {
                return response()->json(['message' => 'Transaction reference not found.'], 404);
            }

            if ($vote->payment_status === 'completed') {
                return response()->json(['message' => 'Transaction already processed as completed.'], 200);
            }

            // Update status based on transaction status
            if ($transactionStatus === 'SUCCESS') {
                $vote->update([
                    'payment_status' => 'completed',
                    'voted_at' => now(),
                ]);
            } else if ($transactionStatus === 'FAILED') {
                $vote->update(['payment_status' => 'failed']);
            }

            return response()->json(['message' => 'Notification processed successfully.']);
        } catch (\Exception $e) {
            Log::error('DOKU Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while processing the notification.'], 500);
        }
    }
}
