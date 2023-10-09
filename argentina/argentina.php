<?php
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = getBody();

    $name = sanitizeString($body->name);
    $contact = sanitizeString($body->contact);
    $opening_hours = sanitizeString($body->opening_hours);
    $description = sanitizeString($body->description);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
        responseError('Faltaram informações essenciais', 400);
    }

    $allData = readFileContent(FILE_CITY);

    $itemWithSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemWithSameName) > 0) {
        responseError('O item já existe', 409);
    }


    $data = [
        'id' => $_SERVER['REQUEST_TIME'], // somente para uso didático
        'name' => $name,
        'contact' => $contact,
        'opening_hours' =>  $opening_hours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];


    array_push($allData, $data);
    saveFileContent(FILE_CITY, $allData);

    response($data, 201);
} else if ($method === 'GET' && !isset($_GET['id'])) {
    $allData = readFileContent(FILE_CITY);
    response($allData, 200);

} else if ($method === 'DELETE') {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID ausente', 400);
    }

    $allData = readFileContent(FILE_CITY);

    $itemsFiltered = array_filter($allData, function ($item) use ($id) {
       return $item->id !== $id;
    });

    var_dump($itemsFiltered);

    saveFileContent(FILE_CITY, $itemsFiltered);

    response(['message' => 'Deletado com sucesso'], 204);
} else if($method === 'GET' && $_GET['id']) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID ausente', 400);
    }

    $allData = readFileContent(FILE_CITY);

    foreach($allData as $item) {
        if($item->id === $id) {
            response($item, 200);
        }
    }
} else if($method === 'PUT') {
    $body = getBody();
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    var_dump($id);

    $allData = readFileContent(FILE_CITY);

    foreach($allData as $position => $item) {
        if($item->id === $id) {
            $allData[$position]->name = $body->name;
            $allData[$position]->contact = $body->contact;
            $allData[$position]->opening_hours = $body->opening_hours;
            $allData[$position]->description = $body->description;
            $allData[$position]->latitude = $body->latitude;
            $allData[$position]->longitude = $body->longitude;
            
        }
    }
    
    saveFileContent(FILE_CITY, $allData);
}