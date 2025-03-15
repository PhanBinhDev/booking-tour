<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Booking;
use App\Models\ActivityLog;
use App\Helpers\UrlHelper;
use App\Models\Payment;
use App\Models\Settings;

class InvoiceController extends BaseController {
    protected $invoiceModel;
    protected $transactionModel;
    protected $bookingModel;
    protected $activityLogModel;
    protected $paymentModel;
    protected $settingsModel;

    public function __construct() {
        $this->invoiceModel = new Invoice();
        $this->transactionModel = new Transaction();
        $this->bookingModel = new Booking();
        $this->activityLogModel = new ActivityLog();
        $this->paymentModel = new Payment();
        $this->settingsModel = new Settings();
    }

    /**
     * Display list of invoices
     */
    public function index() {
        // Get page and limit from request
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        
        // Get filters from request
        $filters = [
            'search' => $_GET['search'] ?? '',
            'status' => $_GET['status'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? ''
        ];
        
        // Get paginated invoices
        $result = $this->invoiceModel->getPaginated($page, $limit, $filters);
        


        // Pass data to view
        $this->view('admin/payment/invoices/index', [
            'invoices' => $result['data'],
            'pagination' => $result['pagination'],
            'filters' => $filters,
        ]);
    }

    /**
     * Display invoice details
     */
    public function show($id) {
        // Get invoice by ID
        $invoice = $this->invoiceModel->getById($id);
        
        if (!$invoice) {
            $this->setFlashMessage('error', 'Hóa đơn không tồn tại');
            $this->redirect(UrlHelper::route('admin/payment/invoices'));
        }
        
        // Get related booking if exists
        $booking = null;
        if (!empty($invoice['booking_id'])) {
            $booking = $this->bookingModel->getById($invoice['booking_id']);
        }
        
        // Get related transaction if exists
        $transaction = null;
        if (!empty($invoice['transaction_id'])) {
            $transaction = $this->transactionModel->getByIdWithDetails($invoice['transaction_id']);
        }
        
        // Get activity logs
        $activities = $this->activityLogModel->getByEntityId('invoice', $id);
        
        // Parse invoice items
        $invoiceItems = [];
        if (!empty($invoice['items'])) {
            $invoiceItems = json_decode($invoice['items'], true) ?? [];
        }
        
        // Pass data to view
        $this->view('admin/payment/invoices/details', [
            'invoice' => $invoice,
            'booking' => $booking,
            'transaction' => $transaction,
            'activities' => $activities,
            'invoiceItems' => $invoiceItems
        ]);
    }

    // /**
    //  * Display invoice print view
    //  */
    public function printInvoice($id) {
        // Get invoice by ID with all related information
        $invoice = $this->invoiceModel->getById($id);
        
        if (!$invoice) {
            $this->setFlashMessage('error', 'Hóa đơn không tồn tại');
            $this->redirect(UrlHelper::route('admin/payment/invoices'));
        }
        
        // Get related booking if exists
        $booking = null;
        if (!empty($invoice['booking_id'])) {
            $booking = $this->bookingModel->getById($invoice['booking_id']);
        }
        
        // Get related transaction through payment
        $transaction = null;
        $payment = null;
        if (!empty($invoice['payment_id'])) {
            $payment = $this->paymentModel->findById($invoice['payment_id']);
            if ($payment && !empty($payment['transaction_id_internal'])) {
                $transaction = $this->transactionModel->getById($payment['transaction_id_internal']);
            }
        }
        
        // Consolidate customer information from available sources
        $customerName = $invoice['billing_name'] ?? $transaction['customer_name'] ?? 
                    ($booking ? $booking['customer_name'] : 'Không xác định');
        $customerEmail = $invoice['billing_email'] ?? $transaction['customer_email'] ?? 
                        ($booking ? $booking['customer_email'] : 'Không xác định');
        $customerPhone = $invoice['billing_phone'] ?? $transaction['customer_phone'] ?? 
                        ($booking ? $booking['customer_phone'] : '');
        $customerAddress = $invoice['billing_address'] ?? '';
        
        // Add consolidated customer info to invoice for the view
        $invoice['customer_name'] = $customerName;
        $invoice['customer_email'] = $customerEmail;
        $invoice['customer_phone'] = $customerPhone;
        $invoice['customer_address'] = $customerAddress;
    
        // Get payment method information
        $paymentMethodName = $invoice['payment_method_name'] ?? 
                            ($payment ? $payment['payment_method'] : 'Chuyển khoản');
        $invoice['payment_method'] = $paymentMethodName;
        
        // Get company information from settings
        $companyInfo = [
            'name' => $this->getSettingValue('company_name', 'Công ty Du lịch Di Travel'),
            'address' => $this->getSettingValue('company_address', '123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh'),
            'phone' => $this->getSettingValue('company_phone', '0123 456 789'),
            'email' => $this->getSettingValue('company_email', 'info@ditravel.com'),
            'tax_id' => $this->getSettingValue('company_tax_id', '0123456789'),
            'website' => $this->getSettingValue('company_website', 'www.ditravel.com')
        ];
        
        // Get payment terms
        $paymentTerms = $this->getSettingValue('payment_terms', 'Hóa đơn có giá trị trong vòng 30 ngày kể từ ngày phát hành.');
        
        // Parse invoice items or create default if none exists
        $invoiceItems = [];
        if (!empty($invoice['items'])) {
            $invoiceItems = json_decode($invoice['items'], true) ?? [];
        }
        
        // If no items but we have booking, create items based on booking
        if (empty($invoiceItems) && $booking) {
            $invoiceItems = [
                [
                    'name' => $booking['tour_name'] ?? 'Tour du lịch',
                    'description' => 'Mã đặt tour: ' . $booking['booking_number'],
                    'quantity' => ($booking['adults'] ?? 0) + ($booking['children'] ?? 0),
                    'price' => $invoice['amount'] / (($booking['adults'] ?? 0) + ($booking['children'] ?? 0)),
                    'total' => $invoice['amount']
                ]
            ];
            // Update invoice items
            $invoice['items'] = json_encode($invoiceItems);
        }
        
        // Log activity
        $this->activityLogModel->log(
            'invoice',
            $id,
            'In hóa đơn #' . $invoice['invoice_number'],
            $this->getCurrentUser()['id']
        );
        
        // Pass data to view
        $this->view('admin/payment/invoices/print', [
            'invoice' => $invoice,
            'booking' => $booking,
            'transaction' => $transaction,
            'invoiceItems' => $invoiceItems,
            'companyInfo' => $companyInfo,
            'paymentTerms' => $paymentTerms
        ]);
    }

    /**
     * Helper method to get setting value
     */
    private function getSettingValue($key, $default = '') {
        // If you have a settings model, use it
        if (isset($this->settingsModel)) {
            $value = $this->settingsModel->getValue($key);
            return $value !== null ? $value : $default;
        }
        return $default;
    }

    // /**
    //  * Update invoice status
    //  */
    // public function updateStatus($id) {
    //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //         $this->redirect(UrlHelper::route('admin/payment/invoices/' . $id));
    //     }
        
    //     // Get invoice by ID
    //     $invoice = $this->invoiceModel->findById($id);
        
    //     if (!$invoice) {
    //         $this->setFlashMessage('error', 'Hóa đơn không tồn tại');
    //         $this->redirect(UrlHelper::route('admin/payment/invoices'));
    //     }
        
    //     // Get new status from request
    //     $status = $_POST['status'] ?? '';
        
    //     if (!in_array($status, ['pending', 'paid', 'cancelled'])) {
    //         $this->setFlashMessage('error', 'Trạng thái không hợp lệ');
    //         $this->redirect(UrlHelper::route('admin/payment/invoices/' . $id));
    //     }
        
    //     // Update invoice status
    //     $success = $this->invoiceModel->updateStatus($id, $status);
        
    //     if ($success) {
    //         // Log activity
    //         $this->activityLogModel->create([
    //             'user_id' => $this->getCurrentUserId(),
    //             'action' => 'update_status',
    //             'entity_type' => 'invoice',
    //             'entity_id' => $id,
    //             'description' => 'Cập nhật trạng thái hóa đơn #' . $invoice['invoice_number'] . ' thành "' . $status . '"'
    //         ]);
            
    //         $this->setFlashMessage('success', 'Cập nhật trạng thái hóa đơn thành công');
    //     } else {
    //         $this->setFlashMessage('error', 'Không thể cập nhật trạng thái hóa đơn');
    //     }
        
    //     $this->redirect(UrlHelper::route('admin/payment/invoices/' . $id));
    // }

    // /**
    //  * Generate invoice from transaction
    //  */
    // public function generateFromTransaction($transactionId) {
    //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //         $this->redirect(UrlHelper::route('admin/payment/transactions/' . $transactionId));
    //     }
        
    //     // Check if invoice already exists for this transaction
    //     $existingInvoice = $this->invoiceModel->getByTransactionId($transactionId);
        
    //     if ($existingInvoice) {
    //         $this->setFlashMessage('error', 'Hóa đơn đã tồn tại cho giao dịch này');
    //         $this->redirect(UrlHelper::route('admin/payment/transactions/' . $transactionId));
    //     }
        
    //     // Get transaction
    //     $transaction = $this->transactionModel->findById($transactionId);
        
    //     if (!$transaction) {
    //         $this->setFlashMessage('error', 'Giao dịch không tồn tại');
    //         $this->redirect(UrlHelper::route('admin/payment/transactions'));
    //     }
        
    //     // Generate invoice
    //     $invoiceId = $this->invoiceModel->generateFromTransaction($transaction);
        
    //     if ($invoiceId) {
    //         // Log activity
    //         $this->activityLogModel->create([
    //             'user_id' => $this->getCurrentUserId(),
    //             'action' => 'create',
    //             'entity_type' => 'invoice',
    //             'entity_id' => $invoiceId,
    //             'description' => 'Tạo hóa đơn mới từ giao dịch #' . $transaction['transaction_code']
    //         ]);
            
    //         $this->setFlashMessage('success', 'Tạo hóa đơn thành công');
    //         $this->redirect(UrlHelper::route('admin/payment/invoices/' . $invoiceId));
    //     } else {
    //         $this->setFlashMessage('error', 'Không thể tạo hóa đơn');
    //         $this->redirect(UrlHelper::route('admin/payment/transactions/' . $transactionId));
    //     }
    // }

    // /**
    //  * Send invoice by email
    //  */
    // public function sendByEmail($id) {
    //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //         $this->redirect(UrlHelper::route('admin/payment/invoices/' . $id));
    //     }
        
    //     // Get invoice by ID
    //     $invoice = $this->invoiceModel->findById($id);
        
    //     if (!$invoice) {
    //         $this->setFlashMessage('error', 'Hóa đơn không tồn tại');
    //         $this->redirect(UrlHelper::route('admin/payment/invoices'));
    //     }
        
    //     // Check if customer email exists
    //     if (empty($invoice['customer_email'])) {
    //         $this->setFlashMessage('error', 'Không có địa chỉ email khách hàng');
    //         $this->redirect(UrlHelper::route('admin/payment/invoices/' . $id));
    //     }
        
    //     // Send email logic would go here
    //     // This is a placeholder for actual email sending implementation
        
    //     // Log activity
    //     $this->activityLogModel->create([
    //         'user_id' => $this->getCurrentUserId(),
    //         'action' => 'send_email',
    //         'entity_type' => 'invoice',
    //         'entity_id' => $id,
    //         'description' => 'Gửi hóa đơn #' . $invoice['invoice_number'] . ' qua email đến ' . $invoice['customer_email']
    //     ]);
        
    //     $this->setFlashMessage('success', 'Hóa đơn đã được gửi qua email');
    //     $this->redirect(UrlHelper::route('admin/payment/invoices/' . $id));
    // }

    // /**
    //  * Display invoice statistics
    //  */
    // public function statistics() {
    //     // Get period from request
    //     $period = $_GET['period'] ?? 'monthly';
    //     $startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-1 year'));
    //     $endDate = $_GET['end_date'] ?? date('Y-m-d');
        
    //     // Get statistics
    //     $statistics = $this->invoiceModel->getStatistics($period, $startDate, $endDate);
        
    //     // Pass data to view
    //     $this->view('admin/payment/invoices/statistics', [
    //         'statistics' => $statistics,
    //         'period' => $period,
    //         'startDate' => $startDate,
    //         'endDate' => $endDate
    //     ]);
    // }
}