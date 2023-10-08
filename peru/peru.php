<?php
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER["REQUEST_METHOD"];

if ($method === 'POST') {

    $body = getBody();

    $name = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
    $opening_Hours = filter_var($body->openingHours, FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_var($body->latitude, FILTER_SANITIZE_NUMBER_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_SANITIZE_NUMBER_FLOAT);

    if (!$name) {
        responseError('Nome é obrigatório', 400);
    }
    if (!$contact) {
        responseError('Campo de contato é obrigatório', 400);
    }
    if (!$opening_Hours) {
        responseError('A hora de abertura  é obrigatório', 400);
    }
    if (!$description) {
        responseError('A descrição é obrigatório', 400);
    }
    if (!$latitude) {
        responseError(' A latitude é obrigatória', 400);
    }
    if (!$longitude) {
        responseError('A longitude é obrigatório', 400);
    }

    $allData = readFileContent(ARQUIVO_PERU);

    $itemWithSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemWithSameName) > 0) {
        responseError('Item ja existe', 409);
    }

    $data = [
        'id' => $_SERVER['REQUEST_TIME'],
        'name' => $name,
        'contact' => $contact,
        'openingHours' => $opening_Hours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];

    array_push($allData, $data);

    saveFileContent(ARQUIVO_PERU, $allData);

    response($data, 201);
} else if ($method === 'GET' && !isset($_GET['id'])) {

    $allData = readfile(ARQUIVO_PERU);

    response($allData, 200);
} else if ($method === 'DELETE') {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID ausente', 400);
    }

    $allData = readFileContent(ARQUIVO_PERU);

    $itemsFiltered = array_filter($allData, function ($item) use ($id) {
        if($item->id !== $id);
    });

    var_dump($itemsFiltered);

    saveFileContent(ARQUIVO_PERU, $itemsFiltered);

    response(['message' => 'Deletado com sucesso'], 204);
} else if ($method === 'GET' && $_GET['id']) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID ausente', 400);
    }

    $allData = readFileContent(ARQUIVO_PERU);
    foreach ($allData as $item) {
        if ($item->id === $id) {
            response($item, 200);
        }
    }
} else if ($method === 'PUT') {
    $body = getBody();
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    $allData = readFileContent(ARQUIVO_PERU);
    foreach ($allData as $position => $item) {
        if ($item->id === $id) {
            $allData[$position]->name = $body->name;
            $allData[$position]->contact = $body->contact;
            $allData[$position]->description = $body->description;
            $allData[$position]->opening_hours = $body->opening_hours;
            $allData[$position]->latitude = $body->latitude;
            $allData[$position]->longitude = $body->longitude;
        }
    }

    saveFileContent(ARQUIVO_PERU, $allData);
}
