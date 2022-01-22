<?php
    use App\Core\Session;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Planner Room<?= $title ? " - ".$title : "" ?></title>
    <meta name="description" content="Gérez facilement vos projets avec Planner Room : créez des tableaux, insérez-y des listes de tâches, et invitez des personnes à y participer">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="public/images/planner_room_favicon_106x120.png" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.18/dist/css/uikit.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <!-- CSS -->
    <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
    <link rel="stylesheet" href="public/css/normalize.css">
</head>

<body>  
    <!-- Navigation -->
    <header>       
        <nav class="header-nav" uk-navbar>
            <a id="planner-room-logo" href="?ctrl=home"><img src="public/images/planner_room_logo_510x82.png" alt="logo du site comprenant à gauche 4 carrés colorés formant le mot 'task', et à droite le nom du site 'Planner Room'"></a>
            <div class="header-nav-div">
                <ul class="header-nav-div-ul">           
                    <li>
                    <?php
                        if(Session::get("user")){
                            if(Session::get("user")->hasRole("ROLE_ADMIN")){
                    ?>      
                            <a class="shutter-effect" href='?ctrl=admin'>Administration</a>
                        <?php
                            }
                        ?>                                                
                            <a class="shutter-effect" href='?ctrl=security&action=profile&id=<?= Session::get("user")->getId() ?>'><img class="user-profile-icon" src="public/images/planner_room_user_profile_icon_96x96.png" alt="icone profil utilisateur"> Bonjour  <?= Session::get("user") ?></a>
                            <a class="shutter-effect" href="?ctrl=main">Dashboard</a> 
                            <a class="shutter-effect" href='?ctrl=security&action=logout'>Se déconnecter</a>
                    <?php
                        }else{
                    ?>
                            <a class="shutter-effect" href='?ctrl=security&action=login'>Se connecter</a>
                            <a class="shutter-effect" href='?ctrl=security&action=register'>S'inscire</a>
                            
                    <?php
                        }
                    ?>
                    </li>
                </ul>
            </div>  
        </nav>
    </header>

    <main>
        <!-- Display of error, success and notice messages -->
        <div class="form-message"><?php include("messages.php"); ?></div>
        <!-- Integration of the page that the controller sends -->
        <?= $page ?> 
    </main>

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.18/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.18/dist/js/uikit-icons.min.js"></script>
</body>
</html>