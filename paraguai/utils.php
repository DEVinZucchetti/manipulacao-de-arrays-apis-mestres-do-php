<?php

function getBody() {
   return json_decode(file_get_contents("php://input")); // Pega o body no formato de string
}

function readFileContent($fileName) {
   return json_decode(file_get_contents($fileName)); // Lê o conteúdo do arquivo
}

function saveFileContent($fileName, $content) {
   file_put_contents($fileName, json_encode($content)); // Salva o conteúdo do arquivo
}

function sanitizeString($value) {
   return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
}

function responseError($message, $status) {
   http_response_code($status);
   echo json_encode(['error' => $message]);
   exit;
 }

 function response($response, $status) {
   http_response_code($status);
   echo json_encode($response);
   exit;
 }