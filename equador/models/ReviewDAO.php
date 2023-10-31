<?php

class ReviewDAO
{
    private $connection;

    public function __construct()
    {   
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places_database", "docker", "docker");
        //$this->connection = new Connections();
    }

    public function insert(Review $review)
    {
        try {
            $sql = "INSERT INTO reviews (name, email, stars, date, status, place_id) 
                            VALUES (:name_value, :email_value, :stars_value, :date_value, :status_value, :place_id_value)";

            
            $statement = ($this->getConnection())->prepare($sql);
            
            $statement->bindValue(":name_value", $review->getName());
            $statement->bindValue(":email_value", $review->getEmail());
            $statement->bindValue(":stars_value", $review->getStars());
            $statement->bindValue(":date_value", $review->getDate());
            $statement->bindValue(":status_value", $review->getStatus());
            $statement->bindValue(":place_id_value", $review->getPlace_id());

            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
           
            return ['success' => false];
        }
    }

    public function findMany()
    {
        $sql = "SELECT id, name FROM reviews";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findOne($id)
    {
        $sql = "SELECT * from reviews where id = :id_value";

        $statement = ($this->getConnection())->prepare($sql);

        $statement->bindValue(":id_value", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOne($id, $data)
    {
        $reviewInDatabase = $this->findOne($id);

        $sql = "UPDATE reviews
                SET 
                status = :status_value
                WHERE id = :id_value
            ";

        $statement = ($this->getConnection())->prepare($sql);

        $statement->bindValue(":id_value", $id);
        $statement->bindValue(
            ":status_value",
            isset($data->status) ?
                $data->status :
                $reviewInDatabase['status']
        );

        $statement->execute();

        return ['success' => true];
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
