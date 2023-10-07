
<?php 
require_once'config.php';
require_once'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'POST') {

        $body = getBody();
          
          $name = sanitizeString($body->$name);
          $contact = sanitizeString($body->$contact);
          $openingHours = sanitizeString($body->$openingHours);
          $description = sanitizeString($body->$description);
          $latitude = filter_var($body->latitude , FILTER_VALIDATE_FLOAT);
          $longitude = filter_var($body->longitude , FILTER_VALIDATE_FLOAT );
      

    if (!$name || !$contact || !$openingHours || !$description || !$latitude || !$longitude) {
       responseError('Faltam dados!', 400) ;
       
    }
    
    $data = [
        'name' => $name,
        'contact' => $contact,
        'opening_Hours' => $openingHours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];


    $allData = readFileContent(FILE_CITY);
    array_push($allData, $data);
    saveFileContent(FILE_CITY, $allData);

    responseCode($data, 201);
    
  

}