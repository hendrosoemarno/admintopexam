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
            ? 'https://api-sandbox.duitku.com'
            : 'https://api.duitku.com';
    }

    public function createInvoice(Transaction $transaction, string $returnUrl, string $callbackUrl): array
    {
        $payload = [
            'merchantCode' => $this->merchantCode,
            'paymentAmount' => (int) ($transaction->total_amount * 100),
            'merchantOrderId' => $transaction->invoice_number,
            'productDetails' => 'Registrasi: ' . $transaction->package->name,
            'customerVaName' => $transaction->first_name . ' ' . $transaction->last_name,
            'email' => $transaction->email,
            'returnUrl' => $returnUrl,
            'callbackUrl' => $callbackUrl,
            'signature' => $this->generateSignature($transaction->invoice_number, $transaction->total_amount),
        ];

        $response = Http::post($this->getBaseUrl() . '/api/v2/merchant/createInvoice', $payload);

        $body = $response->json();

        if ($response->successful() && isset($body['paymentUrl'])) {
            $transaction->update([
                'payment_code' => $body['reference'] ?? null,
                'payment_url' => $body['paymentUrl'],
            ]);

            Log::info('Duitku invoice created: ' . $transaction->invoice_number);
            return ['success' => true, 'paymentUrl' => $body['paymentUrl']];
        }

        $error = $body['Message'] ?? json_encode($body);
        Log::error('Duitku createInvoice failed: ' . $error);
        return ['success' => false, 'error' => $error];
    }

    public function handleCallback(array $data): array
    {
        $merchantCode = $data['merchantCode'] ?? '';
        $amount = $data['amount'] ?? '';
        $merchantOrderId = $data['merchantOrderId'] ?? '';
        $reference = $data['reference'] ?? '';

        $signature = md5($merchantCode . $merchantOrderId . $amount . $this->apiKey);

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

    protected function generateSignature(string $merchantOrderId, float $amount): string
    {
        return md5($this->merchantCode . $merchantOrderId . (int) ($amount * 100) . $this->apiKey);
    }
}
