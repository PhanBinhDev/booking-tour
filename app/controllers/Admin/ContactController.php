<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\UrlHelper;
use App\Models\Contact;

class ContactController extends BaseController{
        private $contactModel;

        public function __construct(){
        
            // Áp dụng middleware để kiểm tra quyền admin
            // $route = $this->getRouteByRole();
            // $roleBase = 'admin';
            // $role = $this->getRole();
            // if ($role !== $roleBase) {
            //     $this->redirect($route);
            // }

            $this->contactModel = new Contact();
        }

        public function index(){

            $contacts = $this->contactModel->getContacts();
            
            // $contactById = $this->contactModel->getContactById($id);
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? '';
                $name = $_POST['name'] ?? '';
                $email = $_POST['email'] ?? '';
                $phone = $_POST['phone'] ?? '';
                $subject = $_POST['subject'] ?? '';
                $message = $_POST['message'] ?? '';
                $status = $_POST['status'] ?? '';
                $ip_address = $_POST['ip_address'] ?? '';
                $user_agent = $_POST['user_agent'] ?? '';
                $created_at = $_POST['created_at'] ?? '';

                $data=[
                    'id' => $id,
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'subject' => $subject,
                    'message' => $message,
                    'status' => $status,
                    'ip_address' => $ip_address,
                    'user_agent' => $user_agent,
                    'created_at' => $created_at,
                ];
                $this->contactModel->createContact($data);
            }


            $this->view('admin/contact/index', ["contacts" => $contacts]);

        }

}