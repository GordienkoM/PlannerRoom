<?php
    namespace App\Controller;

    use App\Core\Session;
    use App\Core\AbstractController as AC;
    use App\Model\Manager\CardManager;
    use App\Model\Manager\TaskListManager;
    use App\Model\Manager\BoardManager;

    class CardsController extends AC
    {
        public function __construct(){
            $this->cardManager = new CardManager();
            $this->listManager = new TaskListManager();
            $this->boardManager = new BoardManager();
        }

        public function index(){
            return $this->redirectToRoute("main");
        }

        public function addCard(){

            if(Session::get("user")){
                if(isset($_POST["submit"])){
                    
                    $content  = filter_input(INPUT_POST, "content", FILTER_SANITIZE_STRING);
                    $list_id = filter_input(INPUT_POST, "list_id", FILTER_SANITIZE_STRING);

                    $board_id = $this->listManager->getBoardIdByList($list_id);
                    $user_id = Session::get("user")->getId();
                    //check that the logged in user is the participant
                    if($this->boardManager->isParticipant($board_id, $user_id)){
                        if($content && $list_id){
                            $last_card_position = $this->cardManager->getLastCardPosition($list_id);
                            //var_dump($last_card_position);

                            $list_position = $last_card_position ? $last_card_position + 10000 : 10000; 
                                    
                            if($this->cardManager->insertCard($list_position, $content, $list_id)){
                                Session::addFlash('success', "La carte est ajoutée");
                            }
                            else{
                                Session::addFlash('error', "Une erreur est survenue");
                            }
                                                      
                             
                        }
                        else Session::addFlash('error', "La valeur de champ n'est pas correct");
                    }
                    else Session::addFlash('error', "Vous n'êtes pas participant de ce tableau");
                }
                else Session::addFlash('error', "Une erreur est survenue");
                return $this->redirectToRoute("main", "showBoard", ['id' => $board_id]);  
            }
            return $this->redirectToRoute("security");                           
        }

        public function editCard(){

            if(Session::get("user")){
                if(isset($_POST["submit"])){
                    
                    $content  = filter_input(INPUT_POST, "content", FILTER_SANITIZE_STRING);
                    $card_id = filter_input(INPUT_POST, "card_id", FILTER_SANITIZE_STRING);
                    
                    if($content && $card_id){                    
                        $board_id = $this->cardManager->getBoardIdByCard($card_id);
                        if( !$this->cardManager->editCard($content, $card_id)){
                            Session::addFlash('error', "Une erreur est survenue");
                        }
                        return $this->redirectToRoute("main", "showBoard", ['id' => $board_id]);
                    }
                    else Session::addFlash('error', "La valeur de champ n'est pas correct");
                    
                }
                else Session::addFlash('error', "Une erreur est survenue");  
            }
            return $this->redirectToRoute("security");                           
        }



        public function delCard($id){
            
            if(Session::get("user")){

                $board_id = $this->cardManager->getBoardIdByCard($id);
                $user_id = Session::get("user")->getId();
                if($board_id){
                    //check that the logged in user is participant
                    if($this->boardManager->isParticipant($board_id, $user_id)){  
                        if($this->cardManager->deleteCard($id)){
                            Session::addFlash('success', "La carte est suprimée");
                        }
                        else{
                            Session::addFlash('error', "Une erreur est survenue");
                        }                       
                    }
                    else Session::addFlash('error', "Vous n'avez pas de droit de supprimer cette carte");

                    return $this->redirectToRoute("main", "showBoard", ['id' => $board_id]);
                }
                else Session::addFlash('error', "Une erreur est survenue");  
            }           
            return $this->redirectToRoute("security");
        }

        

        public function changeCardPosition(){
            
           
            $list_id = 2;
            $card_id = 1;
            
            if( $this->cardManager->changeCardPosition($list_id, $card_id)){
                echo "bien marché";
            }else echo "une erreur";

            die();
        }


    }