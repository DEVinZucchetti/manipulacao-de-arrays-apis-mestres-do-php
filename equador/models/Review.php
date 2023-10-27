<?php 

class Review{

    private $id, $name, $email, $stars, $date, $status, $place_id;

    public function __construct($place_id)
    {
        $this->place_id = $place_id;
        $this->id = uniqid();
    }

    public function save(){
        
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

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

    }

    public function getPlace_id()
    {
        return $this->place_id;
    }
 
    public function setPlace_id($place_id)
    {
        $this->place_id = $place_id;

    }
}
?>