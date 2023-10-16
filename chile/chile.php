<?php 
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = getBody();

    $name = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
    $opening_hours = filter_var($body->opening_hours, FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltaram informações para iniciar o atendimento']);
        exit;
    } 
    $allData = readFileContent(CHILE_DADOS);

    $itemWithSameName = array_filter($allData, function($item) use ($name){
        return $item->name === $name;
    });

    if(count($itemWithSameName)>0){
        echo json_encode(['error' => 'Item já existe']);
        exit;
    }

    $file = readFileContent(CHILE_DADOS);
    $data = [
        'id' => $_SERVER['REQUEST_TIME'],
        'name' => $name,
        'contact' => $contact,
        'opening_hours' => $opening_hours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude];

        $allData = readFileContent(CHILE_DADOS);
        array_push($allData, $data);
 
        saveFileContent(CHILE_DADOS, $allData);
        echo json_encode($data);
} else if($method === 'GET' && !isset($_GET['id'])){
    $allData = readFileContent(CHILE_DADOS);
    echo json_encode($allData);
    exit;
} else if ($method === 'DELETE'){
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if(!$id){
        responseError('ID AUSENTE', 404);        
    }
    $allData = readFileContent(CHILE_DADOS);

    $itemsFiltered = array_filter($allData, function($item) use($id){
        return $item -> id !== $id;
    });
} else if($method === 'GET'){
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    $allData = readFileContent(CHILE_DADOS);

    if(!$id){
        responseError('ID AUSENTE', 404); 
        $allData = readFileContent(CHILE_DADOS);
    }foreach($allData as $item){
        if($item -> id === $id){
            response($item, 200);
        }
    }       
} else if($method === 'PUT'){
    $body = getBody();
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    $allData = readFileContent(CHILE_DADOS);
    
   foreach($allData as $position => $item ){
        if($item -> id === $id){
            $allData[$position]-> name = $body -> name;
        }
    }   
    saveFileContent(CHILE_DADOS, $allData);    
}


