<?php 
require_once '../config/config.php';
require_once '../controllers/PlaceController.php';

$method = $_SERVER['REQUEST_METHOD'];
$controller = new ReviewController();

if ($method === 'POST') {
    $controller->create();
} else if ($method === 'GET' && !isset($_GET['id'])) {
    $controller->listAll();
} else if ($method === 'DELETE') {
    $controller->delete();
} else if ($method === 'GET' && $_GET['id']) {
    $controller->findDyId();
} else if ($method === 'PUT') {
   $controller->update();
}
?>