<?php
require_once '../utils.php';
require_once '../models/Review.php';
require_once '../models/ReviewDAO.php';

class ReviewController
{

    public function create()
    {
        $inappropriateWords = ['polimorfismo',  'herança', 'abstração', 'encapsulamento'];
        $body = getBody();

        $place_id = filter_var($body->place_id, FILTER_VALIDATE_INT);
        $name = sanitizeString($body->name);
        $email = filter_var($body->email, FILTER_VALIDATE_EMAIL);
        $stars = filter_var($body->stars, FILTER_VALIDATE_FLOAT);

        if (!$place_id) responseError('ID do local ausente', 400);
        if (!$name) responseError('Descrição da avaliação ausente, por favor, insira o nome de um local', 400);
        if (!$email) responseError('Email inválido', 400);
        if (!$stars) responseError('Quantidade de estrelas ausente, por favor, insira sua avaliação', 400);

        foreach ($inappropriateWords as $word) {
            if (str_contains(strtolower($name), $word)) {
                $name = str_ireplace($word, '[EDITADO PELO ADMIN]', $name);
            }
        }

        $review = new Review($place_id);
        $review->setName($name);
        $review->setEmail($email);
        $review->setStars($stars);

        $reviewDAO = new ReviewDAO();
        $result = $reviewDAO->insert($review);

        if ($result['success'] === true) {
            response(["message" => "Cadastrado com sucesso"], 201);
        } else {
            responseError("Não foi possível realizar o cadastro", 400);
        }
    }


    public function list()
    {
        $reviewDAO = new ReviewDAO();
        $result = $reviewDAO->findMany();
        response($result, 200);
    }

    public function listOne()
    {
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

        if (!$id) {
            responseError('ID ausente', 400);
        }

        $reviewDAO = new ReviewDAO();
        $reviewDAO->updateOne($id, $body);

        response(['message' => 'atualizado com sucesso'], 200);
    }
}