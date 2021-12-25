<?php
use App\Core\Session;

// $tables = $data['tables'];
?>

<div class="uk-flex uk-flex-between uk-padding uk-padding-remove-horizontal">
    <h1>Liste des tableaux</h1>
    <div> 
        <!-- This is an anchor toggling the modal -->            
        <a class="uk-button uk-button-secondary" href="#modal-create-table" uk-toggle>Créer un tableau</a>           
    </div>

    <!-- This is the modal -->
    <div id="modal-create-table" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h2 class="uk-modal-title">Nouveau tableau</h2>
            <form action="?ctrl=main&action=addTable" method="post">
                <div class="uk-margin">
                    <label for="title">Titre de tableau : </label><br>
                    <input class="uk-input" type="text" name="title" id="title" required>
                </div>
                <div class="uk-margin">
                    <label for="description">Descriprion de tableau : </label><br>
                    <textarea class="uk-textarea uk-form-width-large" name="description" id="description"></textarea>
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
