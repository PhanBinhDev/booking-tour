<?php

namespace App\Controllers;

use App\Models\Tour;
use App\Models\Contact;

class HomeController extends BaseController
{
  private $tourModel;
  private $contactModel;
  function __construct()
  {
    $route = $this->getRouteByRole();
    $roleBase = 'user';
    $role = $this->getRole();
    if ($role !== $roleBase) {
      $this->redirect($route);
    }

    $this->tourModel = new Tour();
    $this->contactModel = new Contact();
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
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
       $name = $_POST['name'] ?? '';
       $email = $_POST['email'] ?? '';
       $phone = $_POST['phone'] ?? '';
       $subject = $_POST['subject'] ?? '';
       $message = $_POST['message'] ?? '';

       $data =[
        'name'=> $name,
        'email'=> $email,
        'phone'=> $phone,
        'subject'=> $subject,
        'message'=> $message,
       ];
      //  var_dump($data); die();
        $this->contactModel->createContact($data);

    }


    $this->view('home/contact');
  }

  function news()
  {
    $this->view('home/news');
  }

  function faq() {
    $this->view('home/faq');
  }

  function terms() {
    $this->view('home/terms');
  }

  function privacyPolicy() {
    $this->view('home/privacy-policy');
  }

  function activities() {
    $this->view('home/activities');
  }

  function tours()
  {
    $this->view('home/tours');
  }


  function tourDetails($tourId)
  {
    // $tourDetails = $this->tourDetails($tourId);
    $this->view('home/tour-details', ['id' => $tourId]);
  }
}
