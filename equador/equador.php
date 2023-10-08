<?php
require_once "config.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $body = json_decode(file_get_contents('php://input'), true); // formato strig

    $id = filter_var($body['id'], FILTER_VALIDATE_INT);
    $name = filter_var($body['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($body['contact'], FILTER_SANITIZE_SPECIAL_CHARS);
    $opening_hours = filter_var($body['opening_hours'], FILTER_SANITIZE_SPECIAL_CHARS);
    $description =  filter_var($body['description'], FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_var($body['latitude'], FILTER_FLAG_ALLOW_FRACTION);
    $longitude = filter_var($body['longitude'], FILTER_FLAG_ALLOW_FRACTION);

    // Verifica se todos os campos necessários estão presentes
    if (
        isset($body['id'], $body['name'], $body['contact'], $body['opening_hours'],
              $body['description'], $body['latitude'], $body['longitude'])
    ) {
        
        // Carrega os lugares existentes
        $lugares = json_decode(file_get_contents('equador.txt'), true);

       
        // Verifica se já existe um lugar com o mesmo nome
        foreach ($lugares as $lugar) {
            if ($lugar['name'] === $body['name']) {
                http_response_code(400); 
                echo json_encode(['error' => 'Já existe um lugar com esse nome.']);
                exit;
            }
        }

        // Adiciona o novo lugar ao array de lugares
        $lugares[] = $body;
       
        // Salva o array atualizado no arquivo        
        file_put_contents('equador.txt', json_encode($lugares));
        

        http_response_code(201); 
        echo json_encode(['message' => 'Lugar cadastrado com sucesso!']);
    } else {
        http_response_code(400); 
        echo json_encode(['error' => 'Dados incompletos. Certifique-se de incluir todos os campos necessários.']);
    }
}
?>

