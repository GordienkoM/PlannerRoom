<?php
    namespace App\Controller;

    use App\Core\Session;
    use App\Core\AbstractController as AC;
    use App\Model\Manager\UserAppManager;
    use App\Model\Manager\TableAppManager;

    class MainController extends AC
    {
        public function __construct(){
            $this->userManager = new UserAppManager();
            $this->tableManager = new TableAppManager();
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

            if(Session::get("user")){
                if(isset($_POST["submit"])){
                    
                    $user_id =  Session::get("user")->getId();
                    $title  = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
                    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
                    
                    if($title && $description){
                        $table_id = $this->tableManager->insertTable($title, $description, $user_id);                    
                        if($table_id && $this->tableManager->insertParticipation($table_id, $user_id)){
                            Session::addFlash('success', "Le tableau est ajouté");
                        }
                        else{
                            Session::addFlash('error', "Une erreur est survenue");
                        }
                    }
                    else Session::addFlash('error', "Tous les champs doivent être remplis et respecter leur format");
                }
                else Session::addFlash('error', "Une erreur est survenue");

                return $this->redirectToRoute("main");  
            }
            return $this->redirectToRoute("security");                           
        }
    }