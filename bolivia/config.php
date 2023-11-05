<?php
header("Content-Type: application/json"); // a aplicação retorna json
header("Access-Control-Allow-Origin: *"); // vai aceitar requisições de todas origens
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // habilita métodos
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

define('PLACES', 'bolivia.txt');
define('BOLIVIA_FILE_REVIEWS', 'boliviaReviews.txt');
date_default_timezone_set('America/Sao_Paulo');