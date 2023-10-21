<?php
require_once 'utils/utils.php';
require_once 'models/Review.php';

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
        $review->save();

        response(201, ['message' => "Cadastrado com sucesso"]);
    }

    public function list()
    {

        $place_id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS, false);
        if (!$place_id) {
            responseError(400, 'Id do lugar ausente');
        }
        $reviews = new Review($place_id);
        response(200, $reviews->list());
    }

    public function update()
    {

        $body = getBody();
        $id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
        $status = sanitizeInput($body, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$status) {
            responseError(400, 'Status ausente');
        }

        $review = new Review();
        $review->updateStatus($id, $status);
        response(200, ['message' => 'Atualizado com sucesso']);
    }
}
