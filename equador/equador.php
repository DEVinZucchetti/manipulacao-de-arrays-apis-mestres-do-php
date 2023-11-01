<?php
require_once "config.php";
require_once "utils.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $body = getBody();

    //$id = sanitizeString($body->id);
    $name = sanitizeString($body->name);
    $contact = sanitizeString($body->contact);
    $opening_hours = sanitizeString($body->opening_hours);
    $description =  sanitizeString($body->description);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

    // Verifica se todos os campos necessários estão presentes
    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {

        responseError('Faltaram informações essenciais', 400);
    }

    // Carrega os lugares existentes
    $allData = readFileContent(FILE_CITY);

    $itemWithSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemWithSameName) > 0) {
        responseError('Já existe um lugar com este nome', 409);
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
}
