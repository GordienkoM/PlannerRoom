<?php
    namespace App\Model\Entity;
    
    use App\Core\AbstractEntity as AE;
    use App\Core\EntityInterface;

    class Color extends AE implements EntityInterface
    {
        private $id;
        private $color_code;

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
         * Get the value of color_code
         */ 
        public function getColor_code()
        {
                return $this->color_code;
        }

        /**
         * Set the value of color_code
         *
         * @return  self
         */ 
        public function setColor_code($color_code)
        {
                $this->color_code = $color_code;

                return $this;
        }
    }