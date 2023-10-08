<?php 
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

    $lugares = json_decode(file_get_contents('equador.txt'), true);

    if ($lugares !== null) {

        $id = $_GET['id'];
               
        if ($id !== null) {
            // Procura o lugar pelo ID
            $index = array_search($id, array_column($lugares, 'id'));

            if ($index !== false) {
                // Remove o lugar do array
                array_splice($lugares, $index, 1);

                // Salva o array atualizado no arquivo
                file_put_contents('equador.txt', json_encode($lugares));

                http_response_code(200); 
                echo json_encode(['message' => 'Lugar excluído com sucesso.']);
            } else {
                
                http_response_code(404); // erro
                echo json_encode(['error' => 'Lugar não encontrado com o ID especificado.']);
            }
        } else {
            http_response_code(400); // erro
            echo json_encode(['error' => 'solicitação invalida.']);
        }
    } else {
        http_response_code(404); // erro
        echo json_encode(['error' => 'Arquivo não encontrado.']);
    }
}