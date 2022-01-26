<?php
    namespace App\Core;
    
    abstract class AbstractController
    {

        /**
          * allows the controller to return a view and its data
          *
          * @param string $view - the path of the view to display
          * @param array $data - the array containing the data needed by the view
          *
          * @return array formatted array containing the view and its data
         */
        protected function render($view, $data = []){
            
            return [
                "view"  => "view/".$view,
                "data"  => $data
            ];
        }

        /**
          * allows the controller to redirect to a new route
          *
          * @param string $ctrl - the controller to call (if UserController, write "user")
          * @param string|null $method - the controller method to execute (if null, index() will be called)
          * @param string|null $param - the query parameter id
          *
          * @return array formatted array containing the view and its data
         */
        protected function redirectToRoute($ctrl, $method = null, array $param = []){
            Router::redirect([
                "ctrl"   => $ctrl,
                "method" => $method,
                "param"  => $param
            ]);
        }
    }