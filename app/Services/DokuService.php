<?php

namespace App\Services;

use App\Models\Vote;
use App\Models\Candidate;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DokuService
{
    protected string $clientId;
    protected string $secretKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->clientId = config('services.doku.client_id', '');
        $this->secretKey = config('services.doku.secret_key', '');
        $this->baseUrl = rtrim(config('services.doku.base_url', 'https://api-sandbox.doku.com'), '/');
    }

    /**
     * Create DOKU Checkout URL for a vote
     */
    public function createCheckoutUrl(Vote $vote, Candidate $candidate, Event $event, string $name, int $quantity): ?string
    {
        $requestTarget = '/checkout/v1/payment';
        $requestId = uniqid('REQ-', true);
        $requestTimestamp = now()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');

        $body = [
            'order' => [
                'amount' => (int) $vote->amount,
                'invoice_number' => $vote->payment_ref,
                'currency' => 'IDR',
                'callback_url' => route('event.results', $event->slug),
                'line_items' => [
                    [
                        'name' => 'Vote: ' . substr($candidate->name, 0, 40),
                        'price' => (int) $event->price,
                        'quantity' => (int) $quantity,
                    ]
                ]
            ],
            'payment' => [
                'payment_due_date' => 60
            ],
            'customer' => [
                'name' => $name,
                'email' => 'voter@example.com',
            ]
        ];

        try {
            $sigData = $this->generateSignature($requestTarget, $requestId, $requestTimestamp, $body);

            $response = Http::withHeaders([
                'Client-Id' => $this->clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $requestTimestamp,
                'Signature' => $sigData['signature'],
            ])->withBody($sigData['json'], 'application/json')
              ->post($this->baseUrl . $requestTarget);

            if ($response->successful()) {
                $data = $response->json();
                return $data['response']['payment']['url'] ?? null;
            }

            Log::error('DOKU API Error response: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('DOKU Checkout URL Generation Exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Verify DOKU signature from Webhook/Notification request
     */
    public function verifySignature(Request $request): bool
    {
        $headerClientId = $request->header('Client-Id');
        $headerRequestId = $request->header('Request-Id');
        $headerRequestTimestamp = $request->header('Request-Timestamp');
        $headerSignature = $request->header('Signature');

        if (!$headerSignature) {
            return false;
        }

        $cleanSignature = str_replace('HMACSHA256=', '', $headerSignature);

        $body = $request->getContent();
        $digest = base64_encode(hash('sha256', $body, true));

        $requestTarget = '/' . ltrim($request->getPathInfo(), '/');

        $stringToSign = "Client-Id:" . $this->clientId . "\n" .
            "Request-Id:" . $headerRequestId . "\n" .
            "Request-Timestamp:" . $headerRequestTimestamp . "\n" .
            "Request-Target:" . $requestTarget . "\n" .
            "Digest:" . $digest;

        $calculatedSignature = base64_encode(hash_hmac('sha256', $stringToSign, $this->secretKey, true));

        return hash_equals($cleanSignature, $calculatedSignature);
    }

    /**
     * Generate DOKU Signature and Request JSON body
     */
    public function generateSignature(string $requestTarget, string $requestId, string $requestTimestamp, array $body): array
    {
        $bodyJson = json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $digest = base64_encode(hash('sha256', $bodyJson, true));

        $stringToSign = "Client-Id:" . $this->clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $requestTimestamp . "\n" .
            "Request-Target:" . $requestTarget . "\n" .
            "Digest:" . $digest;

        $signature = base64_encode(hash_hmac('sha256', $stringToSign, $this->secretKey, true));

        return [
            'signature' => 'HMACSHA256=' . $signature,
            'digest' => $digest,
            'json' => $bodyJson
        ];
    }
}
