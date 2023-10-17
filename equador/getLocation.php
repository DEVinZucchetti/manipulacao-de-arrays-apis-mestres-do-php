<?php
require_once "models/Place.php";
require_once "config.php";
require_once "utils.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $body = getBody();
    $place = (new Place())->listar();

    response($place, 200);
}
?>