<?php
namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;

class UserManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }


    public function getAllUsers(){
        return $this->getResults(
            "App\Model\Entity\User",
            "SELECT * FROM users"
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\User",
            "SELECT * FROM users WHERE id = :id", 
            [
                "id" => $id
            ]
        );
    }

    public function insertUser($nickname, $mail, $pass){
        return $this->executeQuery(
            "INSERT INTO users (nickname, email, password, role) VALUES (:nickname, :mail, :pass, 'ROLE_USER')",
            [
                "nickname" => $nickname,
                "mail" => $mail,
                "pass" => $pass
            ]
        );
    }

    function getUserByEmail($mail){
        return $this->getOneOrNullResult(
            "App\Model\Entity\User",
            "SELECT * FROM users WHERE email = :mail",
            [
                "mail" => $mail
            ]
        );
    }

    function getPasswordByEmail($mail){
        return $this->getOneValue(
            "SELECT password FROM users WHERE email = :mail",
            [
                "mail" => $mail
            ]
        );
    }

    function getPasswordById($id){
        return $this->getOneValue(
            "SELECT password FROM users WHERE id = :id",
            [
                "id" => $id
            ]
        );
    }


    public function deleteUser($id){
        return $this->executeQuery( 
            "DELETE FROM users WHERE id = :id",
            [
                "id" => $id 
            ]
        );
    }

    public function updatePassword($id, $new_password){
        
        return $this->executeQuery( 
            "UPDATE users SET password = :password WHERE id = :id",
            [
                "password" => $new_password,
                "id" => $id
            ]
        );
    }

    public function updateNickname($id, $nickname){
        
        return $this->executeQuery( 
            "UPDATE users SET nickname = :nickname WHERE id = :id",
            [
                "nickname" => $nickname,
                "id" => $id
            ]
        );
    }

    public function updateEmail($id, $email){
        
        return $this->executeQuery( 
            "UPDATE users SET email = :email WHERE id = :id",
            [
                "email" => $email,
                "id" => $id
            ]
        );
    }

}
