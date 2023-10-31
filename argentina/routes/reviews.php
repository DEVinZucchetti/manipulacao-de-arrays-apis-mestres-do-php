<?php
require_once 'utils/config.php';
require_once 'utils/utils.php';
require_once 'models/Review.php';
require_once 'controller/ReviewController.php';



$reviewsController = new ReviewController;
$method = $_SERVER['REQUEST_METHOD'];
 
if ($method === 'POST') {
    $reviewsController->create();
}

    else if($method === 'GET'){
        $reviewsController->list();

    }
    else if ($method === "PUT") {
       $reviewsController->update();
    }

?>