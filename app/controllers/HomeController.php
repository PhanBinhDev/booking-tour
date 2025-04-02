<?php

namespace App\Controllers;

use App\Models\Tour;
use App\Models\Contact;
use App\Models\BaseModel;
use App\Models\Categories;

class HomeController extends BaseController
{
  private $tourModel;
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
    $this->contactModel = new Contact();
    $this->categoriesModel = new Categories();
  }
  function index()
  {
    $this->view('home/index');
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

  function newsDetail()
  {
    $this->view('home/news-detail');
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

    $allTours = $this->tourModel->getAll(
      $columns,
      $conditions,
      'tours.id DESC',
      null,
      null,
      $join,
      "GROUP BY tours.id, tr.avg_rating, tr.review_count, tours.title, tours.price, tours.duration, tours.sale_price, tour_categories.name, locations.name"
    );

    $this->view('home/tours', ['allTours' => $allTours, 'categories' => $categories]);
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
