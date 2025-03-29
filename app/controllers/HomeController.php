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
    $join = [
      "JOIN tour_categories ON tour_categories.id = tours.category_id",
      "JOIN locations ON locations.id = tours.location_id",
      "JOIN tour_dates ON tour_dates.tour_id = tours.id"
    ];

    $columns = "tours.id, 
    tours.title, tours.price, tours.duration,
    tour_dates.start_date, tour_dates.end_date, 
    tour_categories.name AS category_name, 
    locations.name AS location_name";

    $allTours = $this->tourModel->getAll($columns, [], 'tours.id DESC', null, null, $join);

    $this->view('home/tours', ['allTours' => $allTours, 'categories' => $categories]);
  }



  function tourDetail($id)
  {

    $tourDetails = $this->tourModel->getTourDetails($id);
    $this->view('home/tour-details', ['tourDetails' => $tourDetails]);
  }
}
