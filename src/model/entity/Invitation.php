<?php
    namespace App\Model\Entity;
    
    use App\Core\AbstractEntity as AE;
    use App\Core\EntityInterface;

    class Invitation extends AE implements EntityInterface
    {
        private $tableApp;
        private $userApp;

        public function __construct($data){
                parent::hydrate($data, $this);
        }
        
        /**
         * Get the value of tableApp
         */ 
        public function getTableApp()
        {
                return $this->tableApp;
        }

        /**
         * Set the value of tableApp
         *
         * @return  self
         */ 
        public function setTableApp($tableApp)
        {
                $this->tableApp = $tableApp;

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