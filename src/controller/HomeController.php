<?php
    namespace App\Controller;

    use App\Core\Session;
    use App\Core\AbstractController as AC;

    class HomeController extends AC
    {
        public function __construct(){
        }

        public function index()
        {
            return $this->render("home/dashboard.php", [
                "title" => "Dashboard"
            ]);
        }
    }