<?php
require_once '../utils/utils.php';
require_once '../models/Review.php';
require_once '../DAO/ReviewDAO.php';

class ReviewController
{
        public function create()
    {
        $body = getBody();

        $place_id = sanitizeInput($body, 'place_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
        $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);

        $palavras_reservadas = ['polimorfismo', 'herança', 'abstração', 'encapsulamento'];

        if (!$place_id) responseError(400, 'Id do lugar ausente');
        if (!$name) responseError(400, 'Descrição da avaliação ausente');
        if (!$email) responseError(400, 'Email ausente');
        if (!$stars) responseError(400, 'Quantidade de estrelas ausente');

        if (strlen($name) > 200) responseError(400, 'O texto ultrapassou o limite');

        foreach ($palavras_reservadas as $word) {
            if (str_contains(strtolower($name), $word)) {
                $name = str_ireplace($word, '[EDITADO PELO ADMIN]', $name);
            }
        }

        $review = new Review($place_id);
        $review->setName($name);
        $review->setEmail($email);
        $review->setStars($stars);
        $reviewDAO = new ReviewDAO();
        $result = $reviewDAO->create($review);

        if ($result['success'] === true) {
            response(["message" => "Cadastrado com sucesso"], 201);
        } else {
            responseError("Não foi possível realizar o cadastro", 400);
        }
    }

    public function findDyId(){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id) {
            responseError('ID ausente', 400);
        }
        $reviewDAO = new ReviewDAO();
        $item = $reviewDAO->findById($id);

        response($item, 200);
    }
    public function listAll()
    {
        $reviewDAO = new ReviewDAO();
        $reviews = $reviewDAO->findAll();
        response($reviews,200);      
    }
    public function delete(){
        $id = filter_var($_GET['id'],FILTER_SANITIZE_SPECIAL_CHARS);

        if(!$id){
            responseError('ID ausente',400);
        }
        $reviewDAO = new ReviewDAO();
        $reviewDAO->delete($id);
        response(['message'=> 'deletado con sucesso'],204);

    }

    public function updateStatus(){
        $body = getBody();
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $status = sanitizeInput($body,'status', FILTER_SANITIZE_SPECIAL_CHARS);


        if (!$id) {
            responseError('ID ausente', 400);
        }

        $reviewDAO = new ReviewDAO();
        $reviewDAO->updateStatus($id, $status);

        response(['message' => 'atualizado com sucesso'], 200);
    }

    public function update()
    {
        $body = getBody();
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id) {
            responseError('ID ausente', 400);
        }

        $reviewDAO = new ReviewDAO();
        $reviewDAO->updateOne($id, $body);

        response(['message' => 'atualizado com sucesso'], 200);
    }
}
