<?php
    namespace App\Controller;

    use App\Core\Session;
    use App\Core\AbstractController as AC;
    use App\Model\Manager\UserManager;
    use App\Model\Manager\BoardManager;
    use App\Model\Manager\TaskListManager;
    use App\Model\Manager\ColorManager;

    class MainController extends AC
    {
        public function __construct(){
            $this->userManager = new UserManager();
            $this->boardManager = new BoardManager();
            $this->listManager = new TaskListManager();
            $this->colorManager = new ColorManager();
        }

        //display page "Dashboard" 
        
        public function index(){
            // check if user is logged in
            if(Session::get("user")){
                $user_id =  Session::get("user")->getId();
                // array of invitations
                $invitations = $this->boardManager->getInvitationsByUser($user_id);
                // array of boards
                $boards = [];
                // get board ids where user is a participant
                $board_ids = $this->boardManager->getBoardIdsByUser($user_id);
                if($board_ids){
                    // for each id
                    foreach($board_ids as $board_id){
                        $board_id = $board_id['board_id'];
                        // get board as an object
                        $board = $this->boardManager->getOneById($board_id);
                        // get array of participants for a board                   
                        $participants = $this->boardManager->getParticipantsByBoard($board_id);
                        // add array of participants in a board
                        $board->setParticipants($participants);
                        // add a board in array of boards
                        $boards[] = $board;
                    }
                } 

                return $this->render("main/dashboard.php", [
                    "invitations" => $invitations,
                    "boards" => $boards,
                    "title" => "Dashboard",

                ]);
            }
            return $this->redirectToRoute("security");
        }

        public function addBoard(){

            if(Session::get("user")){
                if(isset($_POST["submit"])){
                    
                    $user_id =  Session::get("user")->getId();
                    $title  = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
                    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
                    
                    if($title && $description){

                        $board_id = $this->boardManager->insertBoard($title, $description, $user_id);                    
                        if($board_id && $this->boardManager->insertParticipation($board_id, $user_id)){
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

        public function delBoard($id){
            
            if(Session::get("user")){

                $board = $this->boardManager->getOneById($id); 
                if($board){
                    //check that the logged in user is the board admin
                    if(Session::get("user")->getId() == $board->getUser()->getId()){  
                        if($this->boardManager->deleteBoard($id)){
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

        public function showBoard($id){

            if(Session::get("user")){
                // get board as an object
                $board = $this->boardManager->getOneById($id);
                // get array of participants for a board                   
                $participants = $this->boardManager->getParticipantsByBoard($id);
                
                //check if the logged in user is one of the board participants
                $isParticipant = false;
                foreach($participants as $participant){
                    if ($participant->getId() ==  Session::get("user")->getId()){
                        $isParticipant = true;
                    } 
                }

                if ($isParticipant){
                    // add array of participants in a board
                    $board->setParticipants($participants);
                    $lists = []; 
                    if($this->listManager->getListsByBoard($id)){
                        // for each list
                        foreach($this->listManager->getListsByBoard($id) as $list){
                            $list_id = $list->getId();
                            // get array of cards for a list                   
                            $cards = $this->listManager->getCardsByList($list_id);
                            // add array of cards in a list
                            $list->setCards($cards);
                            // add a list in array of lists
                            $lists[] = $list;
                        }
                    }   

                    $colors = $this->colorManager->getAllColors();

                    return $this->render("main/board.php", [
                        "board" => $board,
                        "lists" => $lists,
                        "title" => $board,
                        "colors" => $colors,
                    ]);
                }else{
                    Session::addFlash('error', 'Accès refusé !');
                    $this->redirectToRoute("security", "logout");
                }   
            }          
            return $this->redirectToRoute("security");
        }

        public function createInvitation(){

            if(isset($_POST["submit"])){
                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $board_id = filter_input(INPUT_POST, "board_id", FILTER_SANITIZE_NUMBER_INT);
                if($email && $board_id){
                    // get the user if the entered email corresponds the database
                    $user = $this->userManager->getUserByEmail($email);
                    $board = $this->boardManager->getOneById($board_id);
                    if($user){
                        $user_id = $user->getId();
                        //check that the logged in user is the board admin
                        if(Session::get("user")->getId() == $board->getUser()->getId()){
                            if(!$this->boardManager->isInvitation($board_id, $user_id)){
                                if($this->boardManager->insertInvitation($board_id, $user_id)){
                                    Session::addFlash('success', "L'utilisateur est invité");
                                }
                                else{
                                    Session::addFlash('error', "Une erreur est survenue");
                                }
                            }
                            else Session::addFlash('error', "L'utilisateur était déjà invité et il n'est pas encore repondu");     
                        }
                        else Session::addFlash('error', "Vous n'avez pas de droit d'inviter dans ce tableau");
                    }
                    else Session::addFlash('error', "Il n'y a pas d'utilisateur avec cet email");
                }
                else Session::addFlash('error', "Le champ doit être remplis correctement");

                $params = ['id' => $board_id];
                return $this->redirectToRoute("main", "showBoard", $params);
            }
            return $this->redirectToRoute("security");
        }

        public function acceptInvitation($id){ 
                       
            if(Session::get("user")){
                $user_id = Session::get("user")->getId();
                if($this->boardManager->acceptInvitation($id, $user_id)){
                    Session::addFlash('success', "Vous avez accepté l'invitation et vous participez dans un nouveau tableau");
                }
                else{
                    Session::addFlash('error', "Une erreur est survenue");
                }
                return $this->redirectToRoute("main");    
            }           
            return $this->redirectToRoute("security");
        }

        public function delInvitation($id){ 

            if(Session::get("user")){
                $user_id = Session::get("user")->getId();
                if($this->boardManager->deleteInvitation($id, $user_id)){
                    Session::addFlash('success', "L'invitation est suprimé");
                }
                else{
                    Session::addFlash('error', "Une erreur est survenue");
                }
                return $this->redirectToRoute("main");    
            }           
            return $this->redirectToRoute("security");
        }

        public function leaveBoard($id){ 

            if(Session::get("user")){
                $user_id = Session::get("user")->getId();
                if($this->boardManager->deleteParticipation($id, $user_id)){
                    Session::addFlash('success', "Vous avez quitté le tableau");
                }
                else{
                    Session::addFlash('error', "Une erreur est survenue");
                }
                return $this->redirectToRoute("main");    
            }           
            return $this->redirectToRoute("security");
        }

        public function delParticipant(){ 

            if(Session::get("user")){
                if(isset($_POST["submit"])){
                    var_dump("salut");
                    $user_id = filter_input(INPUT_POST, "user_id", FILTER_VALIDATE_INT);
                    $board_id = filter_input(INPUT_POST, "board_id", FILTER_VALIDATE_INT);

                    if($user_id && $board_id){
                        $board = $this->boardManager->getOneById($board_id); 
                        if($board){
                            //check that the logged in user is the board admin
                            if(Session::get("user")->getId() == $board->getUser()->getId()){
                                if($this->boardManager->deleteParticipation($board_id, $user_id)){
                                    Session::addFlash('success', "Vous avez supprimer le participant");
                                }
                                else{
                                    Session::addFlash('error', "Une erreur est survenue");
                                }   
                            }
                            else Session::addFlash('error', "Vous n'avez pas de droit de supprimer l'utilisateur");
                        }
                        else Session::addFlash('error', "Une erreur est survenue");
                    }
                    else Session::addFlash('error', "Une erreur est survenue");
    
                    $params = ['id' => $board_id];
                    return $this->redirectToRoute("main", "showBoard", $params);
                }
            }return $this->redirectToRoute("security");    
        }
    }