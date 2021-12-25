<?php
    namespace App\Controller;

    use App\Core\Session;
    use App\Core\AbstractController as AC;
    use App\Model\Manager\UserAppManager;

    class MainController extends AC
    {
        public function __construct(){
            $this->userManager = new UserAppManager();
        }

        public function index()
        {
            if(Session::get("user")){
                $user_id =  Session::get("user")->getId();
                $user = $this->userManager->getOneById($user_id);
                return $this->render("main/dashboard.php", [
                    "user" => $user,
                    "title" => "Dashboard"
                ]);
            }
            Session::addFlash('error', 'Access denied !');
            return $this->redirectToRoute("security");
        }

        public function addTable(){

            return $this->redirectToRoute("main");              
        }
    }