<?php
require_once 'config.php';
require_once 'utils.php';


$method = $_SERVER['REQUEST_METHOD'];

$colombiaInfos = readFileContent(LOCAIS);


if ($method === 'POST') {

   $body = getBody();


   $name = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
   $contact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
   $opening_hours = filter_var($body->opening_hours, FILTER_SANITIZE_SPECIAL_CHARS);
   $description = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
   $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
   $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

   $data = ['id' => $_SERVER['REQUEST_TIME'], 'name' => $name, 'contact' => $contact, 'opening_hours' => $opening_hours, 'description' => $description, 'latitude' => $latitude, 'longitude' => $longitude];

   foreach ($colombiaInfos as $item) {
      if ($item->name === $name) {
         $cidade = true;
         echo json_encode(['error' => 'Cadastro ja existe']);
         exit;
      }
   }

   if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
      echo json_encode(['error' => 'Faltaram informações']);
   } else {
      array_push($colombiaInfos, $data);
   }


   saveFlieContent(LOCAIS, $colombiaInfos);

   http_response_code(201);

   echo json_encode(['message' => $data]);
} else if ($method === 'GET' || !isset($_GET['id'])) {

   echo json_encode(['message' => $colombiaInfos]);


   $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

   if (!$id) {
      http_response_code(400);
      echo json_encode(['error' => 'id ausente']);
   }

   $allData = readFileContent(LOCAIS);

   foreach ($allData as $item) {
      if ($item->id == $id) {
         echo json_encode(['message' => $item]);
         exit;
      }
   }
} else if ($method === 'DELETE') {

   $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);


   if (!$id) {
      http_response_code(400);
      echo json_encode(['error' => 'id ausente']);
   }

   $allData = readFileContent(LOCAIS);

   $novoArray = array_filter($allData, function ($item) use ($id) {
      return ($item->id != $id);
   });

   saveFlieContent(LOCAIS, $novoArray);
   http_response_code(204);
} else if ($method === 'PUT') {
   $body = getBody();
   $id = $_GET['id'];

   if (!$id) {
      http_response_code(400);
      echo json_encode(['error' => 'id ausente']);
   }

   $allData = readFileContent(LOCAIS);

   foreach ($allData as $position => $item) {
      if ($item->id == $id) {

         $allData[$position]->name = isset($body->name) ? $body->name :  $item->name;
         $allData[$position]->contact = isset($body->contact) ? $body->contact :  $item->contact;
         $allData[$position]->opening_hours = isset($body->opening_hours) ? $body->opening_hours :  $item->opening_hours;
         $allData[$position]->description = isset($body->description) ? $body->description :  $item->description;
         $allData[$position]->latitude = isset($body->latitude) ? $body->latitude :  $item->latitude;
         $allData[$position]->longitude = isset($body->longitude) ? $body->longitude :  $item->longitude;

         exit;
      }
   }
}
