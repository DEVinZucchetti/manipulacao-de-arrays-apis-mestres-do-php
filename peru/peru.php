<?php
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER["REQUEST_METHOD"];

// Se o método da requisição for POST
if ($method === 'POST') {

    // Obtém o corpo da requisição
    $body = getBody();

    // Filtra e valida os dados recebidos
    $name = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
    $opening_Hours = filter_var($body->openingHours, FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_var($body->latitude, FILTER_SANITIZE_NUMBER_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_SANITIZE_NUMBER_FLOAT);

    // Verifica se os dados obrigatórios estão presentes
    if (!$name || !$contact || !$opening_Hours || !$description || !$latitude || !$longitude) {
        responseError('Dados incompletos ou inválidos', 400);
    }

    // Lê os dados existentes
    $allData = readFileContent(FILE_CITY);

    // Verifica se já existe um item com o mesmo nome
    $itemWithSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemWithSameName) > 0) {
        responseError('Item já existe', 409);
    }

    // Cria um novo item
    $data = [
        'id' => $_SERVER['REQUEST_TIME'],
        'name' => $name,
        'contact' => $contact,
        'openingHours' => $opening_Hours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];

    // Adiciona o novo item aos dados existentes
    array_push($allData, $data);

    // Salva os dados atualizados
    saveFileContent(FILE_CITY, $allData);

    // Responde com os dados do novo item criado
    response($data, 201);

// Se o método da requisição for GET e não houver parâmetro 'id'
} else if ($method === 'GET' && !isset($_GET['id'])) {

    // Lê os dados e responde com todos os itens
    $allData = readfile(FILE_CITY);
    response($allData, 200);

// Se o método da requisição for DELETE
} else if ($method === 'DELETE') {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    // Verifica se o parâmetro 'id' está presente e é um número inteiro válido
    if (!$id) {
        responseError('ID ausente ou inválido', 400);
    }

    // Lê os dados existentes
    $allData = readFileContent(FILE_CITY);

    // Filtra os itens, removendo o item com o ID correspondente
    $itensFiltered = array_filter($allData, function ($item) use ($id) {
        return $item->id !== $id;
    });

    // Salva os dados atualizados sem o item removido
    saveFileContent(FILE_CITY, $itensFiltered);

    // Responde com mensagem de sucesso
    response(['message' => 'Deletado com sucesso'], 204);

// Se o método da requisição for GET e houver parâmetro 'id'
} else if ($method === 'GET' && $_GET['id']) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    // Verifica se o parâmetro 'id' está presente e é um número inteiro válido
    if (!$id) {
        responseError('ID ausente ou inválido', 400);
    }

    // Lê os dados existentes
    $allData = readFileContent(FILE_CITY);

    // Procura o item com o ID correspondente
    foreach ($allData as $position => $item) {
        if ($item->id === $id) {
            // Responde com os dados do item encontrado
            response($item, 200);
        }
    }

// Se o método da requisição for PUT
} else if ($method === 'PUT') {
    $body = getBody();
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    // Verifica se o parâmetro 'id' está presente e é um número inteiro válido
    if (!$id) {
        responseError('ID ausente ou inválido', 400);
    }

    // Filtra e valida os dados recebidos para atualização
    $newName = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
    $newContact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
    $newDescription = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
    $newOpeningHours = filter_var($body->openingHours, FILTER_SANITIZE_SPECIAL_CHARS);
    $newLatitude = filter_var($body->latitude, FILTER_SANITIZE_NUMBER_FLOAT);
    $newLongitude = filter_var($body->longitude, FILTER_SANITIZE_NUMBER_FLOAT);

    // Lê os dados existentes
    $allData = readFileContent(FILE_CITY);

    // Procura o item com o ID correspondente para atualização
    foreach ($allData as $position => $item) {
        if ($item->id === $id) {
            // Atualiza os dados do item
            $item->name = $newName;
            $item->contact = $newContact;
            $item->description = $newDescription;
            $item->openingHours = $newOpeningHours;
            $item->latitude = $newLatitude;
            $item->longitude = $newLongitude;
        }
    }

    // Salva os dados atualizados
    saveFileContent(FILE_CITY, $allData);

    // Verifica se pelo menos um item foi atualizado
    $updatedItem = array_filter($allData, function ($item) use ($id) {
        return $item->id === $id;
    });

    // Responde com os dados atualizados ou erro se o item não for encontrado
    if (!empty($updatedItem)) {
        response($updatedItem[0], 200);
    } else {
        responseError('Item não encontrado', 404);
    }
}
?>
