
<?php 
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'POST') {

        $body = getBody();
          
          $name = filter_var($body->name , FILTER_SANITIZE_SPECIAL_CHARS );
          $contact = filter_var($body->contact , FILTER_SANITIZE_SPECIAL_CHARS );
          $openingHours = filter_var($body->openingHours , FILTER_SANITIZE_SPECIAL_CHARS );
          $description = filter_var($body->description , FILTER_SANITIZE_SPECIAL_CHARS );
          $latitude = filter_var($body->latitude , FILTER_VALIDATE_FLOAT);
          $longitude = filter_var($body->longitude , FILTER_VALIDATE_FLOAT );
      

    if (!$guiche) {
        echo json_encode(['error' => 'Não foi enviado o Nº do guiche']);
    }
    }

?>