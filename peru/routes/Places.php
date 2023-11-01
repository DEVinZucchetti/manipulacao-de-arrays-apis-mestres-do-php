<?php 
require_once '../controllers/PlaceController.php';
require_once "../config/config.php";

$method = $_SERVER["REQUEST_METHOD"];
$controller = new PlaceController();

if ($method === 'POST') {
    $controller->create();
} else if ($method === 'GET' && !isset($_GET['id'])) {
    $controller->listAll();
} else if($method === 'GET' && $_GET['id']) {
    $controller->findById();
}else if($method === 'DELETE'){
    $controller-> delete();
}else if($method === 'PUT'){
    $controller-> updatePlace();
}
?>