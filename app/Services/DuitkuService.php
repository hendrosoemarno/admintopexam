<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DuitkuService
{
    protected string $merchantCode;
    protected string $apiKey;
    protected bool $isSandbox;

    public function __construct()
    {
        $this->merchantCode = Setting::getValue('duitku_merchant_code', '');
        $this->apiKey = Setting::getValue('duitku_api_key', '');
        $this->isSandbox = Setting::getValue('duitku_sandbox', 'true') === 'true';
    }

    protected function getBaseUrl(): string
    {
        return $this->isSandbox
            ? 'https://sandbox.duitku.com'
            : 'https://passport.duitku.com';
    }

    protected function signature(string ...$parts): string
    {
        return hash_hmac('sha256', implode('', $parts), $this->apiKey);
    }

    public function createInvoice(Transaction $transaction, string $returnUrl, string $callbackUrl): array
    {
        if (empty($this->merchantCode) || empty($this->apiKey)) {
            return ['success' => false, 'error' => 'Merchant Code atau API Key Duitku belum dikonfigurasi. Silakan isi di menu Pengaturan.'];
        }

        $paymentAmount = (int) $transaction->total_amount;

        $stringToSign = $this->merchantCode . $transaction->invoice_number . $paymentAmount;
        $signature = hash_hmac('sha256', $stringToSign, $this->apiKey);

        $payload = [
            'merchantCode' => $this->merchantCode,
            'paymentAmount' => $paymentAmount,
            'merchantOrderId' => $transaction->invoice_number,
            'productDetails' => 'Registrasi: ' . $transaction->package->name,
            'customerVaName' => $transaction->first_name . ' ' . $transaction->last_name,
            'email' => $transaction->email,
            'returnUrl' => $returnUrl,
            'callbackUrl' => $callbackUrl,
            'signature' => $signature,
        ];

        $url = $this->getBaseUrl() . '/webapi/api/merchant/v2/inquiry';
        Log::info('Duitku request: ' . $url . ' payload: ' . json_encode($payload));

        $response = Http::timeout(30)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $payload);

        $statusCode = $response->status();
        $bodyRaw = $response->body();
        $body = $response->json();

        Log::info('Duitku response status: ' . $statusCode . ' body: ' . $bodyRaw);

        if ($response->successful() && isset($body['paymentUrl'])) {
            $transaction->update([
                'payment_code' => $body['reference'] ?? null,
                'payment_url' => $body['paymentUrl'],
            ]);

            Log::info('Duitku invoice created: ' . $transaction->invoice_number);
            return ['success' => true, 'paymentUrl' => $body['paymentUrl']];
        }

        if ($body === null) {
            $error = 'Response tidak valid (HTTP ' . $statusCode . '). Body: ' . substr($bodyRaw, 0, 500);
        } else {
            $error = $body['statusMessage'] ?? $body['Message'] ?? json_encode($body);
        }

        Log::error('Duitku createInvoice failed: ' . $error);
        return ['success' => false, 'error' => $error];
    }

    public function handleCallback(array $data): array
    {
        $merchantCode = $data['merchantCode'] ?? '';
        $amount = $data['amount'] ?? '';
        $merchantOrderId = $data['merchantOrderId'] ?? '';
        $reference = $data['reference'] ?? '';

        $stringToSign = $merchantCode . $amount . $merchantOrderId;
        $signature = hash_hmac('sha256', $stringToSign, $this->apiKey);

        if ($signature !== ($data['signature'] ?? '')) {
            Log::warning('Duitku callback invalid signature for order: ' . $merchantOrderId);
            return ['success' => false, 'error' => 'Invalid signature'];
        }

        $transaction = Transaction::where('invoice_number', $merchantOrderId)->first();

        if (!$transaction) {
            Log::warning('Duitku callback transaction not found: ' . $merchantOrderId);
            return ['success' => false, 'error' => 'Transaction not found'];
        }

        $resultCode = $data['resultCode'] ?? '';

        if ($resultCode === '00') {
            $transaction->update([
                'status' => 'paid',
                'payment_code' => $reference,
                'paid_at' => now(),
            ]);

            Log::info('Payment success for invoice: ' . $merchantOrderId);
            return ['success' => true, 'transaction' => $transaction];
        }

        if (in_array($resultCode, ['01', '02', '03', '04'])) {
            $transaction->update(['status' => 'failed']);
        }

        return ['success' => false, 'error' => 'Payment not successful. Result code: ' . $resultCode];
    }
}
