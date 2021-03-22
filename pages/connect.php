<?php
    ob_start();     //on récupère le code en buffer (on l'enregistre dans un presse-papier virtuel en gros)
    $title = "Connection -";    //nous servira de title
?>

<section>
    <div class="formulaire">
        <p class="centre">
            Connectez-vous :
        </p>
        <?php if (isset($_SESSION["connectErrors"])) : ?>
            <div>
                <?= implode("<br />", $_SESSION["connectErrors"]); ?>
            </div>
        <?php unset($_SESSION["connectErrors"]); endif; ?>
        <form action="/index.php/process/userConnection" method="POST">
            <div class="entrerFormulaire">
                <input type="email" name="conMail" placeholder="Adresse mail" required />
                <input type="password" name="conPassword" placeholder="Mot de passe" required />
            </div>
            <button type="submit" id="connection" class="btn btn-outline-primary">Se connecter</button>
        </form>
    <p class="centre">Pas de compte ? <a href="/index.php/page/createAccount">Créez-en un maintenant</a> !</p>
    </div>
</section>

<?php
    $content = ob_get_clean();      //on referme le buffer et on le stock dans la variable "content"
    require_once "public/template.php";   //on spécifie que lorsque l'utilisateur charge la page, le buffer sera copié dans le $content du template
?>
