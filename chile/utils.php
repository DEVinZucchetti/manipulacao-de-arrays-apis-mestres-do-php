<?php

function getBody() {
  return json_decode(file_get_contents("php://input")); // pegar o body no formato de string
}

function readFileContent($fileName){
   return json_decode(file_get_contents($fileName));
}

function saveFileContent($fileName, $content) {
  file_put_contents($fileName, json_encode($content));
}

function responseError($msg, $cod){
  http_response_code($cod);
  echo json_encode(['error' => $msg]);
}
function response($it, $cod){
  http_response_code($cod);
  echo json_encode($it);
}