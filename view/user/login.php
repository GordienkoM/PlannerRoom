<h1>
    Connectez-vous
</h1>

<form action="?ctrl=security&action=login" method="post">
    <p>
        <label for="mail">Votre email : </label><br>
        <input  class="uk-input uk-form-width-large"type="email" name="email" id="mail" required>
    </p>
    <p>
        <label for="pass">Votre mot de passe : </label><br>
        <input class="uk-input uk-form-width-large" type="password" name="password" id="pass" required>
    </p>
    <p>
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <input class="uk-button uk-button-secondary" type="submit" name="submit" value="Se connecter">
    </p>
</form>
<div class=" uk-margin-medium  uk-card uk-card-default uk-card-body uk-width-1-2@m">
    <p>Vous n'avez pas encore de compte ?</p>
    <p>Vous pouvez  <a href="?ctrl=security&action=register">vous inscrire</a></p>
</div>