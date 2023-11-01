<?php
require_once '../utils/utils.php';

require_once '../models/Place.php';
require_once '../DAO/PlaceDAO.php';


class PlaceController
{

    public function create()
    {
        $body = getBody();

        $name = sanitizeInput($body,'name',FILTER_SANITIZE_SPECIAL_CHARS);
        $contact = sanitizeInput($body,'contact',FILTER_SANITIZE_SPECIAL_CHARS);
        $opening_Hours =sanitizeInput($body,'opening_Hours',FILTER_SANITIZE_SPECIAL_CHARS);
        $description = sanitizeInput($body,'description',FILTER_SANITIZE_SPECIAL_CHARS);
        $latitude = sanitizeInput($body,'latitude', FILTER_VALIDATE_FLOAT);
        $longitude = sanitizeInput($body,'longitude', FILTER_VALIDATE_FLOAT);

        if (!$name) responseError("O nome é obrigatório", 400);
        if(!$contact) responseError("O contato é obrigatório", 400);
        if(!$opening_Hours) responseError("A hora de funcionamento é obrigatório", 400);
        if(!$description) responseError("A descrição é obrigatório", 400);
        if(!$latitude) responseError("A latitude é obrigatório", 400);
        if(!$longitude) responseError("A longitude é obrigatório", 400);

        $place = new Place($name);        
        $place->setContact($contact);
        $place->setOpeningHours($opening_Hours);
        $place->setDescription($description);
        $place->setlatitude($latitude);
        $place->setLongitude($longitude);

        $placeDAO = new PlaceDAO();
        $result = $placeDAO->create($place);
        

        if ($result['success'] === true) {
            

            response(["message" => "Cadastrado com sucesso"], 201);
        } else {
            
            responseError("Não foi possível realizar o cadastro", 400);
        }
    }
    public function listAll()
    {
        $placeDAO = new PlaceDAO;
        $places = $placeDAO->findAll();
        response($places,200);
    }
    
    public function delete()
    {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id) {
            responseError('ID ausente', 400);
        }

        $placeDAO = new PlaceDAO();
        $placeDAO ->delete($id);

        response(['message' => 'Deletado com sucesso'], 204);
    }
    public function findById()
    {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id) {
            responseError('ID ausente', 400);
        }

        $PlaceDAO = new PlaceDAO();
        $item = $PlaceDAO->findByID($id);

        response($item, 200);
    }  
    
    public function updatePlace(){
        $body = getBody();
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    
        if (!$id) {
            responseError('ID ausente', 400);
        }        
        $placeDAO = new PLaceDAO();
        $placeDAO->updateOne($id, $body);
    
        response(['message' => 'atualizado com sucesso'], 200);
    }
}