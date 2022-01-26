<?php
    namespace App\Core;

    abstract class Router 
    {
        private static $defaultCtrl = "main";

        public static function CSRFProtection($token){
            if(!empty($_POST)){
                if(isset($_POST['csrf_token'])){
                    $form_csrf = $_POST['csrf_token'];
                    if(hash_equals($form_csrf, $token)){
                        return true;
                    }
                }
                return false;
            }
            return true;
        }

        public static function handleRequest($params /* $_GET*/ ){

            $ctrlname = ucfirst(self::$defaultCtrl)."Controller"; //by default 
            
            $method = "index";

            if(isset($params['ctrl'])){
                $urlCtrl = $params['ctrl'];

                if(class_exists("App\\Controller\\".ucfirst($urlCtrl)."Controller")){
                    $ctrlname = ucfirst($urlCtrl)."Controller";
                }
            }
            
            $ctrlname = "App\\Controller\\".$ctrlname;
            $ctrl = new $ctrlname();

            if(isset($params['action']) && method_exists($ctrl, $params['action'])){
                $method = $params['action'];
            }

            if(isset($params['id'])){
                $id = $params['id'];
            }
            else $id = null;
            
            return $ctrl->$method($id);
        }

        /**
         *  allows to redirect to a new route
         */
        public static function redirect($arrayRoute){

            $route = "Location:";

            $route.= "?ctrl=".$arrayRoute['ctrl'];
            $route.= $arrayRoute['method'] ? "&action=".$arrayRoute['method'] : "";
            if(!empty($arrayRoute['param'])){
                foreach($arrayRoute['param'] as $param => $value){
                    $route.= "&".$param."=".$value;
                }
            }

            header($route);
            die;
        }
    }

    