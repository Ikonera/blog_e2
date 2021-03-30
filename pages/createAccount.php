<?php
    ob_start();
    $title = "Créer un compte -";
?>

<section>
    <div class="formulaire">
        <p class="centre">
            Créez un compte dès à présent !
        </p>
        <?php if (isset($_SESSION["errors"])) : ?>
            <div>
                <?= implode("<br />", $_SESSION["errors"]); ?>
            </div>
        <?php unset($_SESSION["errors"]); endif; ?>
        <form action="/index.php/process/createUser" method="POST">
            <div class="entrerFormulaire">
                <input type="text" name="cr_name" placeholder="Nom" required />
                <input type="text" name="cr_lastname" placeholder="Prénom" required />
            </div>
            <div class="entrerFormulaire">
                <input type="text" name="cr_pseudo" placeholder="Pseudo" required />
                <input type="email" name="cr_mail" placeholder="Adresse mail" required />
            </div>
            <div class="entrerFormulaire">
                <input type="password" class="mdp" name="cr_password" placeholder="Mot de passe" required />
                <input type="password" name="cr_password_verification" placeholder="Confirmez votre mot de passe" required />
            </div>
            <button type="submit" id="connection" class="btn btn-outline-primary">Je m'inscris !</button>
        </form>
        <p class="centre">Vous êtes déjà inscrit ?<a href="/index.php/page/connect">Connectez-vous !</a> !</p>
    </div>
</section>

<?php
    $content = ob_get_clean();
    require "public/template.php";
?>
