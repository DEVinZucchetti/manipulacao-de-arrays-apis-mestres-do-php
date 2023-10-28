<?php
require_once '../utils.php';

class Review
{
    public $id;
    private $name;
    private $email;
    private $stars;
    private $status;
    private $place_id;

    public function __construct($place_id)
    {
        $this->place_id = $place_id;
        $this->status = 'PENDENTE';
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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getStars()
    {
        return $this->stars;
    }

    public function setStars($stars)
    {
        $this->stars = $stars;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getPlaceId()
    {
        return $this->place_id;
    }
}