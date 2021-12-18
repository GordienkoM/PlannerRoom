<?php
    namespace App\Controller;

    use App\Core\Session;
    use App\Core\AbstractController as AC;

    class MainController extends AC
    {
        public function __construct(){
        }

        public function index()
        {
            return $this->render("main/dashboard.php", [
                "title" => "Dashboard"
            ]);
        }
    }