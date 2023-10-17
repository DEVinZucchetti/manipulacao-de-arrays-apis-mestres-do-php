<?php 
require_once 'config.php';
require_once 'utils.php';

if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID ausente', 400);
    }

    $allData = readFileContent(FILE_CITY);

    $itemsFiltered = array_values(array_filter($allData, function ($item) use ($id) {
        return $item->id !== $id;
    }));


    saveFileContent(FILE_CITY, $itemsFiltered);

    response(['message' => 'Deletado com sucesso'], 204);
    response($allData, 201);
}