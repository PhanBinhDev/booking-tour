<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\UrlHelper;
use App\Models\Refund;
use App\Models\Transaction;
use App\Models\ActivityLog;
use App\Helpers\Validator;

class RefundController extends BaseController {
    private $refundModel;
    private $transactionModel;
    private $activityLogModel;

    public function __construct() {
        $this->refundModel = new Refund();
        $this->transactionModel = new Transaction();
        $this->activityLogModel = new ActivityLog();
    }

    /**
     * Display a listing of refunds
     */
    public function index() {
        // Get filter parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';
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
        if (!empty($dateFrom)) {
            $filters['date_from'] = $dateFrom;
        }
        if (!empty($dateTo)) {
            $filters['date_to'] = $dateTo;
        }

        // Get paginated refunds
        $refunds = $this->refundModel->getPaginated($page, $limit, $filters);

        // Load view
        $this->view('admin/payment/refunds/index', [
            'refunds' => $refunds,
            'search' => $search,
            'status' => $status,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);
    }

    /**
     * Display the specified refund
     */
    public function show($id) {
        // Get refund details
        $refund = $this->refundModel->getById($id);
        
        if (!$refund) {
            $this->setFlashMessage('error', 'Yêu cầu hoàn tiền không tồn tại.');
            $this->redirect(UrlHelper::route('admin/payment/refunds'));
        }

        // Get related transaction
        $transaction = $this->transactionModel->getById($refund['transaction_id']);
        
        // Get activity logs
        $activityLogs = $this->activityLogModel->getByEntityId('refund', $id);

        // Load view
        $this->view('admin/payment/refunds/details', [
            'refund' => $refund,
            'transaction' => $transaction,
            'activities' => $activityLogs
        ]);
    }

    /**
     * Show the form for creating a new refund
     */
    public function create() {
        // Get transaction ID from query string if available
        $transactionId = isset($_GET['transaction_id']) ? (int)$_GET['transaction_id'] : null;
        $transaction = null;
        
        if ($transactionId) {
            $transaction = $this->transactionModel->getById($transactionId);
            if (!$transaction) {
                $this->setFlashMessage('error', 'Giao dịch không tồn tại.');
                $this->redirect(UrlHelper::route('admin/payment/transactions'));
            }
            
            // Check if transaction is completed
            if ($transaction['status'] !== 'completed') {
                $this->setFlashMessage('error', 'Chỉ có thể hoàn tiền cho giao dịch đã hoàn thành.');
                $this->redirect(UrlHelper::route('admin/payment/transactions/' . $transactionId));
            }
            
            // Check if transaction already has a refund
            $existingRefunds = $this->refundModel->getByTransactionId($transactionId);
            if (!empty($existingRefunds)) {
                $this->setFlashMessage('error', 'Giao dịch này đã có yêu cầu hoàn tiền.');
                $this->redirect(UrlHelper::route('admin/payment/transactions/' . $transactionId));
            }
        }

        // Load view
        $this->view('admin/payment/refunds/create', [
            'transaction' => $transaction
        ]);
    }

    /**
     * Store a newly created refund
     */
    public function store() {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(UrlHelper::route('admin/payment/refunds'));
        }

        // Validate CSRF token
        $this->validateCSRFToken();

        // Validate input
        $validator = new Validator($_POST);
        $validator->required(['transaction_id', 'amount', 'reason']);
        $validator->numeric(['amount']);

        if (!$validator->isValid()) {
            $this->setFlashMessage('error', 'Vui lòng kiểm tra lại thông tin nhập vào: ' . implode(', ', $validator->getErrors()));
            $this->redirect(UrlHelper::route('admin/payment/refunds/create'));
        }

        // Get transaction details
        $transactionId = $_POST['transaction_id'];
        $transaction = $this->transactionModel->getById($transactionId);
        
        if (!$transaction) {
            $this->setFlashMessage('error', 'Giao dịch không tồn tại.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/create'));
        }
        
        // Check if transaction is completed
        if ($transaction['status'] !== 'completed') {
            $this->setFlashMessage('error', 'Chỉ có thể hoàn tiền cho giao dịch đã hoàn thành.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/create'));
        }
        
        // Check if refund amount is valid
        $amount = (float)$_POST['amount'];
        if ($amount <= 0 || $amount > $transaction['amount']) {
            $this->setFlashMessage('error', 'Số tiền hoàn không hợp lệ.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/create?transaction_id=' . $transactionId));
        }

        // Prepare data
        $data = [
            'transaction_id' => $transactionId,
            'booking_id' => $transaction['booking_id'] ?? null,
            'amount' => $amount,
            'reason' => $_POST['reason'],
            'status' => $_POST['status'] ?? 'pending',
            'refund_data' => $_POST['refund_data'] ?? '{}',
            'notes' => $_POST['notes'] ?? null,
            'update_transaction' => isset($_POST['update_transaction']) && $_POST['update_transaction'] === '1'
        ];

        // Process refund
        $refundId = $this->refundModel->process($data);

        if ($refundId) {
            // Log activity
            $this->activityLogModel->log(
                'refund',
                $refundId,
                'Yêu cầu hoàn tiền mới đã được tạo cho giao dịch: ' . $transaction['transaction_code']
            );

            // Update transaction status if requested
            if (isset($_POST['update_transaction']) && $_POST['update_transaction'] === '1') {
                $this->activityLogModel->log(
                    'transaction',
                    $transactionId,
                    'Giao dịch đã được đánh dấu là đã hoàn tiền'
                );
            }

            $this->setFlashMessage('success', 'Yêu cầu hoàn tiền đã được tạo thành công.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/' . $refundId));
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi tạo yêu cầu hoàn tiền. Vui lòng thử lại.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/create?transaction_id=' . $transactionId));
        }
    }

    /**
     * Process the specified refund
     */
    public function process($id) {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(UrlHelper::route('admin/payment/refunds'));
        }

        // Validate CSRF token
        $this->validateCSRFToken();

        // Get refund details
        $refund = $this->refundModel->getById($id);
        
        if (!$refund) {
            $this->setFlashMessage('error', 'Yêu cầu hoàn tiền không tồn tại.');
            $this->redirect(UrlHelper::route('admin/payment/refunds'));
        }
        
        // Check if refund is pending
        if ($refund['status'] !== 'pending') {
            $this->setFlashMessage('error', 'Chỉ có thể xử lý yêu cầu hoàn tiền đang chờ xử lý.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/' . $id));
        }

        // Get new status
        $status = $_POST['status'] ?? '';
        if (empty($status) || !in_array($status, ['completed', 'rejected'])) {
            $this->setFlashMessage('error', 'Trạng thái không hợp lệ.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/' . $id));
        }

        // Prepare data
        $data = [
            'status' => $status,
            'notes' => $_POST['notes'] ?? $refund['notes']
        ];

        // Update refund status
        $result = $this->refundModel->updateStatus($id, $status, $data);

        if ($result) {
            // Log activity
            $statusText = ($status === 'completed') ? 'đã hoàn tiền' : 'đã từ chối';
            $this->activityLogModel->log(
                'refund',
                $id,
                'Yêu cầu hoàn tiền đã được ' . $statusText
            );

            // Update transaction status if refund is completed
            if ($status === 'completed') {
                $transaction = $this->transactionModel->getById($refund['transaction_id']);
                
                // If refund amount equals transaction amount, mark transaction as refunded
                if ($refund['amount'] == $transaction['amount']) {
                    $this->transactionModel->updateStatus($refund['transaction_id'], 'refunded');
                    
                    $this->activityLogModel->log(
                        'transaction',
                        $refund['transaction_id'],
                        'Giao dịch đã được đánh dấu là đã hoàn tiền'
                    );
                } 
                // If partial refund, mark transaction as partially refunded
                else {
                    $this->transactionModel->updateStatus($refund['transaction_id'], 'partially_refunded');
                    
                    $this->activityLogModel->log(
                        'transaction',
                        $refund['transaction_id'],
                        'Giao dịch đã được đánh dấu là đã hoàn tiền một phần'
                    );
                }
            }

            $this->setFlashMessage('success', 'Yêu cầu hoàn tiền đã được xử lý thành công.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/' . $id));
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi xử lý yêu cầu hoàn tiền. Vui lòng thử lại.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/' . $id));
        }
    }

    /**
     * Show the form for editing the specified refund
     */
    public function edit($id) {
        // Get refund details
        $refund = $this->refundModel->getById($id);
        
        if (!$refund) {
            $this->setFlashMessage('error', 'Yêu cầu hoàn tiền không tồn tại.');
            $this->redirect(UrlHelper::route('admin/payment/refunds'));
        }
        
        // Check if refund can be edited
        if ($refund['status'] !== 'pending') {
            $this->setFlashMessage('error', 'Chỉ có thể chỉnh sửa yêu cầu hoàn tiền đang chờ xử lý.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/' . $id));
        }

        // Get related transaction
        $transaction = $this->transactionModel->getById($refund['transaction_id']);

        // Load view
        $this->view('admin/payment/refunds/edit', [
            'refund' => $refund,
            'transaction' => $transaction
        ]);
    }

    /**
     * Update the specified refund
     */
    public function update($id) {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(UrlHelper::route('admin/payment/refunds'));
        }

        // Validate CSRF token
        $this->validateCSRFToken();

        // Get refund details
        $refund = $this->refundModel->getById($id);
        
        if (!$refund) {
            $this->setFlashMessage('error', 'Yêu cầu hoàn tiền không tồn tại.');
            $this->redirect(UrlHelper::route('admin/payment/refunds'));
        }
        
        // Check if refund can be edited
        if ($refund['status'] !== 'pending') {
            $this->setFlashMessage('error', 'Chỉ có thể chỉnh sửa yêu cầu hoàn tiền đang chờ xử lý.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/' . $id));
        }

        // Validate input
        $validator = new Validator($_POST);
        $validator->required(['amount', 'reason']);
        $validator->numeric(['amount']);

        if (!$validator->isValid()) {
            $this->setFlashMessage('error', 'Vui lòng kiểm tra lại thông tin nhập vào: ' . implode(', ', $validator->getErrors()));
            $this->redirect(UrlHelper::route('admin/payment/refunds/edit/' . $id));
        }

        // Get transaction details
        $transaction = $this->transactionModel->getById($refund['transaction_id']);
        
        // Check if refund amount is valid
        $amount = (float)$_POST['amount'];
        if ($amount <= 0 || $amount > $transaction['amount']) {
            $this->setFlashMessage('error', 'Số tiền hoàn không hợp lệ.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/edit/' . $id));
        }

        // Prepare data
        $data = [
            'amount' => $amount,
            'reason' => $_POST['reason'],
            'status' => $_POST['status'] ?? $refund['status'],
            'refund_data' => $_POST['refund_data'] ?? $refund['refund_data'],
            'notes' => $_POST['notes'] ?? null
        ];

        // Update refund
        $result = $this->refundModel->update($id, $data);

        if ($result) {
            // Log activity
            $this->activityLogModel->log(
                'refund',
                $id,
                'Yêu cầu hoàn tiền đã được cập nhật'
            );

            $this->setFlashMessage('success', 'Yêu cầu hoàn tiền đã được cập nhật thành công.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/' . $id));
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi cập nhật yêu cầu hoàn tiền. Vui lòng thử lại.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/edit/' . $id));
        }
    }

    /**
     * Delete the specified refund
     */
    public function delete($id) {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(UrlHelper::route('admin/payment/refunds'));
        }

        // Validate CSRF token
        $this->validateCSRFToken();

        // Get refund details
        $refund = $this->refundModel->getById($id);
        
        if (!$refund) {
            $this->setFlashMessage('error', 'Yêu cầu hoàn tiền không tồn tại.');
            $this->redirect(UrlHelper::route('admin/payment/refunds'));
        }
        
        // Check if refund can be deleted
        if ($refund['status'] !== 'pending') {
            $this->setFlashMessage('error', 'Chỉ có thể xóa yêu cầu hoàn tiền đang chờ xử lý.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/' . $id));
        }

        // Delete refund
        $result = $this->refundModel->delete($id);

        if ($result) {
            // Log activity
            $this->activityLogModel->log(
                'refund',
                $id,
                'Yêu cầu hoàn tiền đã bị xóa'
            );

            $this->setFlashMessage('success', 'Yêu cầu hoàn tiền đã được xóa thành công.');
            $this->redirect(UrlHelper::route('admin/payment/refunds'));
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi xóa yêu cầu hoàn tiền. Vui lòng thử lại.');
            $this->redirect(UrlHelper::route('admin/payment/refunds/' . $id));
        }
    }
}