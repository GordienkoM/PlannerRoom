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

        public function index(){
            // check if user is logged in
            if(Session::get("user")){
                $user_id =  Session::get("user")->getId();
                // array of invitations
                $invitations = $this->tableManager->getInvitationsByUser($user_id);
                // array of tables
                $tables = [];
                // get table ids where user is a participant
                $table_ids = $this->tableManager->getTableIdsByUser($user_id);
                if($table_ids){
                    // for each id
                    foreach($table_ids as $table_id){
                        $table_id = $table_id['tableApp_id'];
                        // get table as an object
                        $table = $this->tableManager->getOneById($table_id);
                        // get array of participants for a table                   
                        $participants = $this->tableManager->getParticipantsByTable($table_id);
                        // add array of participants in a table
                        $table->setParticipants($participants);
                        // add a table in array of tables
                        $tables[] = $table;
                    }
                }    
                return $this->render("main/dashboard.php", [
                    "invitations" => $invitations,
                    "tables" => $tables,
                    "title" => "Dashboard"
                ]);
            }
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

        public function delTable($id){
            
            if(Session::get("user")){

                $table = $this->tableManager->getOneById($id); 
                if($table){
                    //check that the logged in user is the table admin
                    if(Session::get("user")->getId() == $table->getUserApp()->getId()){  
                        if($this->tableManager->deleteTable($id)){
                            Session::addFlash('success', "Le tableau est suprimé");
                        }
                        else{
                            Session::addFlash('error', "Une erreur est survenue");
                        }                       
                    }
                }return $this->redirectToRoute("main");    
            }           
            return $this->redirectToRoute("security");
        }

        public function showTable($id){

            if(Session::get("user")){
                // get table as an object
                $table = $this->tableManager->getOneById($id);
                // get array of participants for a table                   
                $participants = $this->tableManager->getParticipantsByTable($id);
                
                //check if the logged in user is one of the table participants
                $isParticipant = false;
                foreach($participants as $participant){
                    if ($participant->getId() ==  Session::get("user")->getId()){
                        $isParticipant = true;
                    } 
                }

                if ($isParticipant){
                    // add array of participants in a table
                    $table->setParticipants($participants);    
                    return $this->render("main/table.php", [
                        "table" => $table,
                        "title" => $table
                    ]);
                }else{
                    Session::addFlash('error', 'Accès refusé !');
                    redirectToRoute("security", "logout");
                }   
            }          
            return $this->redirectToRoute("security");
        }

        public function createInvitation(){

            if(isset($_POST["submit"])){
                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $table_id = filter_input(INPUT_POST, "table_id", FILTER_SANITIZE_STRING);
                if($email && $table_id){
                    // get the user if the entered email corresponds the database
                    $user = $this->userManager->getUserByEmail($email);
                    $table = $this->tableManager->getOneById($table_id);
                    if($user){
                        $user_id = $user->getId();
                        //check that the logged in user is the table admin
                        if(Session::get("user")->getId() == $table->getUserApp()->getId()){
                            if(!$this->tableManager->isInvitation($table_id, $user_id)){
                                if($this->tableManager->insertInvitation($table_id, $user_id)){
                                    Session::addFlash('success', "L'utilisateur est invité");
                                }
                                else{
                                    Session::addFlash('error', "Une erreur est survenue");
                                }
                            }
                            else Session::addFlash('error', "L'utilisateur était déjà invité et il n'est pas encore repondu");     
                        }
                        else Session::addFlash('error', "Le mot de passe est erroné");
                    }
                    else Session::addFlash('error', "Il n'y a pas d'utilisateur avec cet email");
                }
                else Session::addFlash('error', "Le champ doit être remplis correctement");

                $params = ['id' => $table_id];
                return $this->redirectToRoute("main", "showTable", $params);
            }
            return $this->redirectToRoute("security");
        }

        public function delInvitation($id){ 
                       
            if(Session::get("user")){
                $user_id = Session::get("user")->getId();
                if($this->tableManager->deleteInvitation($id, $user_id)){
                    Session::addFlash('success', "L'invitation est suprimé");
                }
                else{
                    Session::addFlash('error', "Une erreur est survenue");
                }
                return $this->redirectToRoute("main");    
            }           
            return $this->redirectToRoute("security");
        }
    }