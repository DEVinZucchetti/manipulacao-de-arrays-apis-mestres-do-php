<?php 

 class Review{

    private $id, $name , $email, $stars , $date, $status , $place_Id;
    



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

        return $this;
    }
    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

   
    public function getStars()
    {
        return $this->stars;
    }
    public function setStars($stars)
    {
        $this->stars = $stars;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

  
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

   
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }


    public function getPlace_Id()
    {
        return $this->place_Id;
    }

    public function setPlace_Id($place_Id)
    {
        $this->place_Id = $place_Id;

        return $this;
    }
 }

?>