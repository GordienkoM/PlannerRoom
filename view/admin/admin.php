<?php
    use App\Core\Session;

    $users = $data['users'];
?>
<div class="admin-page">
    <div class="admin-container">
        <h1>Administration</h1>
        <h2 class="users-list">Liste des utilisateurs</h1>
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
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th id="admin-container-th-delete">Supprimer</th>
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
                            <div class="div-icon-delete"> 
                                <!-- delete user button button with an anchor toggling the modal -->            
                                <a uk-icon="trash" href="#modal-delete-user-<?= $user->getId() ?>" uk-toggle></a>           
                            </div>
                            <!-- delete user confirm (modal) -->
                            <div id="modal-delete-user-<?= $user->getId() ?>" uk-modal>
                                <div class="delete-user-confirm uk-modal-dialog uk-modal-body">
                                    <button class="uk-modal-close-default" type="button" uk-close></button>
                                    <div class="delete-user-text-confirm">Etes-vous sûr de vouloir supprimer l'utilisateur <?= $user ?> ?</div>
                                    <div class="uk-margin-top">
                                        <a class="delete-user-confirm-button" href="?ctrl=admin&action=delUser&id=<?=  $user->getId() ?>">Supprimer</a> 
                                        <a class="uk-modal-close">Annuler</a>
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
</div>
