<?php
    namespace App\Model\Entity;
    
    use App\Core\AbstractEntity as AE;
    use App\Core\EntityInterface;

    class Mark extends AE implements EntityInterface
    {
        private $card;
        private $userApp;

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
         * Get the value of userApp
         */ 
        public function getUserApp()
        {
                return $this->userApp;
        }

        /**
         * Set the value of userApp
         *
         * @return  self
         */ 
        public function setUserApp($userApp)
        {
                $this->userApp = $userApp;

                return $this;
        }
    }