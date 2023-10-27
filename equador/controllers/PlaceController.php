<?php
require_once 'utils.php';
require_once '../models/Place.php';

class PlaceController
{

    public function createOne()
    {
        $body = getBody();

        $name = sanitizeString($body->name);
        $contact = sanitizeString($body->contact);
        $opening_hours = sanitizeString($body->opening_hours);
        $description = sanitizeString($body->description);
        $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
        $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

        if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
            responseError('Faltaram informações essenciais', 400);
        }

        /* $allData = readFileContent(FILE_CITY);

        $itemWithSameName = array_filter($allData, function ($item) use ($name) {
            return $item->name === $name;
        });

        if (count($itemWithSameName) > 0) {
            responseError('O item já existe', 409);
        }*/

        $place = new Place();
        $place->setContact($name);
        $place->setContact($contact);
        $place->setOpening_hours($opening_hours);
        $place->setDescription($description);
        $place->setLatitude($latitude);
        $place->setLongitude($longitude);

        $placeDAO = new PlaceDAO();

        $result = $placeDAO->insert($place);

        if ($result['success'] === true) {
            response(["message" => "Cadastrado com sucesso"], 201);
        } else {
            responseError("Não foi possível realizar o cadastro", 400);
        }
    }

    public function listAll()
    {
        $placeDAO = new PlaceDAO();
        $place = $placeDAO->findMany();
        response($place, 200);
    }


    public function listOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('O id é inválido', 400);

        $placeDAO = new PlaceDAO();

        $result = $placeDAO->findOne($id);

        if (!$result) responseError('Não foi encontrado um lugar com esse id', 404);

        response($result, 200);
    }


    public function deleteOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('O id é inválido', 400);

        $placeDAO = new PlaceDAO();

        $placeExists = $placeDAO->findOne($id);

        if (!$placeExists) responseError('Não foi encontrado um lugar com esse id', 404);

        $result = $placeDAO->deleteOne($id);

        if ($result['success'] === true) {
            response([], 204);
        } else {
            responseError('Não foi possível deletar o item', 400);
        }
    }

    public function updateOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
        $body = getBody();

        if (!$id) responseError('O id esta ausente', 400);

        if (isset($body->name) && empty($body->name)) {
            responseError('O nome não pode ser vazio', 400);
        }

        $placeDAO = new PlaceDAO();

        $result = $placeDAO->updateOne($id, $body);

        if ($result['success'] === true) {
            response([], 200);
        } else {
            responseError('Não foi possível atualizar o item', 400);
        }
    }
}
