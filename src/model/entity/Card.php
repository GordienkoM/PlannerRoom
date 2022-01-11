<?php
    namespace App\Model\Entity;
    
    use App\Core\AbstractEntity as AE;
    use App\Core\EntityInterface;

    class Card extends AE implements EntityInterface
    {
        private $id;
        private $list_position;
        private $content;
        private $label;
        private $taskList;
        private $color;

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
         * Get the value of list_position
         */ 
        public function getList_position()
        {
                return $this->list_position;
        }

        /**
         * Set the value of list_position
         *
         * @return  self
         */ 
        public function setList_position($list_position)
        {
                $this->list_position = $list_position;

                return $this;
        }

        /**
         * Get the value of content
         */ 
        public function getContent()
        {
                return $this->content;
        }

        /**
         * Set the value of content
         *
         * @return  self
         */ 
        public function setContent($content)
        {
                $this->content = $content;

                return $this;
        }

        /**
         * Get the value of label
         */ 
        public function getLabel()
        {
                return $this->label;
        }

        /**
         * Set the value of label
         *
         * @return  self
         */ 
        public function setLabel($label)
        {
                $this->label = $label;

                return $this;
        }

        /**
         * Get the value of taskList
         */ 
        public function getTaskList()
        {
                return $this->taskList;
        }

        /**
         * Set the value of TaskList
         *
         * @return  self
         */ 
        public function setTaskList($taskList)
        {
                $this->taskList = $taskList;

                return $this;
        }

        /**
         * Get the value of color
         */ 
        public function getColor()
        {
                return $this->color;
        }

        /**
         * Set the value of color
         *
         * @return  self
         */ 
        public function setColor($color)
        {
                $this->color = $color;

                return $this;
        }
    }