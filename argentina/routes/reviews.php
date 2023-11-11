<?php
require_once '../config.php';
require_once '../controller/ReviewController.php';



$reviewsController = new ReviewController;
$method = $_SERVER['REQUEST_METHOD'];
 
if ($method === 'POST') {
    $reviewsController->create();
}
else if ($method === 'GET' && !isset($_GET['id'])) {
    $reviewsController->list();
    }
    else if ($method === 'GET' && $_GET['id']) {
        $reviewsController->listOne();
    }
    else if ($method === "PUT") {
       $reviewsController->update();
    }

?>