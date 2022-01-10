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

    public function getAll(){
        return $this->getResults(
            "App\Model\Entity\Color",
            "SELECT * FROM color"
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\Color",
            "SELECT * FROM color WHERE id = :id", 
            [
                "id" => $id
            ]
        );
    }

    // insert functions
    
    // delete functions

   

}
