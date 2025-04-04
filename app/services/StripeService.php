<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;

class StripeService
{
  private $secretKey;
  private $publishableKey;
  private $webhookSecret;
  private $currency;

  public function __construct()
  {
    $this->secretKey = getenv('SECRET_KEY');
    $this->publishableKey = getenv('PUBLISHABLE_KEY');
    $this->webhookSecret = getenv('WEBHOOK_SECRET');
    $this->currency = getenv('CURRENCY') ?: 'VND';

    Stripe::setApiKey($this->secretKey);
  }

  /**
   * Get the publishable key for client-side use
   */
  public function getPublishableKey()
  {
    return $this->publishableKey;
  }

  /**
   * Create a direct payment intent for client-side confirmation
   * 
   * @param int $amount Số tiền thanh toán
   * @param string $currency Mã tiền tệ (mặc định là VND)
   * @param array $metadata Metadata bổ sung
   * @param string $description Mô tả thanh toán
   * @return \Stripe\PaymentIntent PaymentIntent object
   * @throws \Exception Nếu có lỗi xảy ra
   */
  public function createPaymentIntent($amount, $currency = null, $metadata = [], $description = '', $customerId = null)
  {
    // Sử dụng currency từ tham số, nếu không có thì dùng giá trị mặc định
    $currency = $currency ?: $this->currency;

    try {
      $paymentIntentData = [
        'amount' => $this->formatAmount($amount),
        'currency' => $currency,
        'metadata' => $metadata,
        'automatic_payment_methods' => [
          'enabled' => true
        ]
      ];

      // Thêm các trường tùy chọn nếu có
      if ($customerId) {
        $paymentIntentData['customer'] = $customerId;
      }

      if (!empty($description)) {
        $paymentIntentData['description'] = $description;
      }

      // Tạo payment intent
      return PaymentIntent::create($paymentIntentData);
    } catch (ApiErrorException $e) {
      throw new \Exception($e->getMessage(), $e->getCode());
    }
  }

  /**
   * Create a Stripe Checkout Session for a full-page redirect
   * 
   * @param array $lineItems Thông tin các sản phẩm
   * @param string $reference Mã đơn hàng
   * @param array $metadata Metadata bổ sung
   * @param string $successUrl URL chuyển hướng khi thanh toán thành công
   * @param string $cancelUrl URL chuyển hướng khi hủy thanh toán
   * @return \Stripe\Checkout\Session
   */
  public function createCheckoutSession($lineItems, $reference, $metadata = [], $successUrl = null, $cancelUrl = null)
  {
    try {
      // Format line items
      $formattedLineItems = [];
      foreach ($lineItems as $item) {
        $formattedLineItems[] = [
          'price_data' => [
            'currency' => $item['currency'] ?? $this->currency,
            'product_data' => [
              'name' => $item['name'],
              'description' => $item['description'] ?? '',
              'metadata' => $metadata
            ],
            'unit_amount' => $this->formatAmount($item['amount'])
          ],
          'quantity' => $item['quantity'] ?? 1
        ];
      }

      // Default URLs if none provided
      $successUrl = $successUrl ?? getenv('APP_URL') . '/payment/success';
      $cancelUrl = $cancelUrl ?? getenv('APP_URL') . '/payment/cancel';

      // Create checkout session
      $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $formattedLineItems,
        'mode' => 'payment',
        'success_url' => $successUrl,
        'cancel_url' => $cancelUrl,
        'metadata' => $metadata,
        'client_reference_id' => $reference
      ]);

      return $session;
    } catch (\Stripe\Exception\ApiErrorException $e) {
      throw new \Exception('Stripe error: ' . $e->getMessage(), $e->getCode());
    }
  }

  /**
   * Retrieve session details by session ID
   * 
   * @param string $sessionId The Checkout Session ID
   * @return \Stripe\Checkout\Session|null
   */
  public function retrieveSession($sessionId)
  {
    try {
      \Stripe\Stripe::setApiKey($this->secretKey);
      $session = \Stripe\Checkout\Session::retrieve($sessionId);
      return $session; // Return the actual Stripe\Checkout\Session object
    } catch (\Stripe\Exception\ApiErrorException $e) {
      error_log('Error retrieving Stripe session: ' . $e->getMessage());
      return null;
    }
  }
  /**
   * Retrieve an existing payment intent by ID
   * 
   * @param string $paymentIntentId ID của payment intent
   * @return \Stripe\PaymentIntent|null Payment intent object hoặc null nếu không tìm thấy
   */
  public function retrievePaymentIntent($paymentIntentId)
  {
    try {
      return PaymentIntent::retrieve($paymentIntentId);
    } catch (ApiErrorException $e) {
      error_log('Error retrieving payment intent: ' . $e->getMessage());
      return null;
    }
  }

  /**
   * Update an existing payment intent
   * 
   * @param string $paymentIntentId ID của payment intent cần cập nhật
   * @param int $amount Số tiền thanh toán
   * @param array $metadata Metadata bổ sung
   * @param string $description Mô tả thanh toán
   * @return \Stripe\PaymentIntent|null Updated payment intent hoặc null nếu có lỗi
   */
  public function updatePaymentIntent($paymentIntentId, $amount, $metadata = [], $description = '')
  {
    try {
      $updateData = [];

      // Chỉ thêm các trường có dữ liệu
      if ($amount > 0) {
        $updateData['amount'] = $this->formatAmount($amount);
      }

      if (!empty($description)) {
        $updateData['description'] = $description;
      }

      if (!empty($metadata)) {
        $updateData['metadata'] = $metadata;
      }

      // Cập nhật payment intent
      $paymentIntent = PaymentIntent::update($paymentIntentId, $updateData);
      return $paymentIntent;
    } catch (ApiErrorException $e) {
      error_log('Error updating payment intent: ' . $e->getMessage());
      return null;
    }
  }

  /**
   * Handle Stripe API errors consistently
   */
  private function handleError($e)
  {
    $errorData = [
      'success' => false,
      'error' => $e->getMessage(),
      'type' => get_class($e)
    ];

    if (method_exists($e, 'getError')) {
      $error = $e->getError();
      if ($error) {
        $errorData['code'] = $error->code;
        $errorData['decline_code'] = $error->decline_code;
        $errorData['param'] = $error->param;
      }
    }

    // Log the error
    error_log('Stripe Error: ' . json_encode($errorData));

    return $errorData;
  }

  /**
   * Format amount according to Stripe's requirements
   * VND has no decimals, most other currencies use 2 decimal places
   */
  private function formatAmount($amount)
  {
    if (strtoupper($this->currency) === 'VND') {
      // VND doesn't use decimals
      return (int) $amount;
    } else {
      // Most currencies use 2 decimal places (e.g. USD, EUR)
      return (int) ($amount * 100);
    }
  }
}
