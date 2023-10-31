<?php
require_once '../config.php';
require_once '../controllers/PlaceController.php';

$method = $_SERVER['REQUEST_METHOD'];
$controller = new PlaceController();

if ($method === 'POST') {
    $controller->createOne();
} else if ($method === 'GET' && !isset($_GET['id'])) {
    $controller->listAll();
} else if($method === 'GET' && $_GET['id']) {
    $controller->listOne();
} else if($method === 'DELETE') {
    $controller->delete();
} else if($method === "PUT") {
    $controller->update();
}