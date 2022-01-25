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

    public function getMarkUsersByCard($card_id){
        return $this->getResults(
            "App\Model\Entity\User",
            "SELECT * FROM users WHERE id IN (SELECT m.user_id FROM cards c, users u, user_card_marks m WHERE u.id = m.user_id AND c.id = m.card_id AND m.card_id = :card_id)", 
            [
                "card_id" => $card_id
            ]
        );
    }

    // insert functions

    public function insertCard($list_position, $content, $list_id){
        $this->executeQuery( 
            "INSERT INTO cards (list_position, content, taskList_id, color_id) VALUES (:list_position, :content, :list_id, 1)",
            [
                "list_position"  => $list_position,
                "content" => $content,
                "list_id" => $list_id,
            ]
        );
        return $this->getLastInsertId();
    }

    public function addMark($mark_user_id, $card_id){
        return $this->executeQuery( 
            "INSERT INTO user_card_marks (user_id, card_id) VALUES (:mark_user_id, :card_id)",
            [
                "mark_user_id" => $mark_user_id,
                "card_id" => $card_id
            ]
        );
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

    public function deleteMark($mark_user_id, $card_id){
        return $this->executeQuery( 
            "DELETE FROM user_card_marks WHERE user_id = :mark_user_id and card_id = :card_id",
            [
                "mark_user_id" => $mark_user_id,
                "card_id" => $card_id 
            ]
        );
    }

    // update functions

    public function editCardContent($content, $id){
        
        return $this->executeQuery( 
            "UPDATE cards SET content = :content WHERE id = :id",
            [
                "content" => $content,
                "id" => $id
            ]
        );
    }

    public function editCardDescription($description, $id){
        
        return $this->executeQuery( 
            "UPDATE cards SET description = :description WHERE id = :id",
            [
                "description" => $description,
                "id" => $id
            ]
        );
    }

    public function editCardColor($color_id, $id){
        
        return $this->executeQuery( 
            "UPDATE cards SET color_id = :color_id WHERE id = :id",
            [
                "color_id" => $color_id,
                "id" => $id
            ]
        );
    }

    public function changeCardPosition($list_id, $list_position, $card_id){
        
        return $this->executeQuery( 
            "UPDATE cards SET taskList_id = :list_id, list_position = :list_position WHERE id = :card_id",
            [
                "list_id" => $list_id,
                "list_position" => $list_position,
                "card_id" => $card_id
            ]
        );
    }
   

}
