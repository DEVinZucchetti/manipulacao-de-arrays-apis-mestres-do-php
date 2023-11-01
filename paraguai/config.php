<?php
date_default_timezone_set('America/Sao_Paulo');

define('FILE_COUNTRY', 'paraguai.txt');
define('FILE_REVIEWS', 'reviews.txt');

header("Content-Type: application/json"); // A aplicação retorna json
header("Access-Control-Allow-Origin: *"); // vai aceitar requisições de todas origens
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  // Habilita métodos
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
?>
