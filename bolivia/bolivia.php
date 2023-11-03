<?php
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

$boliviaData = readFileContent(PLACES);

if ($method === 'POST') {
  $body = getBody();

  $name = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
  $contact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
  $opening_hours = filter_var($body->opening_hours, FILTER_SANITIZE_SPECIAL_CHARS);
  $description = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
  $latitude = filter_var($body->latitude, FILTER_SANITIZE_NUMBER_FLOAT);
  $longitude = filter_var($body->longitude, FILTER_SANITIZE_NUMBER_FLOAT);

  $data = [
    'id' => $_SERVER['REQUEST_TIME'], // somente para uso didático
    'name' => $name,
    'contact' => $contact,
    'opening_hours' => $opening_hours,
    'description' => $description,
    'latitude' => $latitude,
    'longitude' => $longitude
  ];

  if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
     responseError('Preencha os campos necessários', 400);
  } else {
      $placeAlreadyExists = false;
      foreach ($boliviaData as $place) {
          if ($place->name === $name) {
              $placeAlreadyExists = true;
              break;
          }
      }
      if ($placeAlreadyExists) {
         responseError('Um lugar com o mesmo nome já existe', 400);
      } else {
          $boliviaData[] = $data;
          saveFileContent(PLACES, $boliviaData);
          response(['message' => 'Lugar cadastrado com sucesso'], 201);
      }
    }
} else if ($method === 'GET' && !isset($_GET['id'])) {
  $boliviaAllData = readFileContent(PLACES);
  response($boliviaAllData, 200);

} else if ($method === 'DELETE') {
  $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
  if (!$id) {
    responseError('ID ausente ou inválido', 400);
  }
  $boliviaAllData = readFileContent(PLACES);
  $itensFiltered = array_filter($boliviaAllData, function ($item) use ($id) {
      return $item->id !== $id;
  });
  saveFileContent(PLACES, $itensFiltered);
  response(['message' => 'Deletado com sucesso'], 204);

} else if ($method === 'GET' && $_GET['id']) {
  $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
  if (!$id) {
      responseError('ID ausente ou inválido', 400);
  }
  $boliviaAllData = readFileContent(PLACES);
  foreach ($boliviaAllData as $position => $item) {
      if ($item->id === $id) {
          response($item, 200);
      }
  }

} else if ($method === 'PUT') {
  $body = getBody();
  $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

  if (!$id) {
      responseError('ID ausente ou inválido', 400);
  }
  $newName = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
  $newContact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
  $newDescription = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
  $newOpening_hours = filter_var($body->opening_hours, FILTER_SANITIZE_SPECIAL_CHARS);
  $newLatitude = filter_var($body->latitude, FILTER_SANITIZE_NUMBER_FLOAT);
  $newLongitude = filter_var($body->longitude, FILTER_SANITIZE_NUMBER_FLOAT);

  $boliviaAllData = readFileContent(PLACES);

  foreach ($boliviaAllData as $position => $item) {
      if ($item->id === $id) {
          // Atualiza os dados do item
          $item->name = $newName;
          $item->contact = $newContact;
          $item->description = $newDescription;
          $item->opening_hours = $newOpening_hours;
          $item->latitude = $newLatitude;
          $item->longitude = $newLongitude;
      }
  }
  saveFileContent(PLACES, $boliviaAllData);

  // Verifica se pelo menos um item foi atualizado
  $updatedItem = array_filter($boliviaAllData, function ($item) use ($id) {
      return $item->id === $id;
  });
  if (!empty($updatedItem)) {
      response($updatedItem[0], 200);
  } else {
      responseError('Item não encontrado', 404);
  }
}