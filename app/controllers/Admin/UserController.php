<?php


namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\UrlHelper;
use App\Models\User;
use App\Models\Role;

class UserController extends BaseController
{
    private $userModel;
    private $roleModel;


    public function __construct()
    {
        // Áp dụng middleware để kiểm tra quyền admin
        $route = $this->getRouteByRole();
        $roleBase = 'admin';
        $role = $this->getRole();
        if ($role !== $roleBase) {
            $this->redirect($route);
        }


        $this->userModel = new User();
        $this->roleModel = new Role();
    }


    // -------------
    // Users
    // -------------

    public function index()
    {
        $currentUser = $this->getCurrentUser();

        $users = [];
        $query = $this->userModel->getAll();
        $roles = $this->roleModel->getAll();

        foreach ($query as $user) {
            $userWithRole = $this->userModel->getUserWithRole($user['id']);
            $users[] = $userWithRole;
        }

        $this->view('admin/users/index', [
            'user' => $currentUser,
            'users' => $users,
            'roles' => $roles
        ]);
    }


    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $full_name = trim($_POST['full_name']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = intval($_POST['role']); // Đảm bảo role là số
            $status = trim($_POST['status']);
            $avatar = '';

            $errors = [];

            // Validate inputs
            if (empty($username) || strlen($username) < 6) {
                $errors['username'] = 'Tên người dùng phải có ít nhất 6 ký tự';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Vui lòng nhập email hợp lệ';
            } elseif ($this->userModel->findByEmail($email)) {
                $errors['email'] = 'Email này đã được sử dụng';
            }

            // Handle file upload

            $data = [
                'username' => $username,
                'email' => $email,
                'full_name' => $full_name,
                'password' => $password,
                'role_id' => $role,
                'status' => $status,
                'avatar' => $avatar
            ];

            $this->userModel->create($data); // Đảm bảo truyền đúng kiểu dữ liệu
            $this->setFlashMessage('success', 'Tạo người dùng thanh cong');
            header('Location:' . UrlHelper::route('/admin/users/index'));
            exit;
            // Trả lại view với lỗi và dữ liệu nhập trước đó
            $this->view('admin/users/create', [
                'errors' => $errors,
                'input' => $_POST
            ]);
        } else {
            // Lấy danh sách roles (nếu cần)
            $roles = $this->userModel->getAll();

            // Hiển thị form tạo người dùng
            $this->view('admin/users/create', [
                'roles' => $roles
            ]);
        }
    }

    public function edit($id)
    {
        $currentUser = $this->userModel->findById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo 'EDIT';
            // EDIT TRRONG NÀY
        } else {
            $this->view('admin/users/edit', [
                'user' => $currentUser,
            ]);
        }
    }

    public function deleteUser($id)
    {
        $currentUser = $this->getCurrentUser();

        // Không cho phép xóa chính mình
        if ($id == $currentUser['id']) {
            $this->redirect(UrlHelper::route('/admin/users?error=cannot_delete_self'));
            return;
        }

        $user = $this->userModel->getById($id);

        if (!$user) {
            $this->redirect(UrlHelper::route('/admin/users?error=user_not_found'));
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->userModel->delete($id)) {
                $this->redirect(UrlHelper::route('/admin/users?success=delete_success'));
            } else {
                $this->redirect(UrlHelper::route('/admin/users?error=delete_failed'));
            }
        } else {
            $this->view('admin/delete_user', [
                'user' => $currentUser,
                'deleteUser' => $user
            ]);
        }
    }
}
