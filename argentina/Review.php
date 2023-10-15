<?php 

require_once 'utils.php';
 class Review{

    private $id, $name , $email, $stars , $date, $status , $place_Id;
    

public function __construct($place_Id) {
    $this->id = uniqid();
    $this->place_Id = $place_Id;
    $this->date = (new DateTime())->format('d/m/y h:m');
    $this->status = 'PENDENTE';
}

    public function saveReview(){
        $data = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'stars' => $this->getStars(),
            'status' => $this->getStatus(),
            'date' => $this->getDate(),
            'place_id' => $this->getPlace_Id(),
            
        ];

       $allData = readFileContent('reviews.txt');
       array_push($allData, $data );
       saveFileContent('reviews.txt', $allData);
    }
    public function list(){
        $allData = readFileContent('reviews.txt');

        $filtered = array_values(array_filter($allData, function($review){
           return $review->place_id === $this->getPlace_Id();
        }));
        return $filtered;
        var_dump($filtered);
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

   
 }

?>