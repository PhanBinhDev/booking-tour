<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Booking;
use App\Models\Categories;
use App\Models\Tour;
use App\Models\Role;
use App\Helpers\CloudinaryHelper;
use App\Helpers\UrlHelper;

use Exception;


class ToursController extends BaseController
{
    private $tourModel;
    private $bookingModel;
    private $categoriesModel;
    private $roleModel;

    public function __construct()
    {

        $this->tourModel = new Tour();
        $this->bookingModel = new Booking();
        $this->categoriesModel = new Categories();
        $this->roleModel = new Role();
    }

    public function bookings()
    {
        $bookings = $this->bookingModel->getAllBookings();
        $this->view('admin/bookings', ['bookings' => $bookings]);
    }

    public function deleteBooking($id)
    {
        $booking = $this->bookingModel->getById($id);
        print_r($booking);
        die;
    }


    public function index()
    {
        $tours = $this->tourModel->getAll();
        $this->view('admin/tours/index', ['tours' => $tours]);
    }

    public function tourDetail($id)
    {
        echo "ID" . $id;
        die;
        $this->view('home/tour-details');
    }

    public function createTour()
    {
        $this->view('admin/tours/createTour');
    }

    public function editTour($id)
    {
        $currentTour = $this->tourModel->getTourDetails($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo 'EDIT';
            // EDIT TRRONG NÀY
        } else {
            $this->view('admin/tours/editTour', [
                'tour' => $currentTour,
            ]);
        }
    }

    public function categories()
    {
        $categories = $this->categoriesModel->getAll();
        $this->view('admin/tours/categories', ['categories' => $categories]);
    }

    public function createCategory()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = $_POST['name'] ?? '';
            $slug = $_POST['slug'] ?? '';
            $description = $_POST['description'] ?? '';
            $status = $_POST['status'] ?? '';
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            try {
                if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception('Không có file');
                }

                $image = CloudinaryHelper::uploadImage($_FILES['image']['tmp_name'], [
                    'folder' => 'categories'
                ]);

                echo $image['secure_url'];
            } catch (Exception $e) {
                echo "Lỗi khi upload ảnh: " . $e->getMessage();
            }
            die;

            $this->categoriesModel->createCategory(
                $name,
                $slug,
                $description,
                $image,
                $status,
                $created_at,
                $updated_at
            );
        }
        $this->view('admin/tours/createCategory');
    }
}
