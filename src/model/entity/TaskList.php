<?php
    namespace App\Model\Entity;
    
    use App\Core\AbstractEntity as AE;
    use App\Core\EntityInterface;

    class TaskList extends AE implements EntityInterface
    {
        private $id;
        private $title;
        private $board;
        private $cards;

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
         * Get the value of cards
         */ 
        public function getCards()
        {
                return $this->cards;
        }

        /**
         * Set the value of cards
         *
         * @return  self
         */ 
        public function setCards($cards)
        {
                $this->cards = $cards;

                return $this;
        }
    }