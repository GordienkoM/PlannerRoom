<?php
    use App\Core\Session;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.18/dist/css/uikit.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />

    <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
    <title>Planner room<?= $title ? " - ".$title : "" ?></title>
</head>
<body> 
    <nav class="uk-navbar-container" uk-navbar>
        <a class="uk-navbar-item uk-logo" href="?ctrl=home">Planner Room</a>
        <div class="uk-navbar-right">
            <ul class="uk-navbar-nav">           
                <li class="uk-navbar-item">
                    <a href="?ctrl=home">Dashboard</a>
                </li>
                <li class="uk-navbar-item">
                <?php
                    if(Session::get("user")){
                        ?>
                            <a href='?ctrl=security&action=profile'><?= Session::get("user")->getEmail() ?></a>
                            <a href='?ctrl=security&action=logout'>Déconnexion</a>
                        <?php
                    }
                    else{
                        ?>
                            <a href='?ctrl=security&action=register'>Inscription</a>
                            <a href='?ctrl=security&action=login'>Connexion</a>
                        <?php
                    }
                ?>
                </li>
            </ul>
        </div>  
    </nav>
    <div class="uk-margin-small-top"><?php include("messages.php"); ?></div>
    <main class="uk-container" >
        <div>
            <?= $page //ici s'intègrera la page que le contrôleur aura renvoyé !!?> 
        </div>
    </main>


    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.18/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.18/dist/js/uikit-icons.min.js"></script>
</html>
    