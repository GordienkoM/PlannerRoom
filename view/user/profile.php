<?php
    use App\Core\Session;

    $user = $data['user'];
?>

<div class="uk-container">
    <h1> Profil</h1>

    <!-- table with user data -->

    <table class="uk-table uk-margin-medium-top ">
        <tbody>
            <tr>
                <td>Pseudo</td>
                <td><?=  $user ?></td>
                <td>
                    <?php
                    // check if the user clicked on the button to edit the nickname
                    if(Session::get("editNickname")){
                    ?>
                        <!-- edit nickname form --> 
                        <form class="uk-flex uk-margin" action="?ctrl=security&action=editNickname&id=<?= $user->getId() ?>" method="post">
                            <input class="uk-input" type="text" name="nickname" value="<?= $user->getNickname() ?>" required>
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Appliquer">
                            <div>
                                <a class="uk-button uk-button-secondary" href="?ctrl=security&action=cancelNickname&id=<?= $user->getId() ?>">Annuler</a>
                            </div>  
                        </form>
                    <?php
                    } else { 
                    ?>   
                        <!-- button to edit the nickname -->
                        <a class="uk-icon-link uk-margin-small-right" uk-icon="file-edit" href="?ctrl=security&action=editNickname&id=<?= $user->getId() ?>"></a>           
                    <?php
                    }
                    ?> 
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?=  $user->getEmail() ?></td>
                <td>
                    <?php
                    // check if the user clicked on the button to edit the email
                    if(Session::get("editEmail")){
                    ?>
                        <!-- edit email form --> 
                        <form class="uk-flex uk-margin" action="?ctrl=security&action=editEmail&id=<?= $user->getId() ?>" method="post">
                            <input class="uk-input" type="text" name="email" value="<?= $user->getEmail() ?>" required>
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Appliquer">
                            <div>
                                <a class="uk-button uk-button-secondary" href="?ctrl=security&action=cancelEmail&id=<?= $user->getId() ?>">Annuler</a>
                            </div>  
                        </form>
                    <?php
                    } else { 
                    ?>  
                        <!-- button to edit the email -->
                        <a class="uk-icon-link uk-margin-small-right" uk-icon="file-edit" href="?ctrl=security&action=editEmail&id=<?= $user->getId() ?>"></a>
                    <?php
                    }
                    ?> 
                </td>
            </tr>
            <tr>
                <?php
                // check if the user clicked on the button to edit the password
                if(Session::get("editPassword")){
                ?>
                    <td colspan="3">
                        <!-- edit password form --> 
                        <form  action="?ctrl=security&action=editPassword&id=<?= $user->getId() ?>" method="post">
                            <div>
                                <label for="pass">Nouveau mot de pass : </label><br>
                                <input class="uk-input uk-form-width-large" type="password" name="new_password" id="pass" required>
                            </div>
                            <div>
                                <label for="old_pass">Mot de pass actuél: </label><br>
                                <input class="uk-input uk-form-width-large" type="password" name="old_password" id="old_pass" required>
                            </div>
                            <div class="uk-flex uk-margin">
                                <div>
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <input class="uk-button uk-button-secondary uk-margin-right"  type="submit" name="submit" value="Appliquer">
                                </div>
                                <div><a class="uk-button uk-button-secondary" href="?ctrl=security&action=cancelPassword&id=<?= $user->getId() ?>">Annuler</a></div>
                            </div>    
                        </form>
                    </td>
                <?php
                } else { 
                ?>               
                    <td>Mot de pass</td>
                    <td>********</td>
                    <td>  
                        <!-- button to edit the password -->
                        <a class="uk-icon-link uk-margin-small-right" uk-icon="file-edit" href="?ctrl=security&action=editPassword&id=<?= $user->getId() ?>"></a>
                    </td>
                <?php
                }
                ?>              
            </tr>
        </tbody>
    </table>
</div>




