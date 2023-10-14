<?php 
  require_once 'config.php';
  require_once 'utils.php';

  $method = $_SERVER['REQUEST_METHOD'];

  if ($method === 'POST') {
    $body = getBody();

    $place_id = sanitizeInput($body, 'place_id', FILTER_VALIDATE_INT);
    $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);

    if (!$place_id) responseError('Id do lugar ausente', 400);
    if (!$name) responseError('Descrição da avaliação ausente', 400);
    if (!$email) responseError('Email inválido', 400);
    if (!$stars) responseError('Quantidade de estrelas ausente', 400);

    if (strlen($name) > 200) responseError('O texto ultrapassou o limite', 400);

  }
?>