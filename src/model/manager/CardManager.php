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

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\Card",
            "SELECT * FROM cards WHERE id = :id", 
            [
                "id" => $id
            ]
        );
    }

    function getLastCardPosition($list_id){
        return $this->getOneValue(
            "SELECT MAX(list_position) FROM cards WHERE taskList_id = :list_id",
            [
                "list_id" => $list_id
            ]
        );
    }

    function getBoardIdByCard($id){
        return $this->getOneValue(
            "SELECT t.board_id FROM tasklists t, cards c WHERE c.taskList_id = t.id AND c.id  = :list_id",
            [
                "list_id" => $id
            ]
        );
    }

    // insert functions

    public function insertCard($list_position, $content, $list_id){
        $this->executeQuery( 
            "INSERT INTO cards (list_position, content, taskList_id) VALUES (:list_position, :content, :list_id)",
            [
                "list_position"  => $list_position,
                "content" => $content,
                "list_id" => $list_id,
            ]
        );
        return $this->getLastInsertId();
    }
    
    // delete functions

    public function deleteCard($id){
        return $this->executeQuery( 
            "DELETE FROM cards WHERE id = :id",
            [
                "id" => $id 
            ]
        );
    }

    // update functions

    public function editCard($content, $id){
        
        return $this->executeQuery( 
            "UPDATE cards SET content = :content WHERE id = :id",
            [
                "content" => $content,
                "id" => $id
            ]
        );
    }

    public function changeCardPosition ( $list_id, $card_id){
        
        return $this->executeQuery( 
            "UPDATE cards SET taskList_id = :list_id WHERE id = :card_id",
            [
                "list_id" => $list_id,
                "card_id" => $card_id
            ]
        );
    }
   

}
