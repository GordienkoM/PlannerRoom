<?php
    namespace App\Model\Entity;
    
    use App\Core\AbstractEntity as AE;
    use App\Core\EntityInterface;

    class User_card_mark extends AE implements EntityInterface
    {
        private $card;
        private $user;

        public function __construct($data){
                parent::hydrate($data, $this);
        }

        /**
         * Get the value of card
         */ 
        public function getCard()
        {
                return $this->card;
        }

        /**
         * Set the value of card
         *
         * @return  self
         */ 
        public function setCard($card)
        {
                $this->card = $card;

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