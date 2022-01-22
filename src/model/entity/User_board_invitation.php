<?php
    namespace App\Model\Entity;
    
    use App\Core\AbstractEntity as AE;
    use App\Core\EntityInterface;

    class User_board_invitation extends AE implements EntityInterface
    {
        private $board;
        private $user;

        public function __construct($data){
                parent::hydrate($data, $this);
        }
        
        /**
         * Get the value of board
         */ 
        public function getBoard()
        {
                return $this->board;
        }

        /**
         * Set the value of board
         *
         * @return  self
         */ 
        public function setBoard($board)
        {
                $this->board = $board;

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
    }