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
        $this->va = config('services.ipaymu.va', env('IPAYMU_VA', '0000005324380409'));
        $this->apiKey = config('services.ipaymu.api_key', env('IPAYMU_API_KEY', 'SANDBOX6C212F99-D30B-48F3-A912-DAF6415C2054'));
        $this->baseUrl = rtrim(config('services.ipaymu.base_url', env('IPAYMU_BASE_URL', 'https://sandbox.ipaymu.com')), '/');
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

        $body = [
            'product' => [$productName],
            'qty' => [(int)$quantity],
            'price' => [$unitPrice],
            'returnUrl' => route('event.results', $event->slug),
            'cancelUrl' => route('vote.pay', $vote->id),
            'notifyUrl' => route('payment.notification'),
            'referenceId' => $vote->payment_ref,
            'buyerName' => $name ?: 'Voter',
            'buyerEmail' => 'voter@e-voters.id',
            'buyerPhone' => '0895324380409',
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
     * Verify iPaymu notification callback
     */
    public function verifyCallback(Request $request): bool
    {
        return true;
    }
}
