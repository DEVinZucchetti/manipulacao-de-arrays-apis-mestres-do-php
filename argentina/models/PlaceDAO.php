<?php

class PlaceDAO
{

    private $connection;

    public function __construct( )
    {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places_database", "docker", "docker");
    }

    public function insert(Place $place)
    {
        try {
            $sql = "insert into places
        (
            name,
            contact,
            opening_hours,
            description,
            latitude,
            longitude
        )
         values
         (
            :name_value,
            :contact_value,
            :opening_hours_value,
            :description_value,
            :latitude_value,
            :longitude_value

         )   
    ";
            $statement = ($this->getConnection())->prepare($sql);
            $statement->bindValue(":name_value", $place->getName());
            $statement->bindValue(":contact_value", $place->getContact());
            $statement->bindValue(":opening_hours_value", $place->getOpeninghours());
            $statement->bindValue(":description_value", $place->getDescription());
            $statement->bindValue(":latitude_value", $place->getLatitude());
            $statement->bindValue(":longitude_value", $place->getLongitude());

            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function findMany()
    {
        $sql = "select * from places order by name ";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOne($id)
    {
        $sql = "SELECT * FROM places where id = :id_value";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->bindValue(":id_value", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function updateOne($id, $data)
    {
        $placeInDatabase = $this->findOne($id);

        $sql = "update places
                        set 
                        name=:name_value,
                        contact=:contact_value,
                        opening_hours=:opening_hours_value,
                        description=:description_value,
                        latitude=:latitude_value,
                        longitude=:longitude_value
                 where id = :id_value
            ";

        $statement = ($this->getConnection())->prepare($sql);

        $statement->bindValue(":id_value", $id);


        function bindValues($statement, $data, $placeInDatabase, $field)
        {
            $value = isset($data->$field) ? $data->$field : $placeInDatabase[$field];
            $statement->bindValue(":{$field}_value", $value);
        }
        bindValues($statement, $data, $placeInDatabase, 'name');
        bindValues($statement, $data, $placeInDatabase, 'contact');
        bindValues($statement, $data, $placeInDatabase, 'opening_hours');
        bindValues($statement, $data, $placeInDatabase, 'description');
        bindValues($statement, $data, $placeInDatabase, 'latitude');
        bindValues($statement, $data, $placeInDatabase, 'longitude');

        $statement->execute();

        return ['success' => true];
    }
    public function deleteOne($id)
    {
        $sql = "DELETE  FROM places where id = :id_value";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->bindValue(":id_value", $id);
        $statement->execute();
    }
    public function getConnection()
    {
        return $this->connection;
    }
}
