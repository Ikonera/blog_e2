<?php
    ob_start();
    $title = "Editer mon profil -";
?>

<?php $urlRedirection = "/index.php/process/updateProfile"; ?>

<section>
    <div class="formulaire">
        <form action="<?= $urlRedirection; ?>" method="POST">
            <div class="entrerFormulaire">
                <label for="edNewPseudo" class="centre">Modifier mon pseudo : </label>
                <input type="text" name="edNewPseudo" id="edNewPseudo" placeholder="<?= $_SESSION["currentSessionPseudo"]; ?>" />
            </div>
            <button type="submit" name="pseudoUpdate" class="btn btn-outline-success" id="connection">Changer mon pseudo !</button>
        </form>
        <form action="<?= $urlRedirection; ?>" method="POST">
            <div class="entrerFormulaire">
                <p class="centre">
                    <label for="edProfilePicture" >Modifier mon avatar (coming soon !) : </label>
                    <input type="file" name="edProfilePicture" id="edProfilePicture"/>
                </p>
            </div>
            <button type="button" name="pictureUpdate" class="btn btn-outline-success" id="connection" >Non disponible</button>
        </form>
        <form action="<?= $urlRedirection; ?>" method="POST">
            <div class="entrerFormulaire">
                <p class="centre">
                    <label for="edMailAdress" >Changer mon adresse mail : </label>
                    <input type="email" name="edMailAdress" id="edMailAdress" placeholder="<?= $_SESSION["currentSessionMail"]; ?>" />
                </p>
            </div>
            <button type="submit" name="mailUpdate" class="btn btn-outline-success" id="connection">Changer mon adresse mail !</button>
        </form>
        <form action="<?= $urlRedirection; ?>" method="POST">
            <div class="entrerFormulaire">
                <p class="centre"> 
                    <label for="edOldPwd" >Modifier mon mot de passe : </label>
                    <input type="password" name="edOldPwd" id="edOldPwd" placeholder="Ancien mot de passe" />
                    <input type="password" name="edNewPwd" placeholder="Nouveau mot de passe" />
                    <input type="password" name="edNewPwdVerif" placeholder="Confirmez le nouveau mot de passe" />
                </p>
            </div>
            <button type="submit" name="passwordUpdate" class="btn btn-outline-success" id="connection">Changer mon mot de passe !</button>
        </form>
            <?php if (isset($_SESSION["update"])) : ?>
                <span><?= implode("<br/>", $_SESSION["update"]); ?></span>
            <?php unset($_SESSION["update"]); endif; ?>
    </div>
</section>

<?php
    $content = ob_get_clean();
    require "public/template.php";
?>
