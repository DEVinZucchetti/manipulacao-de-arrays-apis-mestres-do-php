<?php
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

$colombiaInfos = readFileContent(LOCAIS);

if ($method === 'POST') {
   // Capturar o body da requisição (você precisa implementar a função getBody)
   $body = getBody();

   $name = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
   $contact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
   $opening_hours = filter_var($body->opening_hours, FILTER_SANITIZE_SPECIAL_CHARS);
   $description = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
   $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
   $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

   if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
      echo json_encode(['error' => 'Faltaram informações']);
   } else {
      array_push($colombiaInfos, ['name' => $name, 'contact' => $contact, 'opening_hours' => $opening_hours, 'description' => $description, 'latitude' => $latitude, 'longitude' => $longitude]);
   }

   saveFlieContent(LOCAIS, $colombiaInfos);

   http_response_code(201);

   echo json_encode(['message' => $colombiaInfos]);
} else if ($method === 'GET') {

   echo json_encode(['message' => $colombiaInfos]);
}
