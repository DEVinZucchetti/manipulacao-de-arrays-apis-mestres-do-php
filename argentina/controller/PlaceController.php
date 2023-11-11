<?php
require_once '../utils.php';
require_once '../config.php';
require_once '../models/Place.php';
require_once '../models/PlaceDAO.php';



class PlaceController{

    public function create(){
        $body = getBody();

        $name = sanitizeString($body->name);
        $contact = sanitizeString($body->contact);
        $opening_hours = sanitizeString($body->opening_hours);
        $description = sanitizeString($body->description);
        $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
        $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);
    
        if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
            responseError('Faltaram informacoes essenciais', 400);
        }
       
    
      $place = new Place($name);
      $place->setContact($contact);
      $place->setOpeninghours($opening_hours);
      $place->setDescription($description);
      $place->setLatitude($latitude);
      $place->setLongitude($longitude);


      $PlaceDAO = new PlaceDAO();
     $result = $PlaceDAO->insert($place);
      if($result['success'] === true) {
        response(["message" => "Cadastrado com sucesso"], 201);
    } else {
        responseError("Não foi possível realizar o cadastro", 400);
    }

}


    public function list(){
        $PlaceDAO = new PlaceDAO();
        $places = $PlaceDAO->findMany();
        response($places, 200);
   
    }

  
    public function listOne()
    {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id) {
            responseError('ID ausente', 400);
        }

        $placeDAO = new PlaceDAO();
        $item = $placeDAO->findOne($id);

        response($item, 200);
    }
    public function update(){

        $body = getBody();
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    
        if (!$id) {
            responseError('ID ausente', 400);
        }
    
        $placeDAO= new PlaceDAO();
        $placeDAO->updateOne($id, $body);
    
        response(['message' => 'atualizado com sucesso'], 200);
    }
    public function delete(){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id) {
            responseError('ID ausente', 400);
        }
    
        $placeDAO = new PlaceDAO();
        $placeDAO->deleteOne($id);
    
        response(['message' => 'Deletado com sucesso'], 204);
    
    }
}