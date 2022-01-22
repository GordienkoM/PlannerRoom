<div class="login-page">
    <div class="login-container">
        <div class="login-text">
            <h2>Gérez vos projets de manière simple et intuitive avec Planner Room</h2>
            <p>Grâce à Planner Room vous pouvez créer des tableaux, y insérer des listes qui contiendront vos cartes, et inviter des personnes à participer à vos projets</p>
        </div>
        <div class="login-form">
            <div class="login-form-container">
                <div class="login-form-container-div">    
                    <h1> Connectez-vous</h1>

                    <!-- login form -->
                    
                    <form action="?ctrl=security" method="post">
                        <div class="input-div" id="login-input-email">
                            <label for="mail">Email : </label>
                            <input type="email" name="email" id="mail" required>
                        </div>
                        <div class="input-div">
                            <label for="pass">Mot de passe : </label>
                            <input type="password" name="password" id="pass" required>
                        </div>
                        <div>
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <input type="submit" name="submit" value="Se connecter">
                        </div>
                    </form>
                    <div class="register-div">
                        <div>Vous n'avez pas encore de compte ?</div>
                        <div>Vous pouvez  <a href="?ctrl=security&action=register">vous inscrire</a></div>
                    </div>
                </div>
                <div class="drop drop-1"></div>
                <div class="drop drop-2"></div>
                <div class="drop drop-3"></div>
                <div class="drop drop-4"></div>
            </div>
        </div>
    </div>
</div>