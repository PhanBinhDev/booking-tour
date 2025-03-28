<?php

namespace App\Controllers\Admin;

class UserController
{
    public function deleteSuccess()
    {
        $this->view('admin/users/delete-success');
    }
}
