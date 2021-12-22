<?php
    namespace App\Controller;
    
    use App\Core\AbstractController as AC;
    use App\Core\Session;
    use App\Model\Manager\UserAppManager;

    class SecurityController extends AC
    {
        public function __construct(){
            $this->manager = new UserAppManager();
        }
        /**
         * display the login form or compute the login action with post data
         * 
         * @return mixed the render of the login view or a Router redirect (if login action succeeded)
         */
        public function login(){
            if(isset($_POST["submit"])){
                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $password = filter_input(INPUT_POST, "password", FILTER_VALIDATE_REGEXP, [
                    "options" => [
                        "regexp" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/"
                        //au moins 8 caractères, MAJ, min et chiffre obligatoires
                    ]
                ]);

                if($email && $password){
                    if($user = $this->manager->getUserByEmail($email)){//on récupère l'user si l'email saisi correspond en BDD
                        if(password_verify($password, $this->manager->getPasswordByEmail($email))){
                            Session::set("user", $user);
                            Session::addFlash('success', "Bienvenue !");
                            
                            return $this->redirectToRoute("main");
                        }
                        else Session::addFlash('error', "Le mot de passe est erroné");
                    }
                    else Session::addFlash('error', "E-mail inconnu !");
                }
                else Session::addFlash('error', "Tous les champs sont obligatoires et doivent respecter...");

            }

            return $this->render("user/login.php");
        }

        public function logout(){
            Session::remove("user");
            Session::addFlash('success', "Déconnexion réussie, à bientôt !");
            return $this->redirectToRoute("main");
        }

        public function register(){
            if(isset($_POST["submit"])){
                $nickname  = filter_input(INPUT_POST, "nickname", FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $password = filter_input(INPUT_POST, "password", FILTER_VALIDATE_REGEXP, [
                    "options" => [
                        "regexp" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/"
                        //au moins 6 caractères, MAJ, min et chiffre obligatoires
                    ]
                ]);
                $password_repeat = filter_input(INPUT_POST, "password_repeat", FILTER_DEFAULT);
                
                if($nickname && $email && $password){
                    if(!$this->manager->getUserByEmail($email)){
                        if($password === $password_repeat){

                            $hash = password_hash($password, PASSWORD_ARGON2I);

                            if($this->manager->insertUser($nickname, $email, $hash)){
                                Session::addFlash('success', "Inscription réussie, connectez-vous !");
                                
                                return $this->redirectToRoute("security", "login");
                            }
                            else Session::addFlash('error', "Une erreur est survenue...");
                        }
                        else{
                            Session::addFlash('error', "Les mots de passe ne correspondent pas !");
                            Session::addFlash('notice', "Tapez les mêmes mots de passe dans les deux champs !");
                        }
                    }
                    else Session::addFlash('error', "Cette adresse mail est déjà liée à un compte...");
                }
                else Session::addFlash('notice', "Les champs saisis ne respectent pas les valeurs attendues !");
            }

            return $this->render("user/register.php");
        }

        public function profile($id){
            if(Session::get("user")){
                $user = $this->manager->getOneById($id);
                return $this->render("user/profile.php", [
                    "user" => $user,
                    "title"    => $user
                ]);
            }
            Session::addFlash('error', 'Access denied !');
            return $this->redirectToRoute("main");
        }

        public function changePassword($id)
        {
            if(Session::get("user")){

                Session::set("editPassword", 1);
                return $this->profile($id);
            }  
            else return $this->render("user/login.php", [
                "title"    => "Connextion"
            ]);
        }


        public function editPassword($id){

            if(Session::get("user")){
                if(Session::get("editPassword")){
                    Session::remove("editPassword");
                    if(isset($_POST["submit"])){

                        $new_password = filter_input(INPUT_POST, "new_password", FILTER_VALIDATE_REGEXP, [
                            "options" => [
                                "regexp" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/"
                                //au moins 6 caractères, MAJ, min et chiffre obligatoires
                            ]
                        ]);
                        $old_password = filter_input(INPUT_POST, "old_password", FILTER_SANITIZE_STRING);

                        if(password_verify($old_password, $this->manager->getPasswordById($id))){
                            if($id && $new_password){ 
                            $hash = password_hash($new_password, PASSWORD_ARGON2I);   
                                if( $this->manager->upDatePassword($id, $hash) ){
                                    Session::addFlash('success', "Le mot de pass était édité");
                                }
                                else{
                                    Session::addFlash('error', "Une erreur est survenue, contactez l'administrateur...");
                                }
                            }
                            else Session::addFlash('error', "Tous les champs doivent être remplis et respecter leur format...");
                        }
                        else Session::addFlash('error', "Le mot de passe est erroné");
                    }
                    else Session::addFlash('error', "Une erreur est survenue!");
                }

                return $this->profile($id);   
            }  
            else return $this->render("user/login.php", [
                "title"    => "Connextion"
            ]);
        }


        public function cancelPassword($id)
        {
            if(Session::get("user")){

                Session::remove("editPassword");
                return $this->profile($id);
            }  
            else return $this->render("user/login.php", [
                "title"    => "Connextion"
            ]);
        }

        public function editNickname($id)
        {
            if(Session::get("user")){
                return $this->profile($id);
            }  
            else return $this->render("user/login.php", [
                "title"    => "Connextion"
            ]);
        }

        public function editEmail($id)
        {
            if(Session::get("user")){
                return $this->profile($id);
            }  
            else return $this->render("user/login.php", [
                "title"    => "Connextion"
            ]);
        }
        
    }