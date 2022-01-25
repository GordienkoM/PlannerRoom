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
         * permet au contrôleur de rediriger vers une nouvelle route (redirection HTTP 302)
         * 
         * @param string $ctrl - le contrôleur à appeler (si UserController, écrire "user")
         * @param string|null $method - la méthode du contrôleur à exécuter (si null, index() sera appelée)
         * @param string|null $param - le paramètre de requête id 
         * 
         * @return array tableau formaté contenant la vue et ses données
         */
        protected function redirectToRoute($ctrl, $method = null, array $param = []){
            Router::redirect([
                "ctrl"   => $ctrl,
                "method" => $method,
                "param"  => $param
            ]);
        }
    }