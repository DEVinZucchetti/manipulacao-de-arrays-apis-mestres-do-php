<?php
require_once 'config.php';

class Place
{

    public $id;
    private $name;
    private $contact;
    private $opening_hours;
    private $description;
    private $latitude;
    private $longitude;

    public function __construct($name = null)
    {
        $this->id = uniqid();
        $this->name = $name;
    }

    public function save()
    {
        $data = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'contact' => $this->getContact(),
            'opening_hours' => $this->getOpeningHours(),
            'description' => $this->getDescription(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude()
        ];
        $allData = readFileContent(LOCAIS);
        array_push($allData,  $data);
        saveFileContent(LOCAIS, $allData);
    }

    public function list()
    {
        $allData = readFileContent(LOCAIS);
        return $allData;
    }

    public function delete($id)
    {
        $allData = readFileContent(LOCAIS);
        $itemsFiltered = array_values(array_filter($allData, function ($item) use ($id) {
            return $item->id !== $id;
        }));
        saveFileContent(LOCAIS, $itemsFiltered);
    }

    public function update($id, $data)
    {
        $allData = readFileContent(LOCAIS);


        foreach ($allData as $position => $item) {
            if ($item->id === $id) {
                $allData[$position]->name =  isset($data->name) ? $data->name : $item->name;
                $allData[$position]->contact =  isset($data->contact) ? $data->contact : $item->contact;
                $allData[$position]->opening_hours =   isset($data->opening_hours) ? $data->opening_hours : $item->opening_hours;
                $allData[$position]->description =  isset($data->description) ? $data->description : $item->description;
                $allData[$position]->latitude =  isset($data->latitude) ? $data->latitude : $item->latitude;
                $allData[$position]->longitude =  isset($data->longitude) ? $data->longitude : $item->longitude;
            }

            saveFileContent(LOCAIS, $allData);
        }
    }

    public function listOne($id)
    {

        $allData = readFileContent(LOCAIS);

        foreach ($allData as $item) {
            if ($item->id === $id) {
               return $item;
            }
        }
    }



    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getContact()
    {
        return $this->contact;
    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    public function getOpeningHours()
    {
        return $this->opening_hours;
    }

    public function setOpeningHours($opening_hours)
    {
        $this->opening_hours = $opening_hours;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
}