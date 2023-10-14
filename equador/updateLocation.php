<?php 
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] === 'PUT'){

    $lugares = json_decode(file_get_contents('equador.txt'), true);

    if ($lugares) {

        $lugares = json_decode(file_get_contents('equador.txt'), true);

        // Obtém o ID do lugar a ser atualizado (você deve passar o ID na URL da requisição PUT)
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if ($id !== null) {
            // Procura o lugar pelo ID
            $index = array_search($id, array_column($lugares, 'id'));

            if ($index !== false) {
            
                $body = json_decode(file_get_contents('php://input'), true);
                $lugares[$index] = array_merge($lugares[$index], $body);

                // Salva o array atualizado no arquivo
                file_put_contents('equador.txt', json_encode($lugares));

                http_response_code(200); // OK
                echo json_encode(['message' => 'Lugar atualizado com sucesso.']);
            } else {
                http_response_code(404); 
                echo json_encode(['error' => 'Lugar não encontrado com o ID especificado.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID do lugar não especificado ou inválido na solicitação.']);
        }
    } else {
        http_response_code(404); // 
        echo json_encode(['error' => 'Arquivo não encontrado.']);
    }
}