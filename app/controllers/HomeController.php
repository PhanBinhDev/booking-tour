<?php
namespace App\Controllers;
use App\Models\Tour;

class HomeController extends BaseController {
  private $tourModel;

  function __construct() {
    $route = $this->getRouteByRole();
    $roleBase = 'user';
    $role = $this->getRole();
    if ($role !== $roleBase) {
      $this->redirect($route);
    }

    $this->tourModel = new Tour();
  }
  function index() {
    $this->view('home/index');
  }

  function about() {
    $this->view('home/about');
  }

  function contact() {
    $this->view('home/contact');
  }

  function news() {
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

  function tourDetails($tourId){
    // $tourDetails = $this->tourDetails($tourId);
    $this->view('home/tour-details', ['id' => $tourId]);
  }
}

?>