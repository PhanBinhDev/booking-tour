<?php
/**
 * File: payment_functions.php
 * Các hàm quản lý thanh toán và tích hợp cổng thanh toán
 */

/**
 * =============================
 * QUẢN LÝ PHƯƠNG THỨC THANH TOÁN
 * =============================
 */

/**
 * Lấy danh sách phương thức thanh toán
 * 
 * @param bool $activeOnly Chỉ lấy phương thức đang hoạt động
 * @return array Danh sách phương thức thanh toán
 */
function getPaymentMethods($activeOnly = true) {
    global $db;
    
    $whereClause = $activeOnly ? "WHERE is_active = 1" : "";
    
    $sql = "
        SELECT *
        FROM payment_methods
        $whereClause
        ORDER BY sort_order ASC
    ";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Lấy thông tin phương thức thanh toán theo mã
 * 
 * @param string $code Mã phương thức thanh toán
 * @return array|null Thông tin phương thức thanh toán
 */
function getPaymentMethodByCode($code) {
    global $db;
    
    $sql = "SELECT * FROM payment_methods WHERE code = ? AND is_active = 1";
    $stmt = $db->prepare($sql);
    $stmt->execute([$code]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * =============================
 * QUẢN LÝ THANH TOÁN
 * =============================
 */

/**
 * Tạo thanh toán mới
 * 
 * @param array $paymentData Dữ liệu thanh toán
 * @return int|bool ID của thanh toán mới hoặc false nếu thất bại
 */
function createPayment($paymentData) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Chuẩn bị dữ liệu
        if (isset($paymentData['payment_data']) && is_array($paymentData['payment_data'])) {
            $paymentData['payment_data'] = json_encode($paymentData['payment_data']);
        }
        
        $sql = "
            INSERT INTO payments (
                booking_id, payment_method_id, amount, currency, status,
                payment_data, notes, payer_name, payer_email, payer_phone
            ) VALUES (
                :booking_id, :payment_method_id, :amount, :currency, :status,
                :payment_data, :notes, :payer_name, :payer_email, :payer_phone
            )
        ";
        
        $stmt = $db->prepare($sql);
        
        // Bind các tham số
        $stmt->bindParam(':booking_id', $paymentData['booking_id']);
        $stmt->bindParam(':payment_method_id', $paymentData['payment_method_id']);
        $stmt->bindParam(':amount', $paymentData['amount']);
        $stmt->bindParam(':currency', $paymentData['currency'] ?? 'VND');
        $stmt->bindParam(':status', $paymentData['status'] ?? 'pending');
        $stmt->bindParam(':payment_data', $paymentData['payment_data'] ?? null);
        $stmt->bindParam(':notes', $paymentData['notes'] ?? null);
        $stmt->bindParam(':payer_name', $paymentData['payer_name'] ?? null);
        $stmt->bindParam(':payer_email', $paymentData['payer_email'] ?? null);
        $stmt->bindParam(':payer_phone', $paymentData['payer_phone'] ?? null);
        
        $stmt->execute();
        $paymentId = $db->lastInsertId();
        
        // Ghi log
        logPaymentEvent($paymentId, $paymentData['booking_id'], 'payment_created', $paymentData['status'] ?? 'pending', 'Tạo thanh toán mới');
        
        $db->commit();
        return $paymentId;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error creating payment: " . $e->getMessage());
        return false;
    }
}

/**
 * Cập nhật trạng thái thanh toán
 * 
 * @param int $paymentId ID của thanh toán
 * @param string $status Trạng thái mới
 * @param array $data Dữ liệu bổ sung
 * @return bool Kết quả cập nhật
 */
function updatePaymentStatus($paymentId, $status, $data = []) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Lấy thông tin thanh toán
        $sql = "SELECT booking_id, status FROM payments WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$paymentId]);
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$payment) {
            return false;
        }
        
        // Cập nhật trạng thái thanh toán
        $updateFields = ["status = ?"];
        $params = [$status];
        
        // Cập nhật transaction_id nếu có
        if (!empty($data['transaction_id'])) {
            $updateFields[] = "transaction_id = ?";
            $params[] = $data['transaction_id'];
        }
        
        // Cập nhật payment_data nếu có
        if (!empty($data['payment_data'])) {
            $updateFields[] = "payment_data = ?";
            $params[] = is_array($data['payment_data']) ? json_encode($data['payment_data']) : $data['payment_data'];
        }
        
        // Cập nhật payment_date nếu trạng thái là completed
        if ($status === 'completed') {
            $updateFields[] = "payment_date = NOW()";
        }
        
        $params[] = $paymentId;
        
        $sql = "UPDATE payments SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        // Ghi log
        $message = "Cập nhật trạng thái thanh toán từ {$payment['status']} thành {$status}";
        logPaymentEvent($paymentId, $payment['booking_id'], 'payment_status_updated', $status, $message, $data);
        
        // Cập nhật trạng thái đơn đặt tour nếu thanh toán hoàn tất
        if ($status === 'completed') {
            $sql = "UPDATE bookings SET payment_status = 'paid', status = 'confirmed', updated_at = NOW() WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$payment['booking_id']]);
            
            // Tạo hóa đơn
            createInvoiceFromPayment($paymentId);
        } elseif ($status === 'failed') {
            $sql = "UPDATE bookings SET payment_status = 'pending', updated_at = NOW() WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$payment['booking_id']]);
        }
        
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error updating payment status: " . $e->getMessage());
        return false;
    }
}

/**
 * Lấy thông tin thanh toán theo ID
 * 
 * @param int $paymentId ID của thanh toán
 * @return array|null Thông tin thanh toán
 */
function getPaymentById($paymentId) {
    global $db;
    
    $sql = "
        SELECT 
            p.*,
            pm.name AS payment_method_name,
            pm.code AS payment_method_code,
            b.booking_number,
            t.title AS tour_title
        FROM payments p
        JOIN payment_methods pm ON p.payment_method_id = pm.id
        JOIN bookings b ON p.booking_id = b.id
        JOIN tours t ON b.tour_id = t.id
        WHERE p.id = ?
    ";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$paymentId]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($payment && $payment['payment_data']) {
        $payment['payment_data'] = json_decode($payment['payment_data'], true);
    }
    
    return $payment;
}

/**
 * Lấy danh sách thanh toán của đơn đặt tour
 * 
 * @param int $bookingId ID của đơn đặt tour
 * @return array Danh sách thanh toán
 */
function getPaymentsByBookingId($bookingId) {
    global $db;
    
    $sql = "
        SELECT 
            p.*,
            pm.name AS payment_method_name,
            pm.code AS payment_method_code
        FROM payments p
        JOIN payment_methods pm ON p.payment_method_id = pm.id
        WHERE p.booking_id = ?
        ORDER BY p.created_at DESC
    ";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$bookingId]);
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($payments as &$payment) {
        if ($payment['payment_data']) {
            $payment['payment_data'] = json_decode($payment['payment_data'], true);
        }
    }
    
    return $payments;
}

/**
 * Ghi log sự kiện thanh toán
 * 
 * @param int $paymentId ID của thanh toán
 * @param int $bookingId ID của đơn đặt tour
 * @param string $event Tên sự kiện
 * @param string $status Trạng thái
 * @param string $message Thông điệp
 * @param array $data Dữ liệu bổ sung
 * @return int|bool ID của log hoặc false nếu thất bại
 */
function logPaymentEvent($paymentId, $bookingId, $event, $status, $message, $data = []) {
    global $db;
    
    try {
        $sql = "
            INSERT INTO payment_logs (
                payment_id, booking_id, event, status, message, data, ip_address, user_agent
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?
            )
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $paymentId,
            $bookingId,
            $event,
            $status,
            $message,
            !empty($data) ? json_encode($data) : null,
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);
        
        return $db->lastInsertId();
    } catch (Exception $e) {
        error_log("Error logging payment event: " . $e->getMessage());
        return false;
    }
}

/**
 * =============================
 * QUẢN LÝ HÓA ĐƠN
 * =============================
 */

/**
 * Tạo hóa đơn từ thanh toán
 * 
 * @param int $paymentId ID của thanh toán
 * @return int|bool ID của hóa đơn mới hoặc false nếu thất bại
 */
function createInvoiceFromPayment($paymentId) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Lấy thông tin thanh toán
        $sql = "
            SELECT 
                p.*,
                b.user_id,
                b.booking_number,
                u.full_name,
                u.email,
                u.phone,
                u.address
            FROM payments p
            JOIN bookings b ON p.booking_id = b.id
            LEFT JOIN users u ON b.user_id = u.id
            WHERE p.id = ?
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$paymentId]);
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$payment) {
            return false;
        }
        
        // Kiểm tra xem đã có hóa đơn cho thanh toán này chưa
        $sql = "SELECT COUNT(*) FROM invoices WHERE payment_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$paymentId]);
        
        if ($stmt->fetchColumn() > 0) {
            return false; // Đã có hóa đơn
        }
        
        // Tạo mã hóa đơn
        $invoiceNumber = generateInvoiceNumber();
        
        // Tính thuế (nếu có)
        $taxRate = 0.1; // 10%
        $taxAmount = $payment['amount'] * $taxRate;
        $totalAmount = $payment['amount'] + $taxAmount;
        
        // Thêm hóa đơn mới
        $sql = "
            INSERT INTO invoices (
                invoice_number, booking_id, payment_id, user_id, amount,
                tax_amount, total_amount, status, issue_date, due_date,
                billing_name, billing_address, billing_email, billing_phone
            ) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY),
                ?, ?, ?, ?
            )
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $invoiceNumber,
            $payment['booking_id'],
            $paymentId,
            $payment['user_id'],
            $payment['amount'],
            $taxAmount,
            $totalAmount,
            $payment['status'] === 'completed' ? 'paid' : 'issued',
            $payment['payer_name'] ?? $payment['full_name'] ?? null,
            $payment['address'] ?? null,
            $payment['payer_email'] ?? $payment['email'] ?? null,
            $payment['payer_phone'] ?? $payment['phone'] ?? null
        ]);
        
        $invoiceId = $db->lastInsertId();
        
        $db->commit();
        return $invoiceId;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error creating invoice: " . $e->getMessage());
        return false;
    }
}

/**
 * Lấy thông tin hóa đơn theo ID
 * 
 * @param int $invoiceId ID của hóa đơn
 * @return array|null Thông tin hóa đơn
 */
function getInvoiceById($invoiceId) {
    global $db;
    
    $sql = "
        SELECT 
            i.*,
            b.booking_number,
            t.title AS tour_title,
            u.full_name AS user_name,
            u.email AS user_email
        FROM invoices i
        JOIN bookings b ON i.booking_id = b.id
        JOIN tours t ON b.tour_id = t.id
        LEFT JOIN users u ON i.user_id = u.id
        WHERE i.id = ?
    ";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$invoiceId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Lấy hóa đơn theo mã hóa đơn
 * 
 * @param string $invoiceNumber Mã hóa đơn
 * @return array|null Thông tin hóa đơn
 */
function getInvoiceByNumber($invoiceNumber) {
    global $db;
    
    $sql = "SELECT id FROM invoices WHERE invoice_number = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$invoiceNumber]);
    $invoiceId = $stmt->fetchColumn();
    
    if (!$invoiceId) {
        return null;
    }
    
    return getInvoiceById($invoiceId);
}

/**
 * Tạo mã hóa đơn ngẫu nhiên
 * 
 * @return string Mã hóa đơn
 */
function generateInvoiceNumber() {
    $prefix = 'INV';
    $timestamp = date('ymd');
    $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
    
    return $prefix . $timestamp . $random;
}

/**
 * =============================
 * TÍCH HỢP CỔNG THANH TOÁN
 * =============================
 */

/**
 * Tạo URL thanh toán VNPay
 * 
 * @param array $paymentData Dữ liệu thanh toán
 * @return string URL thanh toán
 */
function createVNPayPaymentUrl($paymentData) {
    // Lấy cấu hình VNPay từ cơ sở dữ liệu hoặc file cấu hình
    $vnp_TmnCode = "YOUR_TMN_CODE"; // Mã website tại VNPay
    $vnp_HashSecret = "YOUR_HASH_SECRET"; // Chuỗi bí mật
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "https://yourdomain.com/payment/vnpay-return";
    
    $vnp_TxnRef = $paymentData['payment_id']; // Mã đơn hàng
    $vnp_OrderInfo = "Thanh toan tour " . $paymentData['tour_title'];
    $vnp_OrderType = "billpayment";
    $vnp_Amount = $paymentData['amount'] * 100; // VNPay yêu cầu số tiền * 100
    $vnp_Locale = 'vn';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    
    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
    );
    
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }
    
    $vnp_Url = $vnp_Url . "?" . $query;
    
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    
    return $vnp_Url;
}

/**
 * Xử lý kết quả thanh toán VNPay
 * 
 * @param array $vnpData Dữ liệu trả về từ VNPay
 * @return bool Kết quả xử lý
 */
function processVNPayReturn($vnpData) {
    // Lấy cấu hình VNPay
    $vnp_HashSecret = "YOUR_HASH_SECRET"; // Chuỗi bí mật
    
    // Kiểm tra chữ ký
    $vnp_SecureHash = $vnpData['vnp_SecureHash'];
    unset($vnpData['vnp_SecureHash']);
    ksort($vnpData);
    $i = 0;
    $hashData = "";
    
    foreach ($vnpData as $key => $value) {
        if ($i == 1) {
            $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }
    
    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
    
    // Kiểm tra chữ ký và trạng thái thanh toán
    if ($secureHash == $vnp_SecureHash) {
        $paymentId = $vnpData['vnp_TxnRef'];
        $responseCode = $vnpData['vnp_ResponseCode'];
        
        if ($responseCode == '00') {
            // Thanh toán thành công
            $transactionId = $vnpData['vnp_TransactionNo'];
            
            // Cập nhật trạng thái thanh toán
            updatePaymentStatus($paymentId, 'completed', [
                'transaction_id' => $transactionId,
                'payment_data' => $vnpData
            ]);
            
            return true;
        } else {
            // Thanh toán thất bại
            updatePaymentStatus($paymentId, 'failed', [
                'payment_data' => $vnpData
            ]);
            
            return false;
        }
    } else {
        // Chữ ký không hợp lệ
        return false;
    }
}

/**
 * Tạo URL thanh toán Momo
 * 
 * @param array $paymentData Dữ liệu thanh toán
 * @return string URL thanh toán
 */
function createMomoPaymentUrl($paymentData) {
    // Lấy cấu hình Momo từ cơ sở dữ liệu hoặc file cấu hình
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    $partnerCode = "MOMO_PARTNER_CODE";
    $accessKey = "MOMO_ACCESS_KEY";
    $secretKey = "MOMO_SECRET_KEY";
    $orderInfo = "Thanh toan tour " . $paymentData['tour_title'];
    $amount = $paymentData['amount'];
    $orderId = time() . "_" . $paymentData['payment_id'];
    $redirectUrl = "https://yourdomain.com/payment/momo-return";
    $ipnUrl = "https://yourdomain.com/payment/momo-ipn";
    $extraData = base64_encode(json_encode([
        'payment_id' => $paymentData['payment_id'],
        'booking_id' => $paymentData['booking_id']
    ]));
    
    // Tạo chữ ký
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $orderId . "&requestType=captureWallet";
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    
    $data = [
        'partnerCode' => $partnerCode,
        'partnerName' => "Di Travel",
        'storeId' => "DiTravelStore",
        'requestId' => $orderId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => 'captureWallet',
        'signature' => $signature
    ];
    
    // Gửi yêu cầu đến Momo
    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($data))
    ]);
    
    $result = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($statusCode == 200) {
        $response = json_decode($result, true);
        
        if ($response['resultCode'] == 0) {
            // Lưu thông tin vào cơ sở dữ liệu
            $paymentData = [
                'order_id' => $orderId,
                'request_id' => $orderId
            ];
            
            updatePaymentData($paymentData['payment_id'], $paymentData);
            
            return $response['payUrl'];
        }
    }
    
    return false;
}

/**
 * Xử lý kết quả thanh toán Momo
 * 
 * @param array $momoData Dữ liệu trả về từ Momo
 * @return bool Kết quả xử lý
 */
function processMomoReturn($momoData) {
    // Lấy cấu hình Momo
    $secretKey = "MOMO_SECRET_KEY";
    $accessKey = "MOMO_ACCESS_KEY"; // Define the access key
    
    // Kiểm tra chữ ký
    $partnerCode = $momoData["partnerCode"];
    $orderId = $momoData["orderId"];
    $requestId = $momoData["requestId"];
    $amount = $momoData["amount"];
    $orderInfo = $momoData["orderInfo"];
    $orderType = $momoData["orderType"];
    $transId = $momoData["transId"];
    $resultCode = $momoData["resultCode"];
    $message = $momoData["message"];
    $payType = $momoData["payType"];
    $responseTime = $momoData["responseTime"];
    $extraData = $momoData["extraData"];
    $signature = $momoData["signature"];
    
    // Tạo chữ ký để kiểm tra
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&message=" . $message . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&orderType=" . $orderType . "&partnerCode=" . $partnerCode . "&payType=" . $payType . "&requestId=" . $requestId . "&responseTime=" . $responseTime . "&resultCode=" . $resultCode . "&transId=" . $transId;
    $checkSignature = hash_hmac("sha256", $rawHash, $secretKey);
    
    // Giải mã extraData
    $extraDataJson = json_decode(base64_decode($extraData), true);
    $paymentId = $extraDataJson['payment_id'];
    
    if ($signature == $checkSignature) {
        if ($resultCode == 0) {
            // Thanh toán thành công
            updatePaymentStatus($paymentId, 'completed', [
                'transaction_id' => $transId,
                'payment_data' => $momoData
            ]);
            
            return true;
        } else {
            // Thanh toán thất bại
            updatePaymentStatus($paymentId, 'failed', [
                'payment_data' => $momoData
            ]);
            
            return false;
        }
    } else {
        // Chữ ký không hợp lệ
        return false;
    }
}

/**
 * Tạo URL thanh toán PayPal
 * 
 * @param array $paymentData Dữ liệu thanh toán
 * @return string URL thanh toán
 */
function createPayPalPaymentUrl($paymentData) {
    // Lấy cấu hình PayPal từ cơ sở dữ liệu hoặc file cấu hình
    $clientId = "YOUR_PAYPAL_CLIENT_ID";
    $clientSecret = "YOUR_PAYPAL_CLIENT_SECRET";
    $mode = "sandbox"; // sandbox hoặc live
    
    $apiUrl = $mode === 'sandbox' 
        ? 'https://api-m.sandbox.paypal.com' 
        : 'https://api-m.paypal.com';
    
    // Lấy access token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl . '/v1/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $clientSecret);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_POST, 1);
    
    $headers = [
        'Accept: application/json',
        'Accept-Language: en_US',
    ];
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    $err = curl_error($ch);
    
    if ($err) {
        error_log("cURL Error #:" . $err);
        return false;
    }
    
    $tokenData = json_decode($result, true);
    $accessToken = $tokenData['access_token'];
    
    // Tạo đơn hàng PayPal
    $returnUrl = "https://yourdomain.com/payment/paypal-return";
    $cancelUrl = "https://yourdomain.com/payment/paypal-cancel";
    
    // Chuyển đổi VND sang USD (giả sử tỷ giá 1 USD = 23,000 VND)
    $exchangeRate = 23000;
    $amountUSD = round($paymentData['amount'] / $exchangeRate, 2);
    
    $payload = [
        'intent' => 'CAPTURE',
        'purchase_units' => [
            [
                'reference_id' => $paymentData['payment_id'],
                'description' => "Thanh toán tour " . $paymentData['tour_title'],
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => $amountUSD
                ]
            ]
        ],
        'application_context' => [
            'brand_name' => 'Di Travel',
            'landing_page' => 'BILLING',
            'user_action' => 'PAY_NOW',
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl
        ]
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl . '/v2/checkout/orders');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_POST, 1);
    
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ];
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $err = curl_error($ch);
    
    curl_close($ch);
    
    if ($err) {
        error_log("cURL Error #:" . $err);
        return false;
    }
    
    $orderData = json_decode($response, true);
    
    if (isset($orderData['id'])) {
        // Lưu ID đơn hàng PayPal vào cơ sở dữ liệu
        $paymentData = [
            'paypal_order_id' => $orderData['id']
        ];
        
        updatePaymentData($paymentData['payment_id'], $paymentData);
        
        // Tìm URL thanh toán
        foreach ($orderData['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return $link['href'];
            }
        }
    }
    
    return false;
}

/**
 * Xử lý kết quả thanh toán PayPal
 * 
 * @param string $token Token từ PayPal
 * @param string $payerId ID người thanh toán
 * @return bool Kết quả xử lý
 */
function processPayPalReturn($token, $payerId) {
    // Lấy cấu hình PayPal
    $clientId = "YOUR_PAYPAL_CLIENT_ID";
    $clientSecret = "YOUR_PAYPAL_CLIENT_SECRET";
    $mode = "sandbox"; // sandbox hoặc live
    
    $apiUrl = $mode === 'sandbox' 
        ? 'https://api-m.sandbox.paypal.com' 
        : 'https://api-m.paypal.com';
    
    // Lấy access token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl . '/v1/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $clientSecret);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_POST, 1);
    
    $headers = [
        'Accept: application/json',
        'Accept-Language: en_US',
    ];
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    $tokenData = json_decode($result, true);
    $accessToken = $tokenData['access_token'];
    
    // Lấy thông tin đơn hàng từ token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl . '/v2/checkout/orders/' . $token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ];
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $orderData = json_decode($response, true);
    
    // Lấy payment_id từ reference_id
    $paymentId = $orderData['purchase_units'][0]['reference_id'];
    
    // Xác nhận thanh toán
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl . '/v2/checkout/orders/' . $token . '/capture');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{}");
    curl_setopt($ch, CURLOPT_POST, 1);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $captureData = json_decode($response, true);
    
    if ($captureData['status'] === 'COMPLETED') {
        // Thanh toán thành công
        $transactionId = $captureData['purchase_units'][0]['payments']['captures'][0]['id'];
        
        updatePaymentStatus($paymentId, 'completed', [
            'transaction_id' => $transactionId,
            'payment_data' => $captureData
        ]);
        
        return true;
    } else {
        // Thanh toán thất bại
        updatePaymentStatus($paymentId, 'failed', [
            'payment_data' => $captureData
        ]);
        
        return false;
    }
}

/**
 * Cập nhật dữ liệu thanh toán
 * 
 * @param int $paymentId ID của thanh toán
 * @param array $data Dữ liệu cần cập nhật
 * @return bool Kết quả cập nhật
 */
function updatePaymentData($paymentId, $data) {
    global $db;
    
    try {
        // Lấy dữ liệu hiện tại
        $sql = "SELECT payment_data FROM payments WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$paymentId]);
        $currentData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$currentData) {
            return false;
        }
        
        // Gộp dữ liệu mới với dữ liệu hiện tại
        $paymentData = $currentData['payment_data'] ? json_decode($currentData['payment_data'], true) : [];
        $paymentData = array_merge($paymentData, $data);
        
        // Cập nhật dữ liệu
        $sql = "UPDATE payments SET payment_data = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([json_encode($paymentData), $paymentId]);
        
        return true;
    } catch (Exception $e) {
        error_log("Error updating payment data: " . $e->getMessage());
        return false;
    }
}