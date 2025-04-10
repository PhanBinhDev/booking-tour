<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\UrlHelper;
use App\Models\Reviews;

class ReviewController extends BaseController
{
    private $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new Reviews();
    }

    public function index()
    {
        $getTourReviews = $this->reviewModel->getTourReviews();

        // echo "<pre>";
        // print_r($getTourReviews);
        // echo "</pre>";
        // die();

        $this->view('admin/reviews/index', [
            'getTourReviews' => $getTourReviews,
        ]);
    }
    public function reviewDetail($id)
    {
        $getTourReviewById = $this->reviewModel->getTourReviews($id);
        // echo "<pre>";
        // print_r($getTourReviewById);
        // echo "</pre>";
        // die();
        $this->view('admin/reviews/reviewDetail', [
            'getTourReviewById' => $getTourReviewById,
        ]);
    }
    public function deleteReview($id)
    {
        $this->reviewModel->deleteById($id, 'tour_reviews');
        $this->setFlashMessage('success', 'Xóa đánh giá thành công');
        header('location:' . UrlHelper::route('admin/reviews'));
        exit;
    }

    public function updateStatus($id)
    {
        // Get review ID and new status from POST data
        $status = $_POST['status'] ?? null;

        // Validate input
        if (!$id || !in_array($status, ['approved', 'rejected', 'pending'])) {
            $this->setFlashMessage('error', 'Thông tin không hợp lệ');
            header('location:' . UrlHelper::route('admin/reviews'));
            return;
        }

        // Update review status
        $result = $this->reviewModel->updateStatus($id, $status);

        if ($result) {
            $this->setFlashMessage('success', 'Cập nhật trạng thái đánh giá thành công');
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi cập nhật trạng thái');
        }

        // Redirect back to the review list or detail page
        header('location:' . UrlHelper::route('admin/reviews'));
    }
}
