<?php 
  // require_once 'config.php';
  require_once './utils.php';
  require_once '../bolivia/controller/BoliviaReviewController.php';

  $method = $_SERVER['REQUEST_METHOD'];
  $controller = new BoliviaReviewController();

  if ($method === 'POST') {
    $controller->createReview();
  } else if ($method === 'GET' && $_GET['id']) {
    $controller->listReview();
  } else if ($method === 'PUT') {
    $controller->updateReview();
  }