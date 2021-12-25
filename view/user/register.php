
<h1>
    Inscrivez-vous
</h1>
<form action="?ctrl=security&action=register" method="post">
    <div class="uk-margin">
        <label for="nickname">Votre pseudo : </label><br>
        <input class="uk-input uk-form-width-large" type="text" name="nickname" id="nickname" required>
    </div>
    <div class="uk-margin">
        <label for="mail">Votre email : </label><br>
        <input class="uk-input uk-form-width-large" type="email" name="email" id="mail" required>
    </div>
    <div class="uk-margin">
        <label for="pass">Votre mot de passe : </label><br>
        <input class="uk-input uk-form-width-large" type="password" name="password" id="pass" required>
    </div>
    <div class="uk-margin">
        <label for="passr">Ressaisir votre mot de passe : </label><br>
        <input class="uk-input uk-form-width-large" type="password" name="password_repeat" id="passr" required>
    </div>
    <div class="uk-margin">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <input class="uk-button uk-button-secondary"  type="submit" name="submit" value="S'inscrire">
    </div>
</form>

