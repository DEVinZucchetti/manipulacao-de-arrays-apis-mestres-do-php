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
}else if($method === 'GET' && !isset($_GET['id'])) {
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

}else if ($method === 'GET' && $_GET['id']) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID ausente', 400);
    }

    $allData = readFileContent(LOCAIS);

    foreach ($allData as $item) {
        if ($item->id === $id) {
            response($item, 200);
        }
    }
}else if ($method === 'PUT') {
    $body = getBody();
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID ausente', 400);
    }

    $allData = readFileContent(LOCAIS);


    foreach ($allData as $position => $item) {
        if ($item->id === $id) {
            $allData[$position]->name =  isset($body->name) ? $body->name : $item->name;
            $allData[$position]->contact =  isset($body->contact) ? $body->contact : $item->contact;
            $allData[$position]->opening_hours =   isset($body->opening_hours) ? $body->opening_hours : $item->opening_hours;
            $allData[$position]->description =  isset($body->description) ? $body->description : $item->description;
            $allData[$position]->latitude =  isset($body->latitude) ? $body->latitude : $item->latitude;
            $allData[$position]->longitude =  isset($body->longitude) ? $body->longitude : $item->longitude;
        }
    }

    saveFileContent(LOCAIS, $allData);

    response([], 200);
}
?>