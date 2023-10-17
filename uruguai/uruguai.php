<?php 

require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

if($method === 'POST') {

    $body = getBody();

    $name = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
    $opening_hours = filter_var($body->opening_hours, FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

    if(!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
        responseError('Digite as informações para prosseguir com o cadastro!', 400);
    }

    $allData = readFileContent(FILE_CITY);

    foreach ($allData as $item) {
        if ($item->name === $name) {
            responseError('Este lugar já está cadastrado!', 409);
            exit;
        }
    };

    $data = [
        'id' => generateUniqueID(),
        'name' => $name,
        'contact' => $contact,
        'opening_hours' => $opening_hours,
        'description' => $description,
        'latitude' => $latitude, 
        'longitude' => $longitude
    ];

    array_push($allData, $data);
    saveFileContent(FILE_CITY, $allData);
    response($data, 201);

} else if ($method === 'GET' && !isset($_GET['id'])){
    $allData = readFileContent(FILE_CITY);
    response($allData, 200);

} else if ($method === 'DELETE') {
    $id = validateID();

    if (!$id) {
        responseError('ID ausente ou inválido!', 400);
    }

    $allData = readFileContent(FILE_CITY);
    $itemsFiltered = array_values(array_filter($allData, function ($item) use ($id) {
        return $item->id !== $id;
    }));

    var_dump($itemsFiltered);
    saveFileContent(FILE_CITY, $itemsFiltered);
    response('', 204);

} else if($method === 'GET' && $_GET['id']) {
    $id = validateID();

    if (!$id) {
        responseError('ID ausente ou inválido!', 400);
    }

    $allData = readFileContent(FILE_CITY);

    foreach($allData as $item) {
        if($item->id === $id) {
            response($item, 200);
        }
    }

} else if($method === 'PUT') {
    $body = getBody();
    $id = validateID();

    if (!$id) {
        responseError('ID ausente ou inválido!', 400);
    }

    $allData = readFileContent(FILE_CITY);

    foreach($allData as $position => $item) {
        if($item->id === $id) {
            $allData[$position]->name =  isset($body->name) ? $body->name : $item->name;
            $allData[$position]->contact =  isset($body->contact) ? $body->contact : $item->contact;
            $allData[$position]->opening_hours =   isset($body->opening_hours) ? $body->opening_hours : $item->opening_hours;
            $allData[$position]->description =  isset($body->description) ? $body->description : $item->description;
            $allData[$position]->latitude =  isset($body->latitude) ? $body->latitude : $item->latitude;
            $allData[$position]->longitude =  isset($body->longitude) ? $body->longitude : $item->longitude;
        }
    }
    
    saveFileContent(FILE_CITY, $allData);
    response([], 200);
}

?>
