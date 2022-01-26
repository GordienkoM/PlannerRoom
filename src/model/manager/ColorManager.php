<?php
namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;


class ColorManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }

    // get functions

    public function getAllColors(){
        return $this->getResults(
            "App\Model\Entity\Color",
            "SELECT * FROM colors"
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\Color",
            "SELECT * FROM colors WHERE id = :id", 
            [
                "id" => $id
            ]
        );
    }
   
}
