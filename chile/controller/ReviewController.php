<?php
require_once '../models/Review.php';
require_once '../utils.php';
require_once '../models/ReviewDao.php';

class ReviewController
{
    public function create()
    {
        $blacklist = ['polimorfismo',  'herança', 'abstração', 'encapsulamento'];
        $body = getBody();

        $place_id = sanitizeInput($body, 'place_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
        $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);

        if (!$place_id) responseError('Id do lugar ausente', 400);
        if (!$name) responseError('Descrição da avaliação ausente', 400);
        if (!$email) responseError('Email inválido', 400);
        if (!$stars) responseError('Quantidade de estrelas ausente', 400);

        if (strlen($name) > 200) responseError('O texto ultrapassou o limite', 400);

        foreach ($blacklist as $word) {
            if (str_contains(strtolower($name), $word)) {
                $name = str_ireplace($word, '😷', $name);
            }
        }

        $review = new Review($place_id);
        $review->setName($name);
        $review->setEmail($email);
        $review->setStars($stars);

        $reviewDAO = new ReviewDao();
        $reviewDAO->insert($review);

        response(['message' => 'Cadastro com sucesso'], 201);
    }

    public function list()
    {
        $reviewDAO = new ReviewDAO();
        response($reviewDAO->findMany(), 200);
    }

    public function listOne(){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id) {
            responseError('ID ausente', 400);
        }
        $reviewDAO = new ReviewDAO();
        $item = $reviewDAO->findOne($id);
        response($item, 200);

    }

    public function update()
    {
        $body = getBody();
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        $reviewDAO = new ReviewDAO();
        $reviewDAO->updateOne($id, $body);
        response($reviewDAO->findOne($id), 200);
    }

    public function delete()
    {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id) {
            responseError('ID ausente', 400);
        }

        $reviewDAO = new reviewDAO();
        $result = $reviewDAO->deleteOne($id);
    }
}
