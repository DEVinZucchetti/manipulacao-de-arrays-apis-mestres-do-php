<?php 
  require_once '../utils.php';
  require_once '../models/Review.php';
  require_once '../models/ReviewDAO.php';

  class ReviewController
{

   public function create()
   {
      $body = getBody();

      $name = sanitizeString($body->name);
      $place_id = sanitizeString($body->place_id);
      $email = sanitizeString($body->email);
      $stars = sanitizeString($body->stars);
      $status = filter_var($body->status, FILTER_VALIDATE_FLOAT);


      if (!$name || !$place_id || !$email || !$stars || !$status) {
         responseError('Faltaram informações essenciais', 400);
      }


      $review = new Review($name);
      $review->setPlaceId($place_id);
      $review->getEmail($email);
      $review->getStars($stars);
      $review->getStatus($status);


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

   public function delete()
   {
      $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

      if (!$id) {
         responseError('ID ausente', 400);
      }

      $reviewDAO = new ReviewDAO();
      $reviewDAO->deleteOne($id);

      response(['message' => 'Deletado com sucesso'], 204);
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
?>