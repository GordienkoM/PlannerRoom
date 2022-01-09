<?php
namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;
use PDOException;

class ListManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }

    // get functions

    public function getAll(){
        return $this->getResults(
            "App\Model\Entity\List",
            "SELECT * FROM list"
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\List",
            "SELECT * FROM list WHERE id = :id", 
            [
                "id" => $id
            ]
        );
    }

    // insert functions

    public function insertList($title, $table_id){
        $this->executeQuery( 
            "INSERT INTO list (title, tableApp_id) VALUES (:title, :tableApp_id)",
            [
                "title"  => $title,
                "tableApp_id" => $table_id,
            ]
        );
        return $this->getLastInsertId();
    }
    
    // delete functions

    public function deleteList($id){
        return $this->executeQuery( 
            "DELETE FROM list WHERE id = :id",
            [
                "id" => $id 
            ]
        );
    }

}
