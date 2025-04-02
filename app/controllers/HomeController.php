<?php

namespace App\Controllers;

use App\Models\Tour;
use App\Models\Contact;
use App\Models\BaseModel;
use App\Models\Categories;
use App\Models\Location;
use App\Models\NewsModel;

class HomeController extends BaseController
{
  private $tourModel;
  private $locationModel;
  private $newsModel;
  private $contactModel;
  private $categoriesModel;

  function __construct()
  {
    // $route = $this->getRouteByRole();
    // $roleBase = 'user';
    // $role = $this->getRole();
    // if ($role !== $roleBase) {
    //   $this->redirect($route);
    // }

    $this->tourModel = new Tour();
    $this->locationModel = new Location();
    $this->newsModel = new NewsModel();
    $this->contactModel = new Contact();
    $this->categoriesModel = new Categories();
  }
  function index()
  {
    $categories = $this->categoriesModel->getAll();
    $locations = $this->locationModel->getAll();
    $currentDate = date('Y-m-d');

    $join = [
      "JOIN tour_categories ON tour_categories.id = tours.category_id",
      "JOIN locations ON locations.id = tours.location_id",
      "LEFT JOIN (
      SELECT tour_id, AVG(rating) as avg_rating, COUNT(*) as review_count 
      FROM tour_reviews 
      GROUP BY tour_id
      ) as tr ON tr.tour_id = tours.id",
      "LEFT JOIN tour_dates ON tour_dates.tour_id = tours.id"
    ];

    $conditions = ["tours.status" => "active", "tours.sale_price" => "> 0"];

    $columns = "tours.id, tours.description,
              tr.avg_rating, 
              tr.review_count,
              tours.title, tours.price, tours.duration, tours.sale_price,
              MIN(CASE WHEN tour_dates.start_date >= '$currentDate' THEN tour_dates.start_date ELSE NULL END) as next_start_date,
              MIN(CASE WHEN tour_dates.end_date >= '$currentDate' THEN tour_dates.end_date ELSE NULL END) as next_end_date,
              COUNT(DISTINCT tour_dates.id) as date_count,
              GROUP_CONCAT(DISTINCT CONCAT(tour_dates.start_date, '|', tour_dates.end_date) ORDER BY tour_dates.start_date) as all_dates,
              tour_categories.name AS category_name, 
              locations.name AS location_name";

    $orderBy = 'tours.id DESC';

    $allTours = $this->tourModel->getAll(
      $columns,
      $conditions,
      $orderBy,
      8,
      null,
      $join,
      "GROUP BY tours.id, tr.avg_rating, tr.review_count, tours.title, tours.price, tours.duration, tours.sale_price, tour_categories.name, locations.name"
    );

    $condition = ["tours.status" => "active", "tours.featured" => "1"];

    $allFeaturedTours = $this->tourModel->getAll(
      $columns,
      $condition,
      $orderBy,
      3,
      null,
      $join,
      "GROUP BY tours.id, tr.avg_rating, tr.review_count, tours.title, tours.price, tours.duration, tours.sale_price, tour_categories.name, locations.name"
    );

    $newsColumns = 'id, title, summary, featured_image, created_at';
    $newsConditions = ['featured' => 1];

    $news = $this->newsModel->getAll($newsColumns, $newsConditions, null, 3);

    $this->view('home/index', [
      'allTours' => $allTours,
      'categories' => $categories,
      'allFeaturedTours' => $allFeaturedTours,
      'news' => $news,
      'locations' => $locations
    ]);
  }

  function about()
  {

    $this->view('home/about');
  }

  function contact()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = $_POST['name'] ?? '';
      $email = $_POST['email'] ?? '';
      $phone = $_POST['phone'] ?? '';
      $subject = $_POST['subject'] ?? '';
      $message = $_POST['message'] ?? '';

      $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message,
      ];
      $this->contactModel->createContact($data);
    }


    $this->view('home/contact');
  }

  function news()
  {
    $this->view('home/news');
  }

  function newsDetail($id)
  {
    $news = $this->newsModel->getById($id);
    var_dump($news);
    $this->view('home/news-detail', ['news' => $news]);
  }

  function faq()
  {
    $this->view('home/faq');
  }

  function terms()
  {
    $this->view('home/terms');
  }

  function privacyPolicy()
  {
    $this->view('home/privacy-policy');
  }

  function activities()
  {
    $this->view('home/activities');
  }

  function tours()
  {
    $categories = $this->categoriesModel->getAll();
    $currentDate = date('Y-m-d');

    // Lấy các tham số lọc từ URL
    $category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;
    $sort_option = isset($_GET['sort']) ? $_GET['sort'] : 'popular';
    $price_ranges = isset($_GET['price_range']) ? $_GET['price_range'] : [];
    $durations = isset($_GET['duration']) ? $_GET['duration'] : [];
    $ratings = isset($_GET['rating']) ? $_GET['rating'] : [];

    // Xây dựng bộ lọc
    $join = [
      "JOIN tour_categories ON tour_categories.id = tours.category_id",
      "JOIN locations ON locations.id = tours.location_id",
      "LEFT JOIN (
      SELECT tour_id, AVG(rating) as avg_rating, COUNT(*) as review_count 
      FROM tour_reviews 
      GROUP BY tour_id
      ) as tr ON tr.tour_id = tours.id",
      "LEFT JOIN tour_dates ON tour_dates.tour_id = tours.id"
    ];

    $conditions = ["tours.status" => "active"];

    // Lọc theo danh mục
    if ($category_id) {
      $conditions["tours.category_id"] = $category_id;
    }

    $columns = "tours.id, 
              tr.avg_rating, 
              tr.review_count,
              tours.title, tours.price, tours.duration, tours.sale_price,
              MIN(CASE WHEN tour_dates.start_date >= '$currentDate' THEN tour_dates.start_date ELSE NULL END) as next_start_date,
              MIN(CASE WHEN tour_dates.end_date >= '$currentDate' THEN tour_dates.end_date ELSE NULL END) as next_end_date,
              COUNT(DISTINCT tour_dates.id) as date_count,
              GROUP_CONCAT(DISTINCT CONCAT(tour_dates.start_date, '|', tour_dates.end_date) ORDER BY tour_dates.start_date) as all_dates,
              tour_categories.name AS category_name, 
              locations.name AS location_name";

    // Xác định thứ tự sắp xếp dựa trên tùy chọn
    $orderBy = 'tours.id DESC'; // Mặc định
    switch ($sort_option) {
      case 'popular':
        $orderBy = 'tr.review_count DESC, tr.avg_rating DESC';
        break;
      case 'price_asc':
        $orderBy = 'CASE WHEN tours.sale_price > 0 THEN tours.sale_price ELSE tours.price END ASC';
        break;
      case 'price_desc':
        $orderBy = 'CASE WHEN tours.sale_price > 0 THEN tours.sale_price ELSE tours.price END DESC';
        break;
      case 'rating':
        $orderBy = 'tr.avg_rating DESC, tr.review_count DESC';
        break;
    }

    $allTours = $this->tourModel->getAll(
      $columns,
      $conditions,
      $orderBy,
      null,
      null,
      $join,
      "GROUP BY tours.id, tr.avg_rating, tr.review_count, tours.title, tours.price, tours.duration, tours.sale_price, tour_categories.name, locations.name"
    );

    // Truyền dữ liệu thêm để hiển thị trạng thái bộ lọc
    $this->view('home/tours', [
      'allTours' => $allTours,
      'categories' => $categories,
      'currentCategory' => $category_id,
      'selectedSort' => $sort_option,
      'selectedPriceRanges' => $price_ranges,
      'selectedDurations' => $durations,
      'selectedRatings' => $ratings
    ]);
  }


  function tourDetail($id)
  {
    $tourDetails = $this->tourModel->getTourDetails($id);
    $itinerary = json_decode($tourDetails['itinerary'], true);
    $this->view('home/tour-details', ['tourDetails' => $tourDetails, 'itinerary' => $itinerary]);
  }

  function bookings($id)
  {
    $tourDetails = $this->tourModel->getTourDetails($id);
    $this->view('home/bookings', ['tourDetails' => $tourDetails]);
  }
}
