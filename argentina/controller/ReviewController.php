<?php

require_once '../utils.php';
require_once '../config.php';
require_once '../models/Review.php';
require_once '../models/ReviewDAO.php';


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
        
    
        $reviewDAO = new ReviewDAO;
        $reviewDAO->create($review);
    
        response(['message' => 'cadastrado com sucesso'],201 );
    }   
    
    
    public function list(){
        $reviewDAO = new ReviewDAO();
        $review = $reviewDAO->findMany();
        response($review, 200);
   
    }

    public function listOne(){
        
        $id = sanitizeInput($_GET,'id',FILTER_VALIDATE_INT, false);

        if(!$id) responseError('ID do lugar não informado',400);

        $reviewDAO = new ReviewDAO($id);

        response($reviewDAO->findOne($id), 200);

    }
    public function update(){
        $body = getBody();
      $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

      if (!$id) {
         responseError('ID ausente', 400);
      }

      $reviewDAO = new ReviewDAO();
      $reviewDAO->update($id, $body);

      response(['message' => 'atualizado com sucesso'], 200);
   }
    }


