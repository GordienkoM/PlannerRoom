<?php
    namespace App\Controller;

    use App\Core\Session;
    use App\Core\AbstractController as AC;
    use App\Model\Manager\TaskListManager;
    use App\Model\Manager\BoardManager;

    class ListsController extends AC
    {
        
        /**
         *  instantiate  managers classes
         */
        public function __construct(){
            $this->listManager = new TaskListManager();
            $this->boardManager = new BoardManager();
        }

        public function index(){
            return $this->redirectToRoute("main");
        }

        public function addList(){
            // check if user is logged in
            if(Session::get("user")){
                if(isset($_POST["submit"])){
                    
                    // validation or cleaning of data transmitted by the form
                    $title  = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
                    $board_id = filter_input(INPUT_POST, "board_id", FILTER_SANITIZE_NUMBER_INT);
                    
                    if($title && $board_id){                    
                        if( !$this->listManager->insertList($title, $board_id)){
                            Session::addFlash('error', "Une erreur est survenue");
                        }
                    }
                    else Session::addFlash('error', "La valeur du champ n'est pas correcte");
                }
                else Session::addFlash('error', "Une erreur est survenue");

                return $this->redirectToRoute("main", "showBoard", ['id' => $board_id]);  
            }
            return $this->redirectToRoute("security");                           
        }


        public function editList(){
            // check if user is logged in
            if(Session::get("user")){
                if(isset($_POST["submit"])){

                    // validation or cleaning of data transmitted by the form
                    $title  = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
                    $list_id = filter_input(INPUT_POST, "list_id", FILTER_SANITIZE_NUMBER_INT);
                    $board_id = filter_input(INPUT_POST, "board_id", FILTER_SANITIZE_NUMBER_INT);
                    
                    if($title && $list_id){                    
                        if( !$this->listManager->editList($title, $list_id)){
                            Session::addFlash('error', "Une erreur est survenue");
                        }
                        return $this->redirectToRoute("main", "showBoard", ['id' => $board_id]);
                    }
                    else Session::addFlash('error', "La valeur du champ n'est pas correcte");                    
                }
                else Session::addFlash('error', "Une erreur est survenue");  
            }
            return $this->redirectToRoute("security");                           
        }

        public function delList($id){
            // check if user is logged in
            if(Session::get("user")){

                $board_id = $this->listManager->getBoardIdByList($id);

                $user_id = Session::get("user")->getId();
                if($board_id){
                    //check that the logged in user is participant
                    if($this->boardManager->isParticipant($board_id, $user_id)){  
                        if(!$this->listManager->deleteList($id)){
                            Session::addFlash('error', "Une erreur est survenue");
                        }                     
                    }
                    else Session::addFlash('error', "Vous n'avez pas le droit de supprimer cette liste");

                    return $this->redirectToRoute("main", "showBoard", ['id' => $board_id]);
                }
                else Session::addFlash('error', "Une erreur est survenue");  
            }           
            return $this->redirectToRoute("security");
        }

    }