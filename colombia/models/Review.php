<?php
require 'config.php';
require 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

$blacklist = ['polimorfismo', 'herança', 'encapsulamento', 'abstração'];


if ($method === 'POST') {
   $body = getBody();

   $place_id = sanitizeInput($body, 'place_id', FILTER_VALIDATE_INT);
   $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
   $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
   $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);
   $date = (new DateTtima())->format('d/m/y h:m');
   $status = sanitizeInput($body, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

   if (!$place_id) resposneError('id do lugar', 400);
   if (!$name) resposneError('descriçao ausente', 400);
   if (!$email) resposneError('email invalido ou ausente', 400);
   if (!$stars) resposneError('sem estrelas', 400);
   if (!$status) resposneError('status ausente', 400);

   if (strlen($name) > 200) responseError('texto maior que 200', 400);

   foreach ($blacklist as $word) {
      if (str_contains($name, $word)) {
         str_replace('%'.$word.'%', '[editado pelo adm]', $name)
      }
   }
}