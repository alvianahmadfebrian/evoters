<?php

namespace App\Services;

use App\Models\Vote;
use App\Models\Candidate;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpaymuService
{
    protected string $va;
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->va = (string) config('services.ipaymu.va', env('IPAYMU_VA', ''));
        $this->apiKey = (string) config('services.ipaymu.api_key', env('IPAYMU_API_KEY', ''));
        $this->baseUrl = rtrim((string) config('services.ipaymu.base_url', env('IPAYMU_BASE_URL', 'https://my.ipaymu.com')), '/');
    }

    /**
     * Create iPaymu Redirect Checkout URL for a vote
     */
    public function createCheckoutUrl(Vote $vote, Candidate $candidate, Event $event, string $name, int $quantity): ?string
    {
        $url = $this->baseUrl . '/api/v2/payment';
        $method = 'POST';

        $productName = 'Vote: ' . substr($candidate->name, 0, 45);
        $unitPrice = (int)$event->price;

        $photoUrl = null;
        if ($candidate->photo) {
            $photoUrl = filter_var($candidate->photo, FILTER_VALIDATE_URL)
                ? $candidate->photo
                : asset($candidate->photo);
        }

        $body = [
            'product' => [$productName],
            'qty' => [(int)$quantity],
            'price' => [$unitPrice],
            'description' => ['Dukungan suara untuk ' . substr($candidate->name, 0, 45)],
            'returnUrl' => route('event.results', $event->slug),
            'cancelUrl' => route('vote.pay', $vote->id),
            'notifyUrl' => route('payment.notification'),
            'referenceId' => $vote->payment_ref,
            'buyerName' => $name ?: 'Voter',
            'buyerEmail' => 'voter@e-voters.id',
            'buyerPhone' => '0895324380409',
        ];

        if ($photoUrl) {
            $body['imageUrl'] = [$photoUrl];
        }

        try {
            $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
            $requestBody = strtolower(hash('sha256', $jsonBody));
            $stringToSign = strtoupper($method) . ':' . $this->va . ':' . $requestBody . ':' . $this->apiKey;
            $signature = hash_hmac('sha256', $stringToSign, $this->apiKey);
            $timestamp = date('YmdHis');

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'va' => $this->va,
                'signature' => $signature,
                'timestamp' => $timestamp,
            ])->withBody($jsonBody, 'application/json')
              ->post($url);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['Status']) && $data['Status'] == 200 && isset($data['Data']['Url'])) {
                    return $data['Data']['Url'];
                }
                Log::error('iPaymu API non-200 Status: ' . json_encode($data));
            } else {
                Log::error('iPaymu API HTTP Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('iPaymu Checkout Exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Create Direct QRIS transaction through iPaymu API v2
     */
    public function createDirectQris(Vote $vote, Candidate $candidate, Event $event, string $name, int $quantity, ?string $phone = null, ?string $email = null): ?array
    {
        $url = $this->baseUrl . '/api/v2/payment/direct';
        $method = 'POST';

        $totalAmount = (int)($event->price * $quantity);
        $buyerName = !empty($name) ? substr($name, 0, 50) : 'Voter';
        $buyerPhone = !empty($phone) ? $phone : ('0812' . rand(10000000, 99999999));
        $buyerEmail = !empty($email) ? $email : ('voter.' . substr(md5($vote->id . time()), 0, 8) . '@evoters.id');

        $body = [
            'name' => $buyerName,
            'phone' => $buyerPhone,
            'email' => $buyerEmail,
            'amount' => $totalAmount,
            'notifyUrl' => route('payment.notification'),
            'referenceId' => $vote->payment_ref,
            'paymentMethod' => 'qris',
            'paymentChannel' => 'mpm',
            'description' => 'Vote: ' . substr($candidate->name, 0, 45) . ' (' . $quantity . ' vote)',
        ];

        try {
            $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
            $requestBody = strtolower(hash('sha256', $jsonBody));
            $stringToSign = strtoupper($method) . ':' . $this->va . ':' . $requestBody . ':' . $this->apiKey;
            $signature = hash_hmac('sha256', $stringToSign, $this->apiKey);
            $timestamp = date('YmdHis');

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'va' => $this->va,
                'signature' => $signature,
                'timestamp' => $timestamp,
            ])->withBody($jsonBody, 'application/json')
              ->post($url);

            Log::info('iPaymu Direct QRIS Response: ' . $response->body());

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['Status']) && $data['Status'] == 200 && isset($data['Data'])) {
                    $qrData = $data['Data'];
                    $qrImage = $qrData['QrImage'] ?? $qrData['QrTemplate'] ?? null;
                    if ($qrImage && !filter_var($qrImage, FILTER_VALIDATE_URL)) {
                        $qrImage = $this->baseUrl . '/' . ltrim($qrImage, '/');
                    }
                    return [
                        'qr_image' => $qrImage,
                        'qr_string' => $qrData['QrString'] ?? null,
                        'qr_template' => $qrData['QrTemplate'] ?? null,
                        'transaction_id' => $qrData['TransactionId'] ?? null,
                        'session_id' => $qrData['SessionId'] ?? null,
                        'expired' => $qrData['Expired'] ?? null,
                        'total' => $qrData['Total'] ?? $totalAmount,
                        'fee' => $qrData['Fee'] ?? 0,
                    ];
                }
                Log::error('iPaymu Direct QRIS non-200 Status: ' . json_encode($data));
            } else {
                Log::error('iPaymu Direct QRIS HTTP Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('iPaymu Direct QRIS Exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Verify iPaymu notification callback
     */
    public function verifyCallback(Request $request): bool
    {
        return true;
    }
}
