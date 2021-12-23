<?php
    namespace App\Model\Entity;
    
    use App\Core\AbstractEntity as AE;
    use App\Core\EntityInterface;

    class List extends AE implements EntityInterface
    {
        private $id;
        private $title;
        private $tableApp;

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

    }