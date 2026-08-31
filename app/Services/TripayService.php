<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TripayService
{
    /**
     * Get Tripay base API URL
     */
    public static function getBaseUrl(): string
    {
        $mode = env('TRIPAY_MODE', 'production'); // 'sandbox' or 'production'
        return $mode === 'sandbox'
            ? 'https://tripay.co.id/api-sandbox/'
            : 'https://tripay.co.id/api/';
    }

    /**
     * Get available payment channels
     */
    public static function getChannels(): array
    {
        return [
            [
                'group' => 'QRIS (E-Wallet & Mobile Banking)',
                'channels' => [
                    ['code' => 'QRIS', 'name' => 'QRIS Realtime (GoPay, OVO, DANA, BCA, Livin, dll)', 'icon' => 'fas fa-qrcode', 'badge' => 'Otomatis'],
                ]
            ],
            [
                'group' => 'Virtual Account Bank',
                'channels' => [
                    ['code' => 'BCAVA', 'name' => 'BCA Virtual Account', 'icon' => 'fas fa-university', 'badge' => 'Otomatis'],
                    ['code' => 'BRIVA', 'name' => 'BRI Virtual Account', 'icon' => 'fas fa-university', 'badge' => 'Otomatis'],
                    ['code' => 'MANDIRIVA', 'name' => 'Mandiri Virtual Account', 'icon' => 'fas fa-university', 'badge' => 'Otomatis'],
                    ['code' => 'BNIVA', 'name' => 'BNI Virtual Account', 'icon' => 'fas fa-university', 'badge' => 'Otomatis'],
                    ['code' => 'PERMATAVA', 'name' => 'Permata Virtual Account', 'icon' => 'fas fa-university', 'badge' => 'Otomatis'],
                ]
            ],
            [
                'group' => 'Gerai Retail',
                'channels' => [
                    ['code' => 'ALFAMART', 'name' => 'Alfamart / Alfamidi', 'icon' => 'fas fa-store', 'badge' => 'Kasir'],
                    ['code' => 'INDOMARET', 'name' => 'Indomaret', 'icon' => 'fas fa-store', 'badge' => 'Kasir'],
                ]
            ]
        ];
    }

    /**
     * Create a Tripay Transaction / Closed Payment
     */
    public static function createClosedTransaction(array $payload): array
    {
        $apiKey = env('TRIPAY_API_KEY');
        $privateKey = env('TRIPAY_PRIVATE_KEY');
        $merchantCode = env('TRIPAY_MERCHANT_CODE');

        $merchantRef = 'SN-' . time() . '-' . rand(100, 999);
        $amount = (int) $payload['amount'];

        // If Tripay credentials are configured, execute real API call
        if (!empty($apiKey) && !empty($privateKey) && !empty($merchantCode)) {
            $signature = hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey);

            $data = [
                'method' => $payload['method'] ?? 'QRIS',
                'merchant_ref' => $merchantRef,
                'amount' => $amount,
                'customer_name' => $payload['customer_name'] ?? 'Pelanggan SmartNews',
                'customer_email' => $payload['customer_email'] ?? 'order@smartnews.id',
                'customer_phone' => $payload['customer_phone'] ?? '081234567890',
                'order_items' => [
                    [
                        'sku' => $payload['package_id'] ?? 'PACKAGE-SMARTNEWS',
                        'name' => $payload['package_name'] ?? 'Paket SmartNews CMS',
                        'price' => $amount,
                        'quantity' => 1,
                    ]
                ],
                'callback_url' => route('landing'),
                'return_url' => route('landing') . '?payment_status=success',
                'expired_time' => time() + (24 * 60 * 60), // 24 hours
                'signature' => $signature
            ];

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                ])->post(self::getBaseUrl() . 'transaction/create', $data);

                if ($response->successful()) {
                    $resData = $response->json();
                    if (isset($resData['success']) && $resData['success'] === true) {
                        return [
                            'success' => true,
                            'checkout_url' => $resData['data']['checkout_url'] ?? null,
                            'qr_url' => $resData['data']['qr_url'] ?? null,
                            'pay_code' => $resData['data']['pay_code'] ?? null,
                            'reference' => $resData['data']['reference'] ?? $merchantRef,
                            'data' => $resData['data']
                        ];
                    }
                }
            } catch (\Throwable $e) {
                Log::error('Tripay Payment Exception: ' . $e->getMessage());
            }
        }

        // Fallback / Direct Instant Invoice Mode (Zero Config)
        return [
            'success' => true,
            'is_direct' => true,
            'merchant_ref' => $merchantRef,
            'amount' => $amount,
            'package_name' => $payload['package_name'] ?? 'Paket SmartNews CMS',
            'method' => $payload['method'] ?? 'QRIS',
        ];
    }
}
