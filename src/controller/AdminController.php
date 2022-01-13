<?php
    namespace App\Controller;

    use App\Core\Session;
    use App\Core\AbstractController as AC;
    use App\Model\Manager\UserManager;

    class AdminController extends AC
    {
        public function __construct(){
            $this->userManager = new UserManager();
        }

        public function index(){
            // check if user is logged in
            if (Session::get("user")){
                // check if logged in user is the application admin
                if (Session::get("user")->hasRole("ROLE_ADMIN")){
                    //get all users
                    $users = $this->userManager->getAllUsers();               
                    
                    return $this->render("admin/admin.php", [
                        "users" => $users,
                        "title" => "Administration"
                    ]);
                }    
            }
            return $this->redirectToRoute("security");
        }

        public function delUser($id){
     
            if(Session::get("user")){ 
                if( Session::get("user")->hasRole("ROLE_ADMIN")){ 
                    if($this->userManager->deleteUser($id)){
                        Session::addFlash('success', "L'utilisateur est suprimé");
                    }
                    else{
                        Session::addFlash('error', "Une erreur est survenue");
                    } 
                    return $this->index();
                }else return $this->redirectToRoute("main");
            }
            return $this->redirectToRoute("security");
        }

    }