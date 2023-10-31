<?php
/*
class Connections
{

    private $host;
    private $username;
    private $password;
    private $database;
    private $pdo;

    public function __construct()
    {
        $this->host = 'localhost';
        $this->username = 'docker';
        $this->password = 'docker';
        $this->database = 'api_places_database';


        $this->connect();
    }

    private function connect()
    {
        $dataServer = "mysql:host={$this->host};dbname={$this->database}";

        try {
            $this->pdo = new PDO($dataServer, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
}*/
