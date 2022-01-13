<?php
namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;


class TaskListManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }

    // get functions

    public function getAll(){
        return $this->getResults(
            "App\Model\Entity\TaskList",
            "SELECT * FROM taskLists"
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\TaskList",
            "SELECT * FROM taskLists WHERE id = :id", 
            [
                "id" => $id
            ]
        );
    }

    public function getListsByBoard($board_id){
        return $this->getResults(
            "App\Model\Entity\TaskList",
            "SELECT * FROM taskLists WHERE board_id = :board_id", 
            [
                "board_id" => $board_id
            ]
        );
    }

    public function getCardsByList($list_id){
        return $this->getResults(
            "App\Model\Entity\Card",
            "SELECT * FROM cards WHERE taskList_id = :taskList_id", 
            [
                "taskList_id" => $list_id
            ]
        );
    }

    function getBoardIdByList($list_id){
        return $this->getOneValue(
            "SELECT board_id FROM taskLists WHERE id = :list_id",
            [
                "list_id" => $list_id
            ]
        );
    }

    // insert functions

    public function insertList($title, $board_id){
        $this->executeQuery( 
            "INSERT INTO taskLists (title, board_id) VALUES (:title, :board_id)",
            [
                "title"  => $title,
                "board_id" => $board_id,
            ]
        );
        return $this->getLastInsertId();
    }
    
    // delete functions

    public function deleteList($id){
        return $this->executeQuery( 
            "DELETE FROM taskLists WHERE id = :id",
            [
                "id" => $id 
            ]
        );
    }

}
