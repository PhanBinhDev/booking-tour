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

  function tourDetails($tourId){
    // $tourDetails = $this->tourDetails($tourId);
    $this->view('home/tour-details', ['id' => $tourId]);
  }
}

?>