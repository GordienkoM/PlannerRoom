<?php
    use App\Core\Session;

    $users = $data['users'];
?>

<div class="uk-container">
    <h1 class="uk-text-center">Administration</h1>
    <h2 class="uk-margin-top">List des utilisateurs</h1>
    <?php
        if(!$users){
    ?>
        <p>Aucun utilisateur ne se trouve pas en base de données...</p>
    <?php
        }else{
    ?>
        <table class='uk-table uk-margin-medium-top'>
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($users as $user){
                    if(Session::get("user")->getId() !== $user->getId()){
            ?>
                <tr>
                    <td><?= $user?></td>
                    <td><?= $user->getEmail()?></td>
                    <td>
                        <div> 
                            <!-- delete user button button with an anchor toggling the modal -->            
                            <a uk-icon="trash" href="#modal-delete-user-<?= $user->getId() ?>" uk-toggle></a>           
                        </div>
                        <!-- delete user confirm (modal) -->
                        <div id="modal-delete-user-<?= $user->getId() ?>" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                <div>Est-ce que vous êtes sûr de vouloir supprimer utilisateur <?= $user ?> ?</div>
                                <div class="uk-margin-top">
                                    <a class="uk-button uk-button-secondary uk-margin-right uk-margin-left" href="?ctrl=admin&action=delUser&id=<?=  $user->getId() ?>">Supprimer</a> 
                                    <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                                </div>  
                            </div>
                        </div>
                    </td>
                </tr>
            <?php
                    }
                }
            ?>
            </tbody>
        </table>
    <?php
        }
    ?>
</div>

