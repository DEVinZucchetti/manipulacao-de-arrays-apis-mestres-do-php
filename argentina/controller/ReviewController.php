<?php
require_once '../utils/utils.php';
require_once '../utils/config.php';
require_once '../models/Review.php';


class ReviewController{
   
    public function create(){
        $body = getBody();
        $place_id = sanitizeInput($body, 'place_id', FILTER_VALIDATE_INT);
        $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
        $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);
       
    
        $blacklist = ['polimorfismo',  'herança', 'abstração', 'encapsulamento'];

        if(!$place_id) responseError('Id do lugar ausente', 400);
        if (!$name) responseError('Descrição da avaliação ausente', 400);
        if (!$email) responseError('Email inválido', 400);
        if (!$stars) responseError('Quantidade de estrelas ausente', 400);
    
        if (strlen($name)>200) responseError('O texto ultrapassou o limite de caracteres',400);
    
        foreach($blacklist as $word){
            if(str_contains(strtolower($name), $word )) {  //deixa as letras em minusculo percorre em todo o name procurando a palavra
                $name = str_ireplace($word, '[EDITADO PELO ADMIN]', $name); // RENOMEIA A PALAVRA PROIBIDA //IREPLACE ANTISENSITIVO
            }
        }
        $review = new Review($place_id);
        $review->setName($name);
        $review->setEmail($email);
        $review->setStars($stars);
        
    
    
        $review->saveReview();
    
        response(['message' => 'cadastrado com sucesso'],201 );
    }   

    public function list(){
        
        $place_id = sanitizeInput($_GET,'id',FILTER_VALIDATE_INT, false);

        if(!$place_id) responseError('ID do lugar não informado',400);

        $reviews = new Review($place_id);

        response($reviews->list(), 200);

    }
    public function update(){
        $body = getBody();
        $id =  sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
    
        $status = sanitizeInput($body,  'status', FILTER_SANITIZE_SPECIAL_CHARS);
    
        if (!$status) {
            responseError('Sem status', 400);
        }
    
        $review = new Review();
        $review->updateStatus($id, $status);

        response(200, ['message' => 'Atualizado com sucesso!']);
        }
    }


