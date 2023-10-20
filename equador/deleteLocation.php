<?php 
require_once 'config.php';
require_once 'utils.php';
require_once "models/Place.php";
require_once "controllers/PlaceController.php";

if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

    $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);
    
    $place = new PlaceController();
    $place->delete($id);
   

    response(['message' => 'Deletado com sucesso'], 204);
    response($place, 201);
}