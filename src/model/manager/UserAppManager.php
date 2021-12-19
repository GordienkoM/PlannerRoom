<?php
namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;

class UserAppManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }

    public function getAll(){
        return;
    }

    public function getOneById($id){
        return;
    }

    public function insertUser($nickname, $mail, $pass){
        return $this->executeQuery(
            "INSERT INTO userApp (nickname, email, password, role) VALUES (:nickname, :mail, :pass, 'ROLE_USER')",
            [
                "nickname" => $nickname,
                "mail" => $mail,
                "pass" => $pass
            ]
        );
    }

    function getUserByEmail($mail){
        return $this->getOneOrNullResult(
            "App\Model\Entity\UserApp",
            "SELECT * FROM userApp WHERE email = :mail",
            [
                "mail" => $mail
            ]
        );
    }

    function getPasswordByEmail($mail){
        return $this->getOneValue(
            "SELECT password FROM userApp WHERE email = :mail",
            [
                "mail" => $mail
            ]
        );
    }

}
