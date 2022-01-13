<?php
namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;
use PDOException;

class BoardManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }

    // get functions

    public function getAll(){
        return $this->getResults(
            "App\Model\Entity\Board",
            "SELECT * FROM boards"
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\Board",
            "SELECT * FROM boards WHERE id = :id", 
            [
                "id" => $id
            ]
        );
    }

    public function getBoardIdsByUser($id){
        return $this->getValues(
            "SELECT board_id FROM boards b, users u, user_board_participations p WHERE u.id = p.user_id AND b.id = p.board_id AND p.user_id = :id",
            [
                "id" => $id 
            ]
        );
    }

    public function getParticipantsByBoard($board_id){
        return $this->getResults(
            "App\Model\Entity\User",
            "SELECT * FROM users WHERE id IN (SELECT p.user_id FROM boards b, users u, user_board_participations p WHERE u.id = p.user_id AND b.id = p.board_id AND p.board_id = :board_id)", 
            [
                "board_id" => $board_id
            ]
        );
    }

    public function getInvitationsByUser($user_id){
        return $this->getResults(
            "App\Model\Entity\User_board_invitation",
            "SELECT * FROM user_board_invitations  WHERE user_id = :user_id", 
            [
                "user_id" => $user_id
            ]
        );
    }

    // insert functions

    public function insertBoard($title, $description, $user_id){
        $this->executeQuery( 
            "INSERT INTO boards (title, description, user_id) VALUES (:title, :description, :user_id)",
            [
                "title"  => $title,
                "description" => $description,
                "user_id" => $user_id
            ]
        );
        return $this->getLastInsertId();
    }

    public function insertParticipation($board_id, $user_id){
        return $this->executeQuery( 
            "INSERT INTO user_board_participations (board_id, user_id) VALUES (:board_id, :user_id)",
            [
                "board_id" => $board_id,
                "user_id" => $user_id
            ]
        );
    }

    public function insertInvitation($board_id, $user_id){
        return $this->executeQuery( 
            "INSERT INTO user_board_invitations (board_id, user_id) VALUES (:board_id, :user_id)",
            [
                "board_id" => $board_id,
                "user_id" => $user_id
            ]
        );
    }

    // delete functions

    public function deleteBoard($id){
        return $this->executeQuery( 
            "DELETE FROM boards WHERE id = :id",
            [
                "id" => $id 
            ]
        );
    }

    public function deleteInvitation($board_id, $user_id){
        return $this->executeQuery( 
            "DELETE FROM user_board_invitations WHERE board_id = :board_id AND user_id = :user_id",
            [
                "board_id" => $board_id,
                "user_id" => $user_id
            ]
        );
    }

    public function deleteParticipation($board_id, $user_id){
        return $this->executeQuery( 
            "DELETE FROM user_board_participations WHERE board_id = :board_id AND user_id = :user_id",
            [
                "board_id" => $board_id,
                "user_id" => $user_id
            ]
        );
    }

    // other functions

    public function isParticipant($board_id, $user_id){
        return $this->getOneValue( 
            "SELECT 1 FROM user_board_participations WHERE board_id = :board_id AND user_id = :user_id",
            [
                "board_id" => $board_id,
                "user_id" => $user_id
            ]
        );
    }

    public function isInvitation($board_id, $user_id){
        return $this->getOneValue( 
            "SELECT 1 FROM user_board_invitations WHERE board_id = :board_id AND user_id = :user_id",
            [
                "board_id" => $board_id,
                "user_id" => $user_id
            ]
        );
    }

    public function acceptInvitation($board_id, $user_id){     
        try{
            // Start of the transaction  
            self::$db->beginTransaction();

            // Insert participation
            $this->executeQuery( 
                "INSERT INTO user_board_participations (board_id, user_id) VALUES (:board_id, :user_id)",
                [
                    "board_id" => $board_id,
                    "user_id" => $user_id
                ]
            );

            // Delete invitation
            $this->executeQuery( 
                "DELETE FROM user_board_invitations WHERE board_id = :board_id AND user_id = :user_id",
                [
                    "board_id" => $board_id,
                    "user_id" => $user_id
                ]
                );
                
            // Record     
            self::$db->commit();                    
        } catch (\Exception $e){
            // Cancellation 
            self::$db->rollBack(); 
            return false;       
        }
        return true;

    }
}
