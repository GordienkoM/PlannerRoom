<?php
use App\Core\Session;

$invitations = $data['invitations'];
$tables = $data['tables'];
?>

<div class="uk-container">

    <!-- creation of a table  -->

    <div class="uk-flex uk-flex-between uk-padding uk-padding-remove-horizontal">
        <h1>Dashboard</h1>
        <div> 
            <!-- table creation  button with an anchor toggling the modal -->            
            <a class="uk-button uk-button-secondary" href="#modal-create-table" uk-toggle>Créer un tableau</a>           
        </div>

        <!-- table creation form (modal) -->
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

    <!-- Display invitations -->

    <?php
        if($invitations){
            foreach($invitations as $invitation){
    ?>
            <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m uk-margin-bottom">
                <h2 class="uk-card-title">Invitation</h2>
                <p><?=  $invitation->getTableApp()->getUserApp() ?> vous invite à participer au tableau "<?=  $invitation->getTableApp() ?>"</p>
                <div class="uk-flex uk-margin">
                    <div><a class="uk-button uk-button-default uk-margin-right" href="?ctrl=main&action=delInvitation&id=<?= $invitation->getTableApp()->getId() ?>">Refuser</a></div>
                    <div><a class="uk-button uk-button-secondary" href="?ctrl=main&action=acceptInvitation&id=<?= $invitation->getTableApp()->getId() ?>">Accepter</a></div>
                </div>
            </div>
    <?php
            }
        } 
    ?> 

    <!-- Table of tables where user participates -->
    <?php
        if( !empty($tables) ){
    ?>
        <h2>Liste des tableaux</h2>
        <table class='uk-table uk-table-hover uk-table-divider'>
            <thead>
                <tr>
                    <th>Nom de tableau</th>
                    <th>Description</th>
                    <th>Gestionnaire</th>
                    <th>Participants</th>
                    <th>Je souhaite..</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($tables as $table){
                ?>       
                <tr>
                    <td>
                        <a href="?ctrl=main&action=showTable&id=<?=  $table->getId() ?>"><?=  $table ?></a>
                    </td>
                    <td><?= $table->getDescription() ?></td>
                    <td><?= $table->getUserApp() ?></td>
                    <td>
                    <?php
                        foreach($table->getParticipants() as $participant){
                    ?> 
                        <div><?=  $participant ?></div>
                    <?php
                        }
                    ?>
                    </td>
                    <td>
                    <?php
                        //check if logged in user is table admin
                        if(Session::get("user")->getId() == $table->getUserApp()->getId()){
                    ?>
                        <div> 
                            <!-- table delete button with an anchor toggling the modal -->            
                            <a class="uk-button uk-button-default" href="#modal-delete-table" uk-toggle>Supprimer le tableau</a>           
                        </div>
                        <!-- table delete confirm (modal) -->
                        <div id="modal-delete-table" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                <div>Est-ce que vous êtes sûr de vouloir supprimer le tableau "<?= $table ?>" ?</div>
                                <div class="uk-margin-top">
                                    <a class="uk-button uk-button-secondary uk-margin-right uk-margin-left" href="?ctrl=main&action=delTable&id=<?= $table->getId() ?>">Supprimer le tableau</a> 
                                    <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                                </div>  
                            </div>
                        </div>
                    <?php
                        } else { 
                    ?>  
                        <div> 
                            <!-- table leave button with an anchor toggling the modal -->            
                            <a class="uk-button uk-button-default" href="#modal-leave-table" uk-toggle>Quitter le tableau</a>           
                        </div>
                        <!-- table leave confirm (modal) -->
                        <div id="modal-leave-table" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                <div>Est-ce que vous êtes sûr de vouloir quitter le tableau "<?= $table ?>" ?</div>
                                <div class="uk-margin-top">
                                    <a class="uk-button uk-button-secondary uk-margin-right uk-margin-left" href="?ctrl=main&action=leaveTable&id=<?= $table->getId() ?>">Quitter le tableau</a> 
                                    <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                                </div>  
                            </div>
                        </div>
                    <?php
                        }
                    ?> 
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    <?php
        } 
    ?> 
</div>