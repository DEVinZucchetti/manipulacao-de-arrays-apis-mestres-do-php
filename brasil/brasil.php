<?php

// Importe as configurações e utilitários necessários
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

// Leia os dados existentes do arquivo (usando uma função não fornecida)
$dadosBrasil = readFileContent(LOCAIS);

if ($method === 'POST') {
    // Obtenha o corpo da solicitação em formato JSON e decodifique-o
    $body = getBody();

    // Valide e filtre os dados recebidos do corpo da solicitação
    $name = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
    $opening_hours = filter_var($body->opening_hours, FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_var($body->latitude, FILTER_SANITIZE_NUMBER_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_SANITIZE_NUMBER_FLOAT);

    // Crie um array associativo com os dados filtrados
    $data = [
        'name' => $name,
        'contact' => $contact,
        'opening_hours' => $opening_hours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];

    // Verifique se algum campo obrigatório está vazio
    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Preencha todos os campos obrigatórios']);
    } else {
        // Verifique se já existe um lugar com o mesmo nome
        $lugarExistente = false;
        foreach ($dadosBrasil as $lugar) {
            if ($lugar->name === $name) { // Use a notação de seta para acessar propriedades de objetos
                $lugarExistente = true;
                break;
            }
        }

        if ($lugarExistente) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Um lugar com o mesmo nome já existe']);
        } else {
            // Adicione os dados ao array existente
            $dadosBrasil[] = $data;

            // Salve os dados atualizados no arquivo (usando uma função não fornecida)
            saveFileContent(LOCAIS, $dadosBrasil);

            http_response_code(201); // Created
            echo json_encode(['message' => 'Lugar cadastrado com sucesso', 'data' => $data]);
        }
    }
} elseif ($method === 'GET') {
    http_response_code(200); // OK
    echo json_encode(['data' => $dadosBrasil]);
}
?>
