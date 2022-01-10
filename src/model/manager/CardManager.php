<?php
namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;


class CardManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }

    // get functions

    public function getAll(){
        return $this->getResults(
            "App\Model\Entity\Card",
            "SELECT * FROM card"
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\Card",
            "SELECT * FROM card WHERE id = :id", 
            [
                "id" => $id
            ]
        );
    }

    // insert functions
    
    // delete functions

   

}
