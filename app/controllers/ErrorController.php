<?php
namespace App\Controllers;

class ErrorController extends BaseController {

  public function notFound() {
    $this->view('errors/404');
  }

}

?>