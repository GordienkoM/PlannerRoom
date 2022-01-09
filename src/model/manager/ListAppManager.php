<?php
namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;


class ListAppManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }

    // get functions

    public function getAll(){
        return $this->getResults(
            "App\Model\Entity\ListApp",
            "SELECT * FROM listApp"
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\ListApp",
            "SELECT * FROM listApp WHERE id = :id", 
            [
                "id" => $id
            ]
        );
    }

    public function getListsByTable($table_id){
        return $this->getResults(
            "App\Model\Entity\ListApp",
            "SELECT * FROM listApp WHERE tableApp_id = :tableApp_id", 
            [
                "tableApp_id" => $table_id
            ]
        );
    }

    // insert functions

    public function insertList($title, $table_id){
        $this->executeQuery( 
            "INSERT INTO listApp (title, tableApp_id) VALUES (:title, :tableApp_id)",
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
            "DELETE FROM listApp WHERE id = :id",
            [
                "id" => $id 
            ]
        );
    }

}
