<?php
require_once '../config/config.php';
class ReviewDAO
{
    private $connection;
    public function __construct()
    {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places_database", "docker", "docker");    }
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
    public function findAll()
    {
       $sql = "SELECT * FROM reviews";

       $statement = ($this->getConnection())->prepare($sql);
       $statement->execute();

       return $statement->fetchAll(PDO::FETCH_ASSOC);
    } 

    public function findById($id)
    {
        $sql = "SELECT * FROM reviews where id = :id_value";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->bindValue(":id_value", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function updateStatus($id, $status)
    {
        try {    
            $sql = "UPDATE reviews 
                SET status = 
                    :novo_status_value
                WHERE id = :review_id_value";
            
            $statement = ($this->getConnection())->prepare($sql);
            
            $statement->bindValue(':novo_status_value', $status);
            $statement->bindValue(':review_id_value', $id);            
            $statement->execute();
    
            if ($statement->rowCount() > 0) {
                echo "Status atualizado com sucesso!";
            } else {
                echo "Nenhuma revisão encontrada com o ID especificado.";
            }
        } catch (PDOException $error) {
            echo "Erro ao atualizar o status: " . $error->getMessage();
        }
    }    
        public function delete($id)
    {
        $sql = "delete from reviews where id = :id_value";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->bindValue(":id_value", $id);
        
        $statement->execute();
    }

    public function updateOne($id, $data)
    {
        try{

            $reviewInDatabase = $this->findById($id);
            
            $sql = "update places
                        set                         
                        name=:name_value,
                        email=:email_value,
                        stars=:stars_value,
                        status=:status_value,
                        date=:date_value,
                        place_id=:place_id_value
                        where id=:id_value
                        ";

                        $statement = ($this->getConnection())->prepare($sql);
                        
                        $statement->bindValue(":id_value", $id);
                        
                        $statement->bindValue(
                            ":name_value",
                            isset($data->name) ?
                     $data->name :
                     $reviewInDatabase['name']
                    );
                    
                    $statement->bindValue(
                        ":email_value",
                        isset($data->email) ?
                        $data->email :
                        $$reviewInDatabase['email']
                    );
                    
                    $statement->bindValue(
                        ":stars_value",
                        isset($data->stars) ?
                        $data->stars :
                    $$reviewInDatabase['stars']
            );

            $statement->bindValue(
                ":status_value",
                isset($data->status) ?
                $data->status :
                $$reviewInDatabase['status']
            );
            
            $statement->bindValue(
                ":date_value",
                isset($data->date) ?
                $data->date :
                $$reviewInDatabase['date']
            );
            
            $statement->bindValue(
                ":place_id_value",
                isset($data->place_id) ?
                $data->place_id :
                $$reviewInDatabase['place_id']
            );
            
            $statement->execute();
            
            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }        
        public function getConnection()
        {
            return $this->connection;
        }
    }
