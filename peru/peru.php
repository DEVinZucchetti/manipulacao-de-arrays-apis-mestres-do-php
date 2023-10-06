<?php
    require_once 'config.php';
    require_once 'utils.php';

    $method = $_SERVER["REQUEST_METHOD"];

    if($method == 'POST'){
        $body =getBody();

        $name = filter_var($body -> name, FILTER_SANITIZE_SPECIAL_CHARS);
        $contact = filter_var($body -> contact, FILTER_SANITIZE_SPECIAL_CHARS);
        $openingHours = filter_var($body -> openingHours, FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_var($body -> description, FILTER_SANITIZE_SPECIAL_CHARS);
        $latitude = filter_var($body -> latitude, FILTER_SANITIZE_NUMBER_FLOAT);
        $longitude = filter_var($body -> longitude, FILTER_SANITIZE_NUMBER_FLOAT);


        if(!$name){
            http_response_code(400);
            echo json_encode(['error' => 'Nome é obrigatório']); 
        }
        if(!$contact){
            http_response_code(400);
            echo json_encode(['error' => 'Campo de contato é obrigatório']); 
        }
        if(!$openingHours){
            http_response_code(400);
            echo json_encode(['error' => 'A hora de abertura  é obrigatório']); 
        }
        if(!$description){
            http_response_code(400);
            echo json_encode(['error' => 'A descrição é obrigatório']); 
        }
        if(!$latitude){
            http_response_code(400);
            echo json_encode(['error' => 'A latitude é obrigatório']); 
        }
        if(!$longitude){
            http_response_code(400);
            echo json_encode(['error' => 'A longitude é obrigatório']); 
        }
            $peru = readFileContent(ARQUIVO_PERU);

            array_push($peru, ['name' => $name, 'contact' => $contact, 'openingHours' => $openingHours,
             'description' => $description, 'latitude' => $latitude, 'longitude' => $longitude]);
        

        file_put_contents(ARQUIVO_PERU, json_encode($peru));

        http_response_code(201);
        echo json_encode([
            'message' => "Dados salvos com sucesso"
        ]); 
    }
