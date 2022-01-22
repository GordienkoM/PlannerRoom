<div class="registration-page">
    <div class="registration-container">
        <div class="registration-form">
            <h1>Inscrivez-vous</h1>

            <!-- Registration Form -->
            
            <form action="?ctrl=security&action=register" method="post">
                <div>
                    <label for="nickname">Pseudo : </label>
                    <input type="text" name="nickname" id="nickname" required>
                </div>
                <div>
                    <label for="mail">Email : </label>
                    <input type="email" name="email" id="mail" required>
                </div>
                <div>
                    <label for="pass">Mot de passe : </label>
                    <input type="password" name="password" id="pass" required>
                </div>
                <div>
                    <label for="passr">Ressaisir votre mot de passe : </label>
                    <input type="password" name="password_repeat" id="passr" required>
                </div>
                <div>
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <input type="submit" name="submit" value="S'inscrire">
                </div>
            </form>
            
        </div>
    </div>
</div>
