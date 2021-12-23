<?php
namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;

class TableAppManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }


    public function getAll(){
        return $this->getResults(
            "App\Model\Entity\TableApp",
            "SELECT * FROM tableApp"
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\TableApp",
            "SELECT * FROM tableApp WHERE id = :num", 
            [
                "num" => $id
            ]
        );
    }
}
