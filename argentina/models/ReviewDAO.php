<?php

class ReviewDAO{

    private $connection;

    
    public function __construct( )
    {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places_database", "docker", "docker");
    }

    
    public function create(Review $review)
    {
        try {
            $sql = "INSERT INTO reviews
            (                    
                name,
                email,
                stars,
                status,
                date,
                place_id
            )
            values
            (                    
                :name_value,
                :email_value,
                :stars_value,
                :status_value,
                :date_value,
                :place_id_value
            )";
              $statement = ($this->getConnection())->prepare($sql);
              $statement->bindValue(":name_value", $review->getName());
              $statement->bindValue(":email_value", $review->getEmail());
              $statement->bindValue(":stars_value", $review->getStars());
              $statement->bindValue(":status_value", $review->getStatus());
              $statement->bindValue(":date_value", $review->getDate());
              $statement->bindValue(":place_id_value", $review->getPlace_id());
              $statement->execute();
  
              return ['success' => true];
          } catch (PDOException $error) {
              debug($error->getMessage());
              return ['success' => false];
          }
      } 

      public function findMany()
      {
          $sql = "select * from reviews order by id";
  
          $statement = ($this->getConnection())->prepare($sql);
          $statement->execute();
  
          return $statement->fetchAll(PDO::FETCH_ASSOC);
      }
  

      public function findOne($id){
        $sql = "SELECT * FROM reviews where id = :id_value";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->bindValue(":id_value", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);

      }

          
      public function update($id, $data)
      {
          $reviewInDatabase = $this->findOne($id);
      
          $sql = "update reviews
          set 
              name=:name_value,
              place_id=:place_id_value,
              email=:email_value,
              stars=:stars_value,
              status=:status_value
                where id=:id_value
              ";
      
          $statement = ($this->getConnection())->prepare($sql);
      
          $statement->bindValue(":id_value", $id);
      
          function bindValues($statement, $data, $reviewInDatabase, $field)
          {
              $value = isset($data->$field) ? $data->$field : $reviewInDatabase[$field];
              $statement->bindValue(":{$field}_value", $value);
          }
      
          bindValues($statement, $data, $reviewInDatabase, 'name');
          bindValues($statement, $data, $reviewInDatabase, 'place_id');
          bindValues($statement, $data, $reviewInDatabase, 'email');
          bindValues($statement, $data, $reviewInDatabase, 'stars');
          bindValues($statement, $data, $reviewInDatabase, 'status');
      
          $statement->execute();
      
          return ['success' => true];
      }
      
    
      public function getConnection()
      {
          return $this->connection;
      }
  }
