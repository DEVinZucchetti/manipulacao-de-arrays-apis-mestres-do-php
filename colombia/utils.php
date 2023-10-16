<?php

function getBody()
{
   return json_decode(file_get_contents("php://input"));
}

function readFileContent($fileName)
{
   return json_decode(file_get_contents($fileName));
}

function saveFlieContent($fileName, $content)
{
   file_put_contents($fileName, json_encode($content));
}


function sanitizeInput($data, $property, $filterType)
{
   return isset($data->$property) ? filter_var($data->$property, $filterType) : null;
}
