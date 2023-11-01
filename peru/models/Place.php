<?php
require_once '../config/config.php';
class Place
{
    public $id;
    private $name;
    private $contact;
    private $opening_Hours;
    private $description;
    private $latitude;
    private $longitude;

    public function __construct($name)
    {
        $this->name = $name;
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
        return $this->opening_Hours;
    }
    public function setOpeningHours($opening_Hours)
    {
        $this->opening_Hours = $opening_Hours;
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
    public function getId()
    {
        return $this->id;
    }
}
