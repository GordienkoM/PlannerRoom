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
            <button class="uk-button uk-button-default uk-border-circle uk-margin-right" type="button">
            <?php
                foreach($table->getParticipants() as $participant){
            ?> 
                <div><?=  $participant->getFirstLetter() ?></div>
            <?php
                }
            ?>
            </button>
            <div uk-drop="mode: click">
                <div class="uk-card uk-card-body uk-card-default">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</div>
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
