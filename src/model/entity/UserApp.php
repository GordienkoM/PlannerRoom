<?php
    namespace App\Model\Entity;
    
    use App\Core\AbstractEntity as AE;
    use App\Core\EntityInterface;

    class UserApp extends AE implements EntityInterface
    {
        private $id;
        private $nickname;
        private $email;
        private $code_change;
        private $role;

        public function __construct($data){
            parent::hydrate($data, $this);
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
            return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
            $this->id = $id;

            return $this;
        }

        /**
         * Get the value of nickname
         */ 
        public function getNickname()
        {
                return $this->nickname;
        }

        /**
         * Set the value of nickname
         *
         * @return  self
         */ 
        public function setNickname($nickname)
        {
                $this->nickname = $nickname;

                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
            $this->email = $email;

            return $this;
        }

        /**
         * Get the value of code_change
         */ 
        public function getCode_change()
        {
                return $this->code_change;
        }

        /**
         * Set the value of code_change
         *
         * @return  self
         */ 
        public function setCode_change($code_change)
        {
                $this->code_change = $code_change;

                return $this;
        }

        /**
         * Get the value of role
         */ 
        public function getRole()
        {
            return $this->role;
        }

        /**
         * Set the value of role
         *
         * @return  self
         */ 
        public function setRole($role)
        {
            $this->role = $role;

            return $this;
        }

        public function hasRole($role){
            return $this->role == $role ? true : false;
        }
        
    }