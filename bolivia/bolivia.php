<?php 
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Obtenha o corpo da solicitação em formato JSON e decodifique-o
    $body = getBody();

    // Valide e filtre os dados recebidos do corpo da solicitação
    //Pode criar uma funcao pra otimizar 
    $name = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
    $opening_hours = filter_var($body->opening_hours, FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_var($body->latitude, FILTER_SANITIZE_NUMBER_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_SANITIZE_NUMBER_FLOAT);


    // Verifique se algum campo obrigatório está vazio
    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
       responseError('Preencha todos os campos', 400);
    }


    $allData = readFileContent(LOCAIS);
    // Crie um array associativo com os dados filtrados

    $itemWithSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemWithSameName) > 0) {
        responseError('O item já existe', 409);
    }
    
    $data = [
        'id' => $_SERVER['REQUEST_TIME'],
        'name' => $name,
        'contact' => $contact,
        'opening_hours' => $opening_hours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];

   
    array_push($allData, $data);
    saveFileContent(LOCAIS, $allData);

    response($data, 201);
}else if($method === 'GET'){
    $allData = readFileContent(LOCAIS);
    response($allData, 200);
}else if ($method === 'DELETE') {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID ausente', 400);
    }

    $allData = readFileContent(LOCAIS);

    $itemsFiltered = array_values(array_filter($allData, function ($item) use ($id) {
        return $item->id !== $id;
    }));

    var_dump($itemsFiltered);

    saveFileContent(LOCAIS, $itemsFiltered);

    response(['message' => 'Deletado com sucesso'], 204);

}
?>