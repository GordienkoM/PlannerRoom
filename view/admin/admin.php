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
                        <a uk-icon="trash" href="?ctrl=admin&action=delUser&id=<?=  $user->getId() ?>"></a>
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

