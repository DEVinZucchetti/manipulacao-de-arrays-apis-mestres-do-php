<?php
// Métodos que interagem com o bando de dados
class PLaceDAO
{
    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places_database", "docker", "docker");
    }
    public function create(Place $place)
    {
        try {
            $sql = " INSERT INTO places 
                (
                    name,
                    contact,
                    opening_Hours,
                    description,
                    latitude,
                    longitude,
                ) 
                values
                (
                    :name_value,
                    :contact_value,
                    :opening_Hours_value,
                    :description_value,
                    :latitude_value,
                    :longitude_value,
                );
            ";

            $statement = ($this->getConnection())->prepare($sql);
            $statement->bindValue('name_value', $place->getName());
            $statement->bindValue('contact_value', $place->getContact());
            $statement->bindValue('opening_Hours_value', $place->getOpeningHours());
            $statement->bindValue('descriptin_value', $place->getDescription());
            $statement->bindValue('latitude_value', $place->getLatitude());
            $statement->bindValue('longitude_value', $place->getLongitude());
            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            return ['success' => false];
        }
    }
    public function  findAll()
    {
        $sql = "SELECT * FROM places order by name";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findById($id)
    {
        $sql = "SELECT * FROM places where id = :id_value";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->bindValue(":id_value", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM places where id = :id_value";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->bindValue(":id_value", $id);

        $statement->execute();
    }
    public function updateOne($id, $data)
    {
        $placeInDatabase = $this->findById($id);

        $sql = "update places
                        set 
                            name=:name_value,
                            contact=:contact_value,
                            opening_Hours=:opening_Hours_value,
                            description=:description_value,
                            latitude=:latitude_value,
                            longitude=:longitude_value
                    where id=:id_value
             ";

        $statement = ($this->getConnection())->prepare($sql);

        $statement->bindValue(":id_value", $id);

        $statement->bindValue(
            ":name_value",
            isset($data->name) ?
                $data->name :
                $placeInDatabase['name']
        );

        $statement->bindValue(
            ":contact_value",
            isset($data->contact) ?
                $data->contact :
                $placeInDatabase['contact']
        );

        $statement->bindValue(
            ":opening_Hours_value",
            isset($data->opening_Hours) ?
                $data->opening_Hours :
                $placeInDatabase['opening_Hours']
        );

        $statement->bindValue(
            ":description_value",
            isset($data->description) ?
                $data->description :
                $placeInDatabase['description']
        );

        $statement->bindValue(
            ":latitude_value",
            isset($data->latitude) ?
                $data->latitude :
                $placeInDatabase['latitude']
        );

        $statement->bindValue(
            ":longitude_value",
            isset($data->longitude) ?
                $data->longitude :
                $placeInDatabase['longitude']
        );

        $statement->execute();

        return ['success' => true];
    }
    public function getConnection()
    {
        return $this->connection;
    }
}
