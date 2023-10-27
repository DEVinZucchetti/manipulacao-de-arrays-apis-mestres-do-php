<?php
require_once 'config.php';
require_once 'utils.php';
require_once 'models/Review.php';

$blacklist = ['polimorfismo', 'herança', 'Abstração', 'Encapsulamento'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $body = getBody();

    $place_id = sanitizeInput($body, 'place_id', FILTER_VALIDATE_INT);
    $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);
    $date = (new DateTime())->format('d/m/y H:i:');
    $status = sanitizeInput($body, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$place_id) responseError('ID Obrigatorio', 400);
    if (!$name) responseError('Nome Obrigatorio', 400);
    if (!$email) responseError('Email Obrigatorio', 400);
    if (!$stars) responseError('Quantidade de estrelas obrigatorio', 400);
    if (!$status) responseError('Status Obrigatorio', 400);

    if (strlen($name) > 200) {
        responseError('Nome maios que 200 caracteres', 400);
    }

    foreach ($blacklist as $palavra) {

        if(strpos($name, $palavra)) {
            $name = str_replace($palavra, '[EDITADO PELO ADMIN]', $name);
        }
    }

    $review = new Review($place_id);

    $review->setName($name);
    $review->setEmail($email);
    $review->setStars($stars);
    $review->setDate($date);
    $review->setStatus($Status);
}
