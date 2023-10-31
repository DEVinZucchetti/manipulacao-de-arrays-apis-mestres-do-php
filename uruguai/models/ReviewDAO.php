<?php

require_once '../models/Database.php';


class ReviewDAO extends Database
{
    public function insert(Review $review)
    {
        try {
            $sql = "insert into reviews
                        (
                            place_id,
                            name,
                            email,
                            stars,
                            status
                        )
                        values
                        (
                            :place_id_value,
                            :name_value,
                            :email_value,
                            :stars_value,
                            :status_value
                        );
        ";

            $statement = ($this->getConnection())->prepare($sql);

            $statement->bindValue(":place_id_value", $review->getPlaceId());
            $statement->bindValue(":name_value", $review->getName());
            $statement->bindValue(":email_value", $review->getEmail());
            $statement->bindValue(":stars_value", $review->getStars());
            $statement->bindValue(":status_value", $review->getStatus());


            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function findMany()
    {
        $sql = "select * from reviews";

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
        $placeInDatabase = $this->findOne($id);

        $sql = "update reviews
                        set 
                            place_id=:place_id_value,
                            name=:name_value,
                            email=:email_value,
                            stars=:stars_value,
                            status=:status_value
                    where id=:id_value
             ";

             $statement = ($this->getConnection())->prepare($sql);

             $statement->bindValue(":id_value", $id);

             $statement->bindValue(
                 ":place_id_value",
                 isset($data->place_id) ?
                     $data->place_id :
                     $placeInDatabase['place_id']
             );

             $statement->bindValue(
                ":name_value",
                isset($data->name) ?
                    $data->name :
                    $placeInDatabase['name']
            );

            $statement->bindValue(
                ":email_value",
                isset($data->email) ?
                    $data->email :
                    $placeInDatabase['email']
            );

            $statement->bindValue(
                ":stars_value",
                isset($data->stars) ?
                    $data->stars :
                    $placeInDatabase['stars']
            );

            $statement->bindValue(
                ":status_value",
                isset($data->status) ?
                    $data->status :
                    $placeInDatabase['status']
            );


            $statement->execute();

            return ['success' => true];
    }
}