<?php
    namespace App\Model\Entity;
    
    use App\Core\AbstractEntity as AE;
    use App\Core\EntityInterface;

    class Board extends AE implements EntityInterface
    {
        private $id;
        private $title;
        private $description;
        private $user;
        private $participants;

        public function __construct($data){
            parent::hydrate($data, $this);
        }

        public function __toString()
        {
            return $this->title;
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
         * Get the value of title
         */ 
        public function getTitle()
        {
                return $this->title;
        }

        /**
         * Set the value of title
         *
         * @return  self
         */ 
        public function setTitle($title)
        {
                $this->title = $title;

                return $this;
        }

        /**
         * Get the value of description
         */ 
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @return  self
         */ 
        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }

        /**
         * Get the value of user
         */ 
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }


        /**
         * Get the value of participants
         */ 
        public function getParticipants()
        {
                return $this->participants;
        }

        /**
         * Set the value of participants
         *
         * @return  self
         */ 
        public function setParticipants($participants)
        {
                $this->participants = $participants;

                return $this;
        }
    }