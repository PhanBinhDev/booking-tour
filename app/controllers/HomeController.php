<?php
namespace App\Controllers;

class HomeController extends BaseController {
  function index() {
    $this->view('layouts/main');
  }
}

?>