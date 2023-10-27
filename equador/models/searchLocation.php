<?php 
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] === 'GET'){

    $lugares = json_decode(file_get_contents('equador.txt'), true);

    if ($lugares) {

        $lugares = json_decode(file_get_contents('equador.txt'), true);

        
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if ($id !== null) {
            // Procura o lugar pelo ID
            $index = array_search($id, array_column($lugares, 'id'));

            if ($index !== false) {
             
                http_response_code(200); // OK
                echo json_encode($lugares[$index]);
            } else {
                http_response_code(404); 
                echo json_encode(['error' => 'Lugar não encontrado com o ID especificado.']);
            }
        } else {
            http_response_code(400); 
            echo json_encode(['error' => 'ID do lugar não especificado ou inválido na solicitação.']);
        }
    } else {
        http_response_code(404); 
        echo json_encode(['error' => 'Arquivo não encontrado.']);
    }
}