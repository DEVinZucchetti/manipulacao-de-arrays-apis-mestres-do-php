<?php
require_once 'config.php';

class Place
{

    private $id;
    private $name;
    private $contact;
    private $opening_hours;
    private $description;
    private $latitude;
    private $longitude;

    public function __construct()
    {
        $this->id = uniqid();
    }

    public function save()
    {
        $data = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'contact' => $this->getContact(),
            'opening_hours' =>  $this->getOpening_hours(),
            'description' => $this->getDescription(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude()
        ];

        $allData = readFileContent(FILE_CITY);
        array_push($allData, $data);
        saveFileContent(FILE_CITY, $allData);
    }

    public function delete($id)
    {           
        $allData = readFileContent(FILE_CITY);
       
        $itemsFiltered = array_values(array_filter($allData, function ($item) use ($id) {           
           return $item->id != $id;
        }));
        
        saveFileContent(FILE_CITY, $itemsFiltered);
       
     }

    public function listar()
    {
        $allData = readFileContent(FILE_CITY);
        return $allData;
    }

    public function update($id, $data)
    {
        $allData = readFileContent(FILE_CITY);

        foreach ($allData as $index => $item) {
            if ($item->id === $id) {
                $allData[$index]->name =  isset($data->name) ? $data->name : $item->name;
                $allData[$index]->contact =  isset($data->contact) ? $data->contact : $item->contact;
                $allData[$index]->opening_hours =   isset($data->opening_hours) ? $data->opening_hours : $item->opening_hours;
                $allData[$index]->description =  isset($data->description) ? $data->description : $item->description;
                $allData[$index]->latitude =  isset($data->latitude) ? $data->latitude : $item->latitude;
                $allData[$index]->longitude =  isset($data->longitude) ? $data->longitude : $item->longitude;
            }
        }

        saveFileContent(FILE_CITY, $allData);
    }
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    public function getContact()
    {
        return $this->contact;
    }

    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    public function getOpening_hours()
    {
        return $this->opening_hours;
    }

    public function setOpening_hours($opening_hours)
    {
        $this->opening_hours = $opening_hours;

        return $this;
    }


    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
}
