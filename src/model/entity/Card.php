<?php
    namespace App\Model\Entity;
    
    use App\Core\AbstractEntity as AE;
    use App\Core\EntityInterface;

    class Card extends AE implements EntityInterface
    {
        private $id;
        private $list_position;
        private $content;
        private $description;
        private $taskList;
        private $color;
        private $marks;

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

        /**
         * Get the value of marks
         */ 
        public function getMarks()
        {
                return $this->marks;
        }

        /**
         * Set the value of marks
         *
         * @return  self
         */ 
        public function setMarks($marks)
        {
                $this->marks = $marks;

                return $this;
        }
    }