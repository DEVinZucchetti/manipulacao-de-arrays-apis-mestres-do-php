<?php 
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Obtenha o corpo da solicitação em formato JSON e decodifique-o
    $body = getBody();

    // Valide e filtre os dados recebidos do corpo da solicitação
    //Pode criar uma funcao pra otimizar 
    $name = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
    $opening_hours = filter_var($body->opening_hours, FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_var($body->latitude, FILTER_SANITIZE_NUMBER_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_SANITIZE_NUMBER_FLOAT);


    // Verifique se algum campo obrigatório está vazio
    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
       responseError('Preencha todos os campos', 400);
    }
}
?>