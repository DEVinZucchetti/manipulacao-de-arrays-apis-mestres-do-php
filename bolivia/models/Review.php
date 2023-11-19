<?php 


// nome da classe
//atributos da classe
class Review{

    private $id, $name, $email, $stars, $date, $status, $place;

    public function __construct($place)
    {
        $this->place = $place;
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
}
?>