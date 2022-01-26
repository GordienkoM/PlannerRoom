<?php
    namespace App\Controller;
    
    use App\Core\AbstractController as AC;
    use App\Core\Session;
    use App\Model\Manager\UserManager;

    class SecurityController extends AC
    {
        public function __construct(){
        /**
         *  instantiate UserManager
         */
            $this->manager = new UserManager();
        }

        /**
         * display the login form or compute the login action with post data
         * 
         * @return array array with view login.php
         */ 
        public function index(){
            if(isset($_POST["submit"])){

                // validation of data transmitted by the form
                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $password = filter_input(INPUT_POST, "password", FILTER_VALIDATE_REGEXP, [
                    "options" => [
                        // at least 8 characters, SHIFT, min and number obligatory
                        "regexp" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/"
                    ]
                ]);

                if($email && $password){
                    // get the user if the entered email corresponds the database
                    if($user = $this->manager->getUserByEmail($email)){
                        // verify that the password is correct (password_verify — verifies that a password matches a hash)
                        if(password_verify($password, $this->manager->getPasswordByEmail($email))){
                            Session::set("user", $user);
                            // if logged in user is the application admin
                            if (Session::get("user")->hasRole("ROLE_ADMIN")){
                                return $this->redirectToRoute("admin");
                            }
                            return $this->redirectToRoute("main");
                        }
                        else Session::addFlash('error', "Le mot de passe est erroné");
                    }
                    else Session::addFlash('error', "E-mail inconnu !");
                }
                else Session::addFlash('error', "Tous les champs doivent être remplis correctement");
            }
            return $this->render("user/login.php");
        }
    
        public function logout(){
            Session::remove("user");
            Session::addFlash('success', "Déconnexion réussie, à bientôt !");
            return $this->redirectToRoute("security");
        }

        public function register(){
            if(isset($_POST["submit"])){

                // validation or cleaning of data transmitted by the form
                $nickname  = filter_input(INPUT_POST, "nickname", FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $password = filter_input(INPUT_POST, "password", FILTER_VALIDATE_REGEXP, [
                    "options" => [
                        // at least 8 characters, SHIFT, min and number obligatory
                        "regexp" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/"
                    ]
                ]);
                $password_repeat = filter_input(INPUT_POST, "password_repeat", FILTER_DEFAULT);
                
                if($nickname && $email && $password){
                    if(!$this->manager->getUserByEmail($email)){
                        if($password === $password_repeat){

                            $hash = password_hash($password, PASSWORD_ARGON2I);

                            if($this->manager->insertUser($nickname, $email, $hash)){
                                Session::addFlash('success', "Inscription réussie, connectez-vous");
                                
                                return $this->redirectToRoute("security");
                            }
                            else Session::addFlash('error', "Une erreur est survenue");
                        }
                        else{
                            Session::addFlash('error', "Les mots de passe ne correspondent pas !");
                            Session::addFlash('notice', "Tapez les mêmes mots de passe dans les deux champs !");
                        }
                    }
                    else Session::addFlash('error', "Cette adresse mail est déjà liée à un compte");
                }
                else Session::addFlash('notice', "Les champs saisis ne respectent pas les valeurs attendues !");
            }

            return $this->render("user/register.php");
        }

        public function profile($id){
            // check if user is logged in
            if(Session::get("user")){
                $user = $this->manager->getOneById($id);
                // check that the user in session is the page owner
                if(Session::get("user")->getId() == $user->getId()){
                    return $this->render("user/profile.php", [
                        "user" => $user,
                        "title"    => $user
                    ]);
                }
            }
            return $this->redirectToRoute("security");
        }

        public function editPassword($id){

            if(Session::get("user")){
                if(Session::get("editPassword")){
                    Session::remove("editPassword");
                    if(isset($_POST["submit"])){

                        // validation of data transmitted by the form
                        $new_password = filter_input(INPUT_POST, "new_password", FILTER_VALIDATE_REGEXP, [
                            "options" => [
                                "regexp" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/"
                                //au moins 8 caractères, MAJ, min et chiffre obligatoires
                            ]
                        ]);
                        $old_password = filter_input(INPUT_POST, "old_password", FILTER_SANITIZE_STRING);

                        if(password_verify($old_password, $this->manager->getPasswordById($id))){
                            if($id && $new_password){ 
                            $hash = password_hash($new_password, PASSWORD_ARGON2I);   
                                if( $this->manager->upDatePassword($id, $hash) ){
                                    Session::addFlash('success', "Le mot de passe a été édité");
                                }
                                else{
                                    Session::addFlash('error', "Une erreur est survenue");
                                }
                            }
                            else Session::addFlash('error', "Tous les champs doivent être remplis correctement");
                        }
                        else Session::addFlash('error', "Le mot de passe est erroné");
                    }
                    else Session::addFlash('error', "Une erreur est survenue");
                }
                else Session::set("editPassword", 1);
                return $this->profile($id);   
            }  
            return $this->redirectToRoute("security");
        }

        public function cancelPassword($id)
        {
            // check if user is logged in
            if(Session::get("user")){

                Session::remove("editPassword");
                return $this->profile($id);
            }  
            return $this->redirectToRoute("security");
        }

        public function editNickname($id)
        {
            // check if user is logged in
            if(Session::get("user")){
                if(Session::get("editNickname")){
                    Session::remove("editNickname");
                    if(isset($_POST["submit"])){
                        // cleaning of data transmitted by the form
                        $nickname = filter_input(INPUT_POST, "nickname", FILTER_SANITIZE_STRING);
                        
                        if($id && $nickname){ 
                            
                            if($this->manager->updateNickname($id, $nickname)){
                                Session::addFlash('success', "Le nom d'utilisateur a été édité");
                            }
                            else{
                                Session::addFlash('error', "Une erreur est survenue");
                            }
                        }
                        else Session::addFlash('error', "Le champ doit être rempli correctement");                       
                    }
                    else Session::addFlash('error', "Une erreur est survenue");
                }
                else Session::set("editNickname", 1);
                return $this->profile($id);   
            }  
            return $this->redirectToRoute("security");
        }

        public function cancelNickname($id)
        {
            if(Session::get("user")){

                Session::remove("editNickname");
                return $this->profile($id);
            }  
            return $this->redirectToRoute("security");
        }

        public function editEmail($id)
        {
            // check if user is logged in
            if(Session::get("user")){
                if(Session::get("editEmail")){
                    Session::remove("editEmail");
                    if(isset($_POST["submit"])){
                        // validation or cleaning of data transmitted by the form
                        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
             
                        if($id && $email){ 
                            if(!$this->manager->getUserByEmail($email)){
                                if($this->manager->updateEmail($id, $email)){
                                    Session::addFlash('success', "L'email a été édité");
                                }
                                else{
                                    Session::addFlash('error', "Une erreur est survenue");
                                }
                            }
                            else Session::addFlash('error', "Cette adresse mail est déjà liée à un compte");    
                        }
                        else Session::addFlash('error', "Le champ doit être rempli correctement");                        
                    }
                    else Session::addFlash('error', "Une erreur est survenue");
                }
                else Session::set("editEmail", 1);
                return $this->profile($id);   
            }  
            return $this->redirectToRoute("security");
        }
        
        public function cancelEmail($id)
        {
            // check if user is logged in
            if(Session::get("user")){

                Session::remove("editEmail");
                return $this->profile($id);
            }  
            return $this->redirectToRoute("security");
        }

    }