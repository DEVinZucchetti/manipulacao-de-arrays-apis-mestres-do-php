<?php 
require_once 'config.php';
require_once 'utils.php';
require_once 'models/Review.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = getBody();

    $place_id = sanitizeInput($body, 'place_id', FILTER_SANITIZE_SPECIAL_CHARS);
    $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);
    $date = (new DateTime())->format('d/m/y H:i:');
    $status = sanitizeInput($body, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$place_id) responseError('ID Obrigatorio', 400);
    if (!$name) responseError('Descrição obrigatoria', 400);
    if (!$email) responseError('Email Obrigatorio', 400);
    if (!$stars) responseError('Quantidade de estrelas obrigatorio', 400);
    if (!$status) responseError('Status Obrigatorio', 400);
}
?>