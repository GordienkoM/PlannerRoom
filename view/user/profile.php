<?php
    use App\Core\Session;

    $user = $data['user'];
?>

<div class="profile-page">
    <div class="profile-container">
        <h1> Profil</h1>

        <!-- table with user data -->

        <table>
            <tbody>
                <tr>
                    <td>Nom d'utilisateur</td>
                    <td><?=  htmlspecialchars($user) ?></td>
                    <td>
                        <?php
                        // check if the user clicked on the button to edit the nickname
                        if(Session::get("editNickname")){
                        ?>
                            <!-- edit nickname form --> 
                            <form action="?ctrl=security&action=editNickname&id=<?= $user->getId() ?>" method="post">
                                <input type="text" name="nickname" value="<?= htmlspecialchars($user->getNickname()) ?>" required>
                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                <div class="input-and-link">
                                    <input type="submit" name="submit" value="Appliquer">
                                    <div>
                                        <a href="?ctrl=security&action=cancelNickname&id=<?= $user->getId() ?>">Annuler</a>
                                    </div>
                                </div>  
                            </form>
                        <?php
                        } else { 
                        ?>   
                            <!-- button to edit the nickname -->
                            <a uk-icon="file-edit" href="?ctrl=security&action=editNickname&id=<?= $user->getId() ?>"></a>           
                        <?php
                        }
                        ?> 
                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?=  htmlspecialchars($user->getEmail()) ?></td>
                    <td>
                        <?php
                        // check if the user clicked on the button to edit the email
                        if(Session::get("editEmail")){
                        ?>
                            <!-- edit email form --> 
                            <form action="?ctrl=security&action=editEmail&id=<?= $user->getId() ?>" method="post">
                                <input type="text" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                <div class="input-and-link">
                                    <input type="submit" name="submit" value="Appliquer">
                                    <div>
                                        <a href="?ctrl=security&action=cancelEmail&id=<?= $user->getId() ?>">Annuler</a>
                                    </div> 
                                </div> 
                            </form>
                        <?php
                        } else { 
                        ?>  
                            <!-- button to edit the email -->
                            <a uk-icon="file-edit" href="?ctrl=security&action=editEmail&id=<?= $user->getId() ?>"></a>
                        <?php
                        }
                        ?> 
                    </td>
                </tr>
                <tr class="profile-tr-password">
                    <?php
                    // check if the user clicked on the button to edit the password
                    if(Session::get("editPassword")){
                    ?>
                        <td class="profile-td-new-password" colspan="3">
                            <!-- edit password form --> 
                            <form  action="?ctrl=security&action=editPassword&id=<?= $user->getId() ?>" method="post">
                                <div class="div-new-password">
                                    <label for="pass">Nouveau mot de passe : </label><br>
                                    <input type="password" name="new_password" id="pass" required>
                                </div>
                                <div>
                                    <label for="old_pass">Mot de passe actuel : </label><br>
                                    <input type="password" name="old_password" id="old_pass" required>
                                </div>
                                <div class="input-and-link">
                                    <div>
                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                        <input type="submit" name="submit" value="Appliquer">
                                    </div>
                                    <div><a href="?ctrl=security&action=cancelPassword&id=<?= $user->getId() ?>">Annuler</a></div>
                                </div>    
                            </form>
                        </td>
                    <?php
                    } else { 
                    ?>               
                        <td>Mot de passe</td>
                        <td>********</td>
                        <td>  
                            <!-- button to edit the password -->
                            <a uk-icon="file-edit" href="?ctrl=security&action=editPassword&id=<?= $user->getId() ?>"></a>
                        </td>
                    <?php
                    }
                    ?>              
                </tr>
            </tbody>
        </table>
    </div>
</div>




