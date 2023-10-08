<?php

require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

     $lugares = json_decode(file_get_contents('equador.txt'), true);
             
     if ($lugares !== null) {
                  
        http_response_code(200); 
        echo json_encode($lugares);
    } else {
        http_response_code(404); 
        echo json_encode(['error' => 'Arquivo não encontrado.']);
    }
}
?>