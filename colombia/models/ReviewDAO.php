<?php


class ReviewDAO
{

   private $connection;

   public function __construct()
   {
      $this->connection = new PDO("pgsql:host=localhost;dbname=api_places_database", "docker", "docker");
   }

   public function insert(Review $review)
   {
      try {
         $sql = "insert into places
                        (
                            name,
                            place_id,
                            email,
                            stars,
                            status
                        )
                        values
                        (
                           :name,
                           :place_id,
                           :email,
                           :stars,
                           :status
                        );
        ";

         $statement = ($this->getConnection())->prepare($sql);

         $statement->bindValue(":name", $review->getName());
         $statement->bindValue(":place_id", $review->getPlaceId());
         $statement->bindValue(":email", $review->getEmail());
         $statement->bindValue(":stars", $review->getStars());
         $statement->bindValue(":status", $review->getStatus());


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
      $sql = "SELECT * from reviews where id = :id";

      $statement = ($this->getConnection())->prepare($sql);
      $statement->bindValue(":id", $id);
      $statement->execute();

      return $statement->fetch(PDO::FETCH_ASSOC);
   }

   public function deleteOne($id)
   {
      $sql = "delete from reviews where id = :id";

      $statement = ($this->getConnection())->prepare($sql);
      $statement->bindValue(":id", $id);

      $statement->execute();
   }

   public function updateOne($id, $data)
   {
      $placeInDatabase = $this->findOne($id);

      $sql = "update places
                        set 
                            name=:name,
                            place_id=:place_id,
                            email=:email,
                            stars=:stars,
                            status=:status
                    where id=:id_value
             ";



      $statement = ($this->getConnection())->prepare($sql);

      $statement->bindValue(":id", $id);

      $statement->bindValue(
         ":name",
         isset($data->name) ?
            $data->name :
            $placeInDatabase['name']
      );

      $statement->bindValue(
         ":place_id",
         isset($data->place_id) ?
            $data->place_id :
            $placeInDatabase['place_id']
      );

      $statement->bindValue(
         ":email",
         isset($data->email) ?
            $data->email :
            $placeInDatabase['email']
      );

      $statement->bindValue(
         ":stars",
         isset($data->stars) ?
            $data->stars :
            $placeInDatabase['stars']
      );

      $statement->bindValue(
         ":status",
         isset($data->status) ?
            $data->status :
            $placeInDatabase['status']
      );



      $statement->execute();

      return ['success' => true];
   }

   public function getConnection()
   {
      return $this->connection;
   }
}
