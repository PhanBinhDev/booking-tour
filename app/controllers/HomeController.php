<?php
namespace App\Controllers;

class HomeController extends BaseController {
  function __construct() {
    $route = $this->getRouteByRole();
    $roleBase = 'user';
    $role = $this->getRole();
    if ($role !== $roleBase) {
      $this->redirect($route);
    }
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

  // function payment 
}

?>