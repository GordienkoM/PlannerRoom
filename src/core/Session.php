<?php
    namespace App\Core;

    abstract class Session
    {
        /**
          * retrieves all flash messages in session corresponding to the type passed in parameter

          * @param string $type - the type of messages to retrieve  
         */
        public static function getFlashes($type){
            $messages = [];
            if(isset($_SESSION['messages'][$type])){
                $messages = $_SESSION['messages'][$type];
                unset($_SESSION['messages'][$type]);
            }
            return $messages;
        }

        /**
          * adds a flash message to the session
          *
          * @param string $type - the message type (ex: error, alert, success, notice...)
          * @param string $message - the message
        */
        public static function addFlash($type, $message){
            if(!isset($_SESSION["messages"])){
                $_SESSION["messages"] = [];
            }
            if(!isset($_SESSION["messages"][$type])){
                $_SESSION["messages"][$type] = [];
            }
            $_SESSION["messages"][$type][] = $message;
        }

        /**
          * retrieves the contents of the desired session entry
          *
          * @param string $key - the key of the session entry
          *
          * @return mixed|null the value of the requested input
        */
        public static function get($key){
            if(isset($_SESSION[$key])){
                return $_SESSION[$key];
            }
            return null;
        }
 
        /**
          * create a session entry corresponding to the given key and value
          *
          * @param string $key - the key to create in session
          * @param mixed $value - the value to associate with it
          * @return void
         */
        public static function set($key, $value){
            $_SESSION[$key] = $value;
        }

        public static function remove($key){
            unset($_SESSION[$key]);
        }
        
        /* CSRF PROTECTION */
        public static function generateKey(){
            if(!isset($_SESSION['key']) || $_SESSION['key'] === null){
                $_SESSION['key'] = bin2hex(random_bytes(32));
            }
            return $_SESSION['key'];
        }

        public static function eraseKey(){
            unset($_SESSION['key']);
            
        }
    }