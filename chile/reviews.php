<?php 
require_once "utils.php";
require_once "config.php";
require_once "models/Review.php";

$method = $_SERVER['REQUEST_METHOD'];

$blacklist = ['polimorfismo', 'herança', 'abstração'];

if ($method === "POST"){
    $body = getBody();
    
    $place_id = sanitizeInput($body, 'place_id', FILTER_VALIDATE_INT);
    $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);
    $status = sanitizeInput($body, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

    if(!$place_id) responseError('Id do lugar ausente', 400);
    if(!$name) responseError('Descricao da avaliacao ausente', 400);
    if(!$email) responseError('Email ausente', 400);
    if(!$stars) responseError('Quantidade de estrelas ausente', 400);
    if(!$status) responseError('Status ausente', 400);

    if(strlen($name) > 200) responseError('O texto ultrapassou o limite',400);

    foreach ($blacklist as $word) {
        if (str_contains($name, $word)) {
            $name = str_replace($word, '[EDITADO PELO ADMIN]', $name);
        };
    }
    $review = new Review ($place_id);
    $review -> setName($name);
    $review -> setEmail($email);
    $review -> setStars($stars);
    $review -> setStatus($status);
    $review -> save();

    response(['message' => 'Cadastro com sucesso'], 201);
}   
