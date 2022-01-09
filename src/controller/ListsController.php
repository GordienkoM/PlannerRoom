<?php
    namespace App\Controller;

    use App\Core\Session;
    use App\Core\AbstractController as AC;
    use App\Model\Manager\ListManager;
    use App\Model\Manager\TableAppManager;

    class ListsController extends AC
    {
        public function __construct(){
            $this->listManager = new ListManager();
            $this->tableManager = new TableAppManager();
        }

        public function index(){
            return $this->redirectToRoute("main");
        }

        public function addList(){

            if(Session::get("user")){
                if(isset($_POST["submit"])){
                    
                    $title  = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
                    $table_id = filter_input(INPUT_POST, "table_id", FILTER_SANITIZE_STRING);
                    
                    if($title && $table_id){                    
                        if( $table_id = $this->listManager->insertList($title, $table_id)){
                            Session::addFlash('success', "La liste est ajoutée");
                        }
                        else{
                            Session::addFlash('error', "Une erreur est survenue");
                        }
                    }
                    else Session::addFlash('error', "La valeur de champ n'est pas correct");
                }
                else Session::addFlash('error', "Une erreur est survenue");
                return $this->redirectToRoute("main", "showTable", ['id' => $table_id]);  
            }
            return $this->redirectToRoute("security");                           
        }

        // public function delList($id){
            
        //     if(Session::get("user")){

        //         $table_id = $this->listManager->getTableIdByList($id);
        //         $user_id = Session::get("user")->getId();
        //         if($table_id){
        //             //check that the logged in user is participant
        //             if($this->listManager->isParticipant($table_id, $user_id) ){  
        //                 if($this->listManager->deleteList($id)){
        //                     Session::addFlash('success', "La liste est suprimée");
        //                 }
        //                 else{
        //                     Session::addFlash('error', "Une erreur est survenue");
        //                 }                       
        //             }
        //             else Session::addFlash('error', "Vous n'avez pas de droit de supprimer cette liste");
        //         }
        //         return $this->redirectToRoute("main", "showTable", ['id' => $table_id]);  
        //     }           
        //     return $this->redirectToRoute("security");
        // }

    }