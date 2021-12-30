<?php
use App\Core\Session;

$table = $data['table'];
?>

<nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">
        <h1 class="uk-margin-left"><?=  $table ?></h1>
    </div>

    <div class="uk-navbar-right">
        <div class="uk-inline">
        <?php
            foreach($table->getParticipants() as $participant){
        ?> 
            <button class="uk-button uk-button-default uk-border-circle uk-margin-right" type="button">
                <div><?=  $participant->getFirstLetter() ?></div>
            </button>
            <div uk-drop="mode: click">
                <div class="uk-card uk-card-body uk-card-default">
                    <div><?=  $participant->getEmail() ?></div>
                    <div><?=  $participant ?></div>
                    <div>
                    <?php
                        if($participant->getId() == $table->getUserApp()->getId()){
                    ?>
                        Gestionnaire
                    <?php
                        } else if($participant->getId() == Session::get("user")->getId()) { 
                    ?>  
                        <a href="?ctrl=forum&action=delParticipant&id=<?=  $table->getId() ?>">Quitter le tableau</a>  
                    <?php
                        }
                    ?> 
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
        </div>
        <div> 
        <!-- This is an anchor toggling the modal -->            
            <a class="uk-button uk-button-default uk-margin-right" href="#modal-invite-participant" uk-toggle>Inviter un participant</a>           
        </div>

        <!-- This is the modal -->
        <div id="modal-invite-participant" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <h2 class="uk-modal-title">Invitation d'un participant</h2>
                <form action="?ctrl=main&action=createInvitation" method="post">
                    <div>
                        <label for="mail">Email : </label><br>
                        <input class="uk-input uk-form-width-large" type="email" name="email" id="mail" placeholder="Entrez l'email d'utilisateur à inviter" required>
                    </div>
                    <div class="uk-margin-top">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Appliquer">
                        <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="uk-flex uk-flex-between uk-padding uk-padding-remove-horizontal">
    <div></div>
    <div> 
        <!-- This is an anchor toggling the modal -->            
        <a class="uk-button uk-button-secondary" href="#modal-create-list" uk-toggle>Créer une liste</a>           
    </div>

    <!-- This is the modal -->
    <div id="modal-create-list" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h2 class="uk-modal-title">Nouvelle liste</h2>
            <form action="?ctrl=main&action=addList" method="post">
                <div class="uk-margin">
                    <label for="title">Titre de liste : </label><br>
                    <input class="uk-input" type="text" name="title" id="title" required>
                </div>
                <div class="uk-margin-top">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Appliquer">
                    <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                </div>  
            </form>
        </div>
    </div>
</div>

<div>

</div>
