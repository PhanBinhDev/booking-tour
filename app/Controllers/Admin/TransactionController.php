<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\Refund;
use App\Models\Booking;
use App\Models\ActivityLog;
use App\Helpers\UrlHelper;
use App\Helpers\Validator;
use App\Models\PaymentMethod;

class TransactionController extends BaseController {
    private $transactionModel;
    private $invoiceModel;
    private $refundModel;
    private $bookingModel;
    private $activityLogModel;
    private $paymentMethodModel;

    public function __construct() {
        $this->transactionModel = new Transaction();
        $this->invoiceModel = new Invoice();
        $this->refundModel = new Refund();
        $this->bookingModel = new Booking();
        $this->activityLogModel = new ActivityLog();
        $this->paymentMethodModel = new PaymentMethod();
    }

    /**
     * Display a listing of transactions
     */
    public function index() {
        // Get filter parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $paymentMethod = isset($_GET['payment_method']) ? $_GET['payment_method'] : '';
        $dateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : '';
        $dateTo = isset($_GET['date_to']) ? $_GET['date_to'] : '';

        // Build filters array
        $filters = [];
        if (!empty($search)) {
            $filters['search'] = $search;
        }
        if (!empty($status)) {
            $filters['status'] = $status;
        }
        if (!empty($paymentMethod)) {
            $filters['payment_method'] = $paymentMethod;
        }
        if (!empty($dateFrom)) {
            $filters['date_from'] = $dateFrom;
        }
        if (!empty($dateTo)) {
            $filters['date_to'] = $dateTo;
        }

        // Get paginated transactions
        $transactions = $this->transactionModel->getPaginated($page, $limit, $filters);

        // Get available payment methods
        $paymentMethods = $this->paymentMethodModel->getAllActive();
        // Load view
        $this->view('admin/payment/transactions/index', [
            'transactions' => $transactions,
            'paymentMethods' => $paymentMethods,
            'search' => $search,
            'status' => $status,
            'paymentMethod' => $paymentMethod,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);
    }

    /**
     * Display the specified transaction
     */
    public function show($id) {
        // Get transaction details
        $transaction = $this->transactionModel->getById($id);

        if (!$transaction) {
            $this->setFlashMessage('error', 'Giao dịch không tồn tại.');
            $this->redirect(UrlHelper::route('admin/payment/transactions'));
        }

        // Get related invoice
        $invoice = $this->invoiceModel->getByTransactionId($transaction['id']);

        // Get related booking
        $booking = null;
        if (!empty($transaction['booking_id'])) {
            $booking = $this->bookingModel->getById($transaction['booking_id']);
        }
        
        // Get refunds
        $refunds = $this->refundModel->getByTransactionId($transaction['id']);
        
        // Get activity logs
        $activityLogs = $this->activityLogModel->getByEntityId('transaction', $id);

        // Load view
        $this->view('admin/payment/transactions/details', [
            'transaction' => $transaction,
            'invoice' => $invoice,
            'booking' => $booking,
            'refunds' => $refunds,
            'activities' => $activityLogs
        ]);
    }

    /**
     * Show the form for creating a new transaction
     */
    public function create() {
        // Get booking ID from query string if available
        $bookingId = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : null;
        $booking = null;
        
        if ($bookingId) {
            $booking = $this->bookingModel->getById($bookingId);
            if (!$booking) {
                $this->setFlashMessage('error', 'Đặt tour không tồn tại.');
                $this->redirect(UrlHelper::route('admin/bookings'));
            }
        }

        // Get available payment methods
        $paymentMethods = $this->paymentMethodModel->getAllActive();

        // Load view
        $this->view('admin/payment/transactions/create', [
            'booking' => $booking,
            'paymentMethods' => $paymentMethods
        ]);
    }

    /**
     * Store a newly created transaction
     */
    public function store() {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(UrlHelper::route('admin/payment/transactions'));
        }

        // Validate CSRF token
        $this->validateCSRFToken();

        // Validate input
        $validator = new Validator($_POST);
        $validator->required(['customer_name', 'customer_email', 'amount', 'payment_method']);
        $validator->numeric(['amount']);
        $validator->email('customer_email');

        if (!$validator->isValid()) {
            $this->setFlashMessage('error', 'Vui lòng kiểm tra lại thông tin nhập vào: ' . implode(', ', $validator->getErrors()));
            $this->redirect(UrlHelper::route('admin/payment/transactions/create'));
        }

        // Generate transaction code
        $transactionCode = 'TRX-' . date('Ymd') . '-' . uniqid();

        // Prepare data
        $data = [
            'transaction_code' => $transactionCode,
            'booking_id' => !empty($_POST['booking_id']) ? $_POST['booking_id'] : null,
            'customer_name' => $_POST['customer_name'],
            'customer_email' => $_POST['customer_email'],
            'customer_phone' => $_POST['customer_phone'] ?? null,
            'amount' => $_POST['amount'],
            'payment_method' => $_POST['payment_method'],
            'status' => $_POST['status'] ?? 'pending',
            'payment_data' => $_POST['payment_data'] ?? '{}',
            'notes' => $_POST['notes'] ?? null
        ];

        // Create transaction
        $transactionId = $this->transactionModel->create($data);

        if ($transactionId) {
            // Log activity
            $this->activityLogModel->log(
                'transaction',
                $transactionId,
                'Giao dịch mới đã được tạo: ' . $transactionCode
            );

            // Create invoice if requested
            if (isset($_POST['create_invoice']) && $_POST['create_invoice'] === '1') {
                // Generate invoice number
                $invoiceNumber = 'INV-' . date('Ymd') . '-' . uniqid();
                
                // Calculate tax (default 10%)
                $taxRate = 0.1;
                $amount = $_POST['amount'];
                $taxAmount = $amount * $taxRate;
                $totalAmount = $amount + $taxAmount;
                
                // Prepare invoice data
                $invoiceData = [
                    'invoice_number' => $invoiceNumber,
                    'transaction_id' => $transactionId,
                    'customer_name' => $_POST['customer_name'],
                    'customer_email' => $_POST['customer_email'],
                    'customer_phone' => $_POST['customer_phone'] ?? null,
                    'amount' => $amount,
                    'tax_amount' => $taxAmount,
                    'total_amount' => $totalAmount,
                    'status' => ($_POST['status'] === 'completed') ? 'paid' : 'pending',
                    'payment_method' => $_POST['payment_method'],
                    'paid_at' => ($_POST['status'] === 'completed') ? date('Y-m-d H:i:s') : null
                ];
                
                // Create invoice
                $invoiceId = $this->invoiceModel->create($invoiceData);
                
                if ($invoiceId) {
                    $this->activityLogModel->log(
                        'invoice',
                        $invoiceId,
                        'Hóa đơn mới đã được tạo tự động từ giao dịch: ' . $transactionCode
                    );
                }
            }

            // Update booking status if needed
            if (!empty($_POST['booking_id']) && $_POST['status'] === 'completed') {
                $this->bookingModel->updateStatus($_POST['booking_id'], 'confirmed');
                
                $this->activityLogModel->log(
                    'booking',
                    $_POST['booking_id'],
                    'Đặt tour đã được xác nhận do giao dịch đã hoàn thành'
                );
            }

            $this->setFlashMessage('success', 'Giao dịch đã được tạo thành công.');
            $this->redirect(UrlHelper::route('admin/payment/transactions/' . $transactionId));
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi tạo giao dịch. Vui lòng thử lại.');
            $this->redirect(UrlHelper::route('admin/payment/transactions/create'));
        }
    }

    /**
     * Update the status of the specified transaction
     */
    public function updateStatus($id) {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(UrlHelper::route('admin/payment/transactions'));
        }

        // Validate CSRF token
        $this->validateCSRFToken();

        // Get transaction details
        $transaction = $this->transactionModel->getById($id);
        
        if (!$transaction) {
            $this->setFlashMessage('error', 'Giao dịch không tồn tại.');
            $this->redirect(UrlHelper::route('admin/payment/transactions'));
        }

        // Get new status
        $status = $_POST['status'] ?? '';
        if (empty($status)) {
            $this->setFlashMessage('error', 'Trạng thái không hợp lệ.');
            $this->redirect(UrlHelper::route('admin/payment/transactions/' . $id));
        }

        // Update transaction status
        $result = $this->transactionModel->updateStatus($id, $status);

        if ($result) {
            // Log activity
            $this->activityLogModel->log(
                'transaction',
                $id,
                'Trạng thái giao dịch đã được cập nhật thành ' . $status
            );

            // Update related records
            if ($status === 'completed') {
                // Update invoice if exists
                $invoice = $this->invoiceModel->getByTransactionId($id);
                if ($invoice && $invoice['status'] !== 'paid') {
                    $this->invoiceModel->update($invoice['id'], [
                        'status' => 'paid',
                        'paid_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    $this->activityLogModel->log(
                        'invoice',
                        $invoice['id'],
                        'Hóa đơn đã được đánh dấu là đã thanh toán do giao dịch đã hoàn thành'
                    );
                }
                
                // Update booking if exists
                if (!empty($transaction['booking_id'])) {
                    $booking = $this->bookingModel->getById($transaction['booking_id']);
                    if ($booking && $booking['status'] !== 'confirmed') {
                        $this->bookingModel->updateStatus($transaction['booking_id'], 'confirmed');
                        
                        $this->activityLogModel->log(
                            'booking',
                            $transaction['booking_id'],
                            'Đặt tour đã được xác nhận do giao dịch đã hoàn thành'
                        );
                    }
                }
            }

            $this->setFlashMessage('success', 'Trạng thái giao dịch đã được cập nhật thành công.');
            $this->redirect(UrlHelper::route('admin/payment/transactions/' . $id));
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi cập nhật trạng thái giao dịch. Vui lòng thử lại.');
            $this->redirect(UrlHelper::route('admin/payment/transactions/' . $id));
        }
    }

    /**
     * Show the form for editing the specified transaction
     */
    public function edit($id) {
        // Get transaction details
        $transaction = $this->transactionModel->getById($id);
        
        if (!$transaction) {
            $this->setFlashMessage('error', 'Giao dịch không tồn tại.');
            $this->redirect(UrlHelper::route('admin/payment/transactions'));
        }

        // Get available payment methods
        $paymentMethods = $this->paymentMethodModel->getAllActive();

        // Load view
        $this->view('admin/payment/transactions/edit', [
            'transaction' => $transaction,
            'paymentMethods' => $paymentMethods
        ]);
    }

    /**
     * Update the specified transaction
     */
    public function update($id) {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(UrlHelper::route('admin/payment/transactions'));
        }

        // Validate CSRF token
        $this->validateCSRFToken();

        // Get transaction details
        $transaction = $this->transactionModel->getById($id);
        
        if (!$transaction) {
            $this->setFlashMessage('error', 'Giao dịch không tồn tại.');
            $this->redirect(UrlHelper::route('admin/payment/transactions'));
        }

        // Validate input
        $validator = new Validator($_POST);
        $validator->required(['customer_name', 'customer_email', 'amount', 'payment_method', 'status']);
        $validator->numeric(['amount']);
        $validator->email('customer_email');

        if (!$validator->isValid()) {
            $this->setFlashMessage('error', 'Vui lòng kiểm tra lại thông tin nhập vào: ' . implode(', ', $validator->getErrors()));
            $this->redirect(UrlHelper::route('admin/payment/transactions/edit/' . $id));
        }

        // Prepare data
        $data = [
            'customer_name' => $_POST['customer_name'],
            'customer_email' => $_POST['customer_email'],
            'customer_phone' => $_POST['customer_phone'] ?? null,
            'amount' => $_POST['amount'],
            'payment_method' => $_POST['payment_method'],
            'status' => $_POST['status'],
            'payment_data' => $_POST['payment_data'] ?? $transaction['payment_data'],
            'notes' => $_POST['notes'] ?? null
        ];

        // Update transaction
        $result = $this->transactionModel->update($id, $data);

        if ($result) {
            // Log activity
            $this->activityLogModel->log(
                'transaction',
                $id,
                'Giao dịch đã được cập nhật: ' . $transaction['transaction_code']
            );

            // Update related records if status changed
            if ($data['status'] !== $transaction['status']) {
                if ($data['status'] === 'completed') {
                    // Update invoice if exists
                    $invoice = $this->invoiceModel->getByTransactionId($id);
                    if ($invoice && $invoice['status'] !== 'paid') {
                        $this->invoiceModel->update($invoice['id'], [
                            'status' => 'paid',
                            'paid_at' => date('Y-m-d H:i:s')
                        ]);
                        
                        $this->activityLogModel->log(
                            'invoice',
                            $invoice['id'],
                            'Hóa đơn đã được đánh dấu là đã thanh toán do giao dịch đã hoàn thành'
                        );
                    }
                    
                    // Update booking if exists
                    if (!empty($transaction['booking_id'])) {
                        $booking = $this->bookingModel->getById($transaction['booking_id']);
                        if ($booking && $booking['status'] !== 'confirmed') {
                            $this->bookingModel->updateStatus($transaction['booking_id'], 'confirmed');
                            
                            $this->activityLogModel->log(
                                'booking',
                                $transaction['booking_id'],
                                'Đặt tour đã được xác nhận do giao dịch đã hoàn thành'
                            );
                        }
                    }
                }
            }

            $this->setFlashMessage('success', 'Giao dịch đã được cập nhật thành công.');
            $this->redirect(UrlHelper::route('admin/payment/transactions/' . $id));
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi cập nhật giao dịch. Vui lòng thử lại.');
            $this->redirect(UrlHelper::route('admin/payment/transactions/edit/' . $id));
        }
    }

    /**
     * Delete the specified transaction
     */
    public function delete($id) {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(UrlHelper::route('admin/payment/transactions'));
        }

        // Validate CSRF token
        $this->validateCSRFToken();

        // Get transaction details
        $transaction = $this->transactionModel->getById($id);
        
        if (!$transaction) {
            $this->setFlashMessage('error', 'Giao dịch không tồn tại.');
            $this->redirect(UrlHelper::route('admin/payment/transactions'));
        }

        // Check if transaction can be deleted
        $invoice = $this->invoiceModel->getByTransactionId($id);
        if ($invoice && $invoice['status'] === 'paid') {
            $this->setFlashMessage('error', 'Không thể xóa giao dịch đã có hóa đơn thanh toán.');
            $this->redirect(UrlHelper::route('admin/payment/transactions/' . $id));
        }

        $refunds = $this->refundModel->getByTransactionId($id);
        if (!empty($refunds)) {
            $this->setFlashMessage('error', 'Không thể xóa giao dịch đã có yêu cầu hoàn tiền.');
            $this->redirect(UrlHelper::route('admin/payment/transactions/' . $id));
        }

        // Delete transaction
        $result = $this->transactionModel->delete($id);

        if ($result) {
            // Log activity
            $this->activityLogModel->log(
                'transaction',
                $id,
                'Giao dịch đã bị xóa: ' . $transaction['transaction_code']
            );

            // Delete related invoice if exists
            if ($invoice) {
                $this->invoiceModel->delete($invoice['id']);
                
                $this->activityLogModel->log(
                    'invoice',
                    $invoice['id'],
                    'Hóa đơn đã bị xóa do giao dịch liên quan đã bị xóa'
                );
            }

            $this->setFlashMessage('success', 'Giao dịch đã được xóa thành công.');
            $this->redirect(UrlHelper::route('admin/payment/transactions'));
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi xóa giao dịch. Vui lòng thử lại.');
            $this->redirect(UrlHelper::route('admin/payment/transactions/' . $id));
        }
    }
}