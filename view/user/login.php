<div class="uk-container">    
    <h1> Connectez-vous</h1>

    <!-- login form -->
    
    <form action="?ctrl=security" method="post">
        <div class="uk-margin">
            <label for="mail">Votre email : </label><br>
            <input  class="uk-input uk-form-width-large"type="email" name="email" id="mail" required>
        </div>
        <div class="uk-margin">
            <label for="pass">Votre mot de passe : </label><br>
            <input class="uk-input uk-form-width-large" type="password" name="password" id="pass" required>
        </div>
        <div class="uk-margin">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input class="uk-button uk-button-secondary" type="submit" name="submit" value="Se connecter">
        </div>
    </form>
    <div class=" uk-margin-medium  uk-card uk-card-default uk-card-body uk-width-1-2@m">
        <div>Vous n'avez pas encore de compte ?</div>
        <div>Vous pouvez  <a href="?ctrl=security&action=register">vous inscrire</a></div>
    </div>
</div>