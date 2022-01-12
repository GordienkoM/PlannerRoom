<?php
use App\Core\Session;

$invitations = $data['invitations'];
$boards = $data['boards'];
?>

<div class="uk-container">

    <!-- BOARD CREATION  -->

    <div class="uk-flex uk-flex-between uk-padding uk-padding-remove-horizontal">
        <h1>Dashboard</h1>
        <div> 
            <!-- board creation button with an anchor toggling the modal -->            
            <a class="uk-button uk-button-secondary" href="#modal-create-board" uk-toggle>Créer un tableau</a>           
        </div>

        <!-- board creation form (modal) -->
        <div id="modal-create-board" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <h2 class="uk-modal-title">Nouveau tableau</h2>
                <form action="?ctrl=main&action=addBoard" method="post">
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

    <!-- DISPLAY INVITATION -->

    <?php
        if($invitations){
            foreach($invitations as $invitation){
    ?>
            <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m uk-margin-bottom">
                <h2 class="uk-card-title">Invitation</h2>
                <p><?=  $invitation->getBoard()->getUser() ?> vous invite à participer au tableau "<?=  $invitation->getBoard() ?>"</p>
                <div class="uk-flex uk-margin">
                    <div><a class="uk-button uk-button-default uk-margin-right" href="?ctrl=main&action=delInvitation&id=<?= $invitation->getBoard()->getId() ?>">Refuser</a></div>
                    <div><a class="uk-button uk-button-secondary" href="?ctrl=main&action=acceptInvitation&id=<?= $invitation->getBoard()->getId() ?>">Accepter</a></div>
                </div>
            </div>
    <?php
            }
        } 
    ?> 

    <?php
        if( !empty($boards) ){
    ?>
        <h2>Liste des tableaux</h2>

        <!-- TABLE OF BOARDS WHERE LOGGED IN USER PARTICIPATE -->

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
                    foreach($boards as $board){
                ?>       
                <tr>
                    <td>
                        <a href="?ctrl=main&action=showBoard&id=<?= $board->getId() ?>"><?=  $board ?></a>
                    </td>
                    <td><?= $board->getDescription() ?></td>
                    <td><?= $board->getUser() ?></td>
                    <td>
                    <?php
                        foreach($board->getParticipants() as $participant){
                    ?> 
                        <div><?=  $participant ?></div>
                    <?php
                        }
                    ?>
                    </td>
                    <td>
                    <?php
                        //check if logged in user is board admin
                        if(Session::get("user")->getId() == $board->getUser()->getId()){
                    ?>

                        <!-- DELETE BOARD -->

                        <div> 
                            <!-- board delete button with an anchor toggling the modal -->            
                            <a class="uk-button uk-button-default" href="#modal-delete-board-<?= $board->getId() ?>" uk-toggle>Supprimer le tableau</a>           
                        </div>
                        <!-- board delete confirm (modal) -->
                        <div id="modal-delete-board-<?= $board->getId() ?>" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                <div>Est-ce que vous êtes sûr de vouloir supprimer le tableau "<?= $board ?>" ?</div>
                                <div class="uk-margin-top">
                                    <a class="uk-button uk-button-secondary uk-margin-right uk-margin-left" href="?ctrl=main&action=delBoard&id=<?= $board->getId() ?>">Supprimer le tableau</a> 
                                    <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                                </div>  
                            </div>
                        </div>
                    <?php
                        } else { 
                    ?>  

                        <!-- LEAVE BOARD -->

                        <div> 
                            <!-- board leave button with an anchor toggling the modal -->            
                            <a class="uk-button uk-button-default" href="#modal-leave-board-<?= $board->getId() ?>" uk-toggle>Quitter le tableau</a>           
                        </div>
                        <!-- board leave confirm (modal) -->
                        <div id="modal-leave-board-<?= $board->getId() ?>" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                <div>Est-ce que vous êtes sûr de vouloir quitter le tableau "<?= $board ?>" ?</div>
                                <div class="uk-margin-top">
                                    <a class="uk-button uk-button-secondary uk-margin-right uk-margin-left" href="?ctrl=main&action=leaveBoard&id=<?= $board->getId() ?>">Quitter le tableau</a> 
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