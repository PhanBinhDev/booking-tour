<?php
namespace App\Controllers;

class HomeController extends BaseController {
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