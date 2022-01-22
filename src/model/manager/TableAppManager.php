<?php
namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;
use PDOException;

class TableAppManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }

    // get functions

    public function getAll(){
        return $this->getResults(
            "App\Model\Entity\TableApp",
            "SELECT * FROM tableApp"
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\TableApp",
            "SELECT * FROM tableApp WHERE id = :id", 
            [
                "id" => $id
            ]
        );
    }

    public function getTableIdsByUser($id){
        return $this->getValues(
            "SELECT tableApp_id FROM tableApp t, userApp u, participation p WHERE u.id = p.userApp_id AND t.id = p.tableApp_id AND p.userApp_id = :id",
            [
                "id" => $id 
            ]
        );
    }

    public function getParticipantsByTable($table_id){
        return $this->getResults(
            "App\Model\Entity\UserApp",
            "SELECT * FROM userApp WHERE id IN (SELECT p.userApp_id FROM tableApp t, userApp u, participation p WHERE u.id = p.userApp_id AND t.id = p.tableApp_id AND p.tableApp_id = :table_id)", 
            [
                "table_id" => $table_id
            ]
        );
    }

    public function getInvitationsByUser($user_id){
        return $this->getResults(
            "App\Model\Entity\Invitation",
            "SELECT * FROM invitation  WHERE userApp_id = :user_id", 
            [
                "user_id" => $user_id
            ]
        );
    }

    // insert functions

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
                "tableApp_id" => $table_id,
                "userApp_id" => $user_id
            ]
        );
    }

    public function insertInvitation($table_id, $user_id){
        return $this->executeQuery( 
            "INSERT INTO invitation (tableApp_id, userApp_id) VALUES (:tableApp_id, :userApp_id)",
            [
                "tableApp_id" => $table_id,
                "userApp_id" => $user_id
            ]
        );
    }

    // delete functions

    public function deleteTable($id){
        return $this->executeQuery( 
            "DELETE FROM tableApp WHERE id = :id",
            [
                "id" => $id 
            ]
        );
    }

    public function deleteInvitation($table_id, $user_id){
        return $this->executeQuery( 
            "DELETE FROM invitaton WHERE tableApp_id = :tableApp_id AND userApp_id = :userApp_id",
            [
                "tableApp_id" => $table_id,
                "userApp_id" => $user_id
            ]
        );
    }

    public function deleteParticipation($table_id, $user_id){
        return $this->executeQuery( 
            "DELETE FROM participation WHERE tableApp_id = :tableApp_id AND userApp_id = :userApp_id",
            [
                "tableApp_id" => $table_id,
                "userApp_id" => $user_id
            ]
        );
    }

    // other functions

    public function isInvitation($table_id, $user_id){
        return $this->getOneValue( 
            "SELECT 1 FROM invitation WHERE tableApp_id = :tableApp_id AND userApp_id = :userApp_id",
            [
                "tableApp_id" => $table_id,
                "userApp_id" => $user_id
            ]
        );
    }

    public function acceptInvitation($table_id, $user_id){     
        try{
            // Start of the transaction  
            self::$db->beginTransaction();

            // Insert participation
            $this->executeQuery( 
                "INSERT INTO participation (tableApp_id, userApp_id) VALUES (:tableApp_id, :userApp_id)",
                [
                    "tableApp_id" => $table_id,
                    "userApp_id" => $user_id
                ]
            );

            // Delete invitation
            $this->executeQuery( 
                "DELETE FROM invitation WHERE tableApp_id = :tableApp_id AND userApp_id = :userApp_id",
                [
                    "tableApp_id" => $table_id,
                    "userApp_id" => $user_id
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
