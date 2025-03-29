<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\EmailHelper;
use App\Helpers\UrlHelper;
use App\Models\Contact;

class ContactController extends BaseController
{
    private $contactModel;

    public function __construct()
    {

        // Áp dụng middleware để kiểm tra quyền admin
        // $route = $this->getRouteByRole();
        // $roleBase = 'admin';
        // $role = $this->getRole();
        // if ($role !== $roleBase) {
        //     $this->redirect($route);
        // }

        $this->contactModel = new Contact();
    }

    public function index()
    {
        // Get query parameters for filtering and pagination
        $status = $_GET['status'] ?? '';
        $search = $_GET['search'] ?? '';
        $page = (int)($_GET['page'] ?? 1);
        $limit = (int)($_GET['limit'] ?? 10);

        // Prepare filters
        $filters = [];
        if (!empty($status)) {
            $filters['status'] = $status;
        }

        // Configure pagination options
        $options = [
            'table_alias' => 'c', // Alias for the contacts table
            'columns' => 'c.*', // Select all columns from contacts table
            'filters' => $filters,
            'sort' => 'created_at',
            'direction' => 'desc', // Newest contacts first
            'page' => $page,
            'limit' => $limit,
            'search_term' => !empty($search) ? "%$search%" : "",
            'search_fields' => ['name', 'email', 'phone', 'subject', 'message'], // Fields to search in
        ];

        // Get paginated contacts
        $result = $this->contactModel->getPaginatedCustom($options);

        // Extract data
        $contacts = $result['items'];
        $pagination = $result['pagination'];

        // Pass data to view
        $this->view('admin/contact/index', [
            "contacts" => $contacts,
            "pagination" => $pagination,
            "currentStatus" => $status,
            "currentSearch" => $search
        ]);
    }

    public function getStatusLabel($status)
    {
        switch ($status) {
            case 'new':
                return 'Mới';
            case 'read':
                return 'Đã đọc';
            case 'replied':
                return 'Đã trả lời';
            case 'archived':
                return 'Đã lưu trữ';
            default:
                return $status;
        }
    }

    public function getStatusClass($status)
    {
        switch ($status) {
            case 'new':
                return 'bg-yellow-100 text-yellow-800';
            case 'read':
                return 'bg-blue-100 text-blue-800';
            case 'replied':
                return 'bg-green-100 text-green-800';
            case 'archived':
                return 'bg-gray-100 text-gray-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    public function details($id)
    {
        $contact = $this->contactModel->getContactById($id);
        $this->view('admin/contact/details', ["contact" => $contact]);
    }

    public function delete($id)
    {
        $this->contactModel->delete($id, 'contacts');
        $this->setFlashMessage('success', 'Liên hệ đã được xóa');
        $this->redirect(UrlHelper::route('admin/contacts'));
    }

    public function archive()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $this->contactModel->archive($id);
            $this->setFlashMessage('success', 'Liên hệ đã được lưu trữ');
            $this->redirect(UrlHelper::route('admin/contacts'));
        }
    }

    public function markRead()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $this->contactModel->markRead($id);
            $this->setFlashMessage('success', 'Liên hệ đã được đọc');
            $this->redirect(UrlHelper::route('admin/contacts'));
        }
    }

    public function reply($id)
    {
        if (!$id) {
            $this->redirect(UrlHelper::route('admin/contacts'));
        }

        $contact = $this->contactModel->getById($id);
        if (!$contact) {
            $this->redirect(UrlHelper::route('admin/contacts'));
        }

        $this->view('admin/contact/reply', [
            'contact' => $contact
        ]);
    }

    public function sendReply()
    {
        $contactId = $_POST['contact_id'] ?? null;
        $recipientEmail = $_POST['recipient_email'] ?? '';
        $recipientName = $_POST['recipient_name'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';

        if (!$contactId || !$recipientEmail || !$subject || !$message) {
            // Handle error - redirect back with error message
            $this->redirect('admin/contacts/reply?id=' . $contactId . '&error=missing_fields');
        }

        $result = EmailHelper::sendEmail($recipientEmail, $subject, $message);
        $result = EmailHelper::sendContactReply($recipientEmail, $recipientName, $subject, $message);


        if ($result) {
            $this->contactModel->updateStatus($contactId, 'replied');
            $this->setFlashMessage('success', 'Trả lời liên hệ thành công');
            $this->redirect(UrlHelper::route('admin/contacts/view/' . $contactId . '?success=reply_sent'));
        } else {
            $this->setFlashMessage('error', 'Không thành công');
            $this->redirect(UrlHelper::route('admin/contacts/reply?id=' . $contactId . '&error=email_failed'));
        }
    }
}