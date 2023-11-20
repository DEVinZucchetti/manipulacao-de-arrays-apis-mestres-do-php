<?php 
require_once './utils.php';

// nome da classe
//atributos da classe


/*
enum ReviewsStatus {
    case 'plano_g': 'GOLD';
    case 2: 'FINALIZADO';
    case 3: 'REPROVADO';
}
*/
class Review{

    private $id, $name, $email, $stars, $date, $status, $place_id;

    public function __construct($place_id)
    {
        $this->place_id = $place_id;
        $this->id = uniqid();
        $this->date = (new DateTime())->format('d/m/Y h:m');
        $this->status = 'PENDENTE';
    }

    public function save(){

       
            $data = [
                'id' => $this->getId(),
                'name' => $this->getName(),
                'email' => $this->getEmail(),
                'stars' => $this->getStars(),
                'status' => $this->getStatus(),
                'date' => $this->getDate(),
                'place_id' => $this->getPlaceId()
                
            ];
    
           $allData = readFileContent('reviews.txt');
           array_push($allData, $data );
           saveFileContent('reviews.txt', $allData);
        
        
    }

    public function list()
    {
        $allData = readFileContent('reviews.txt');

        $filtered = array_values(array_filter($allData, function ($review) {
            return $review->place_id === $this->getPlaceId();
        }));

        return $filtered;
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

    public function getPlaceId()
    {
        return $this->place_id;
    }
}
?>