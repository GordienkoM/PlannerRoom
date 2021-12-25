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

    public function insertTable($title, $description, $user_id){
        $this->executeQuery( 
            "INSERT INTO tableApp (title, description, userApp_id) VALUES (:title, :description, :userApp_id)",
            [
                "title"  => $title,
                "description" => $description,
                "userApp_id" => $user_id
            ]
        );
        return $this->getLastInsertId();
    }

    public function insertParticipation($table_id, $user_id){
        return $this->executeQuery( 
            "INSERT INTO participation (tableApp_id, userApp_id) VALUES (:tableApp_id, :userApp_id)",
            [
                "tableApp_id"  => $table_id,
                "userApp_id" => $user_id
            ]
        );
    }
}
