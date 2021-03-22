<?php
    ob_start();
    $title = "Administration -";
?>

<section>
    <div>
        <h2 class="centre">Attention : un grand pouvoir implique de grandes responsabilités !</h2>
    </div>
    <div class="formulaire">
        <p>
            <form action="/index.php/admin/setNewCategory" method="POST">
                <label for="newCategoryName" class="centre" >Ajouter une catégorie : </label>
                <input type="text" name="newCategoryName" id="newCategoryName" />
                <button type="submit" class="btn btn-outline-info" id="connection">Ajouter la catégorie</button>
                <details open>
                    <summary>Catégories existantes</summary>
                    <?php while($category = $categories->fetch()) { ?>
                        <li><?= $category["name"]; ?></li>
                    <?php } ?>
                </details>
                <?php if (isset($_SESSION["newCategorySet"])) : ?>
                    <span><?= $_SESSION["newCategorySet"]; ?></span>
                <?php endif; unset($_SESSION["newCategorySet"]); ?>
            </form>
        </p>
        <p>
            <form action="/index.php/admin/promoteUser" method="POST">
                <label for="promoteUser" class="centre">Promouvoir un utilisateur : </label>
                <select name="promoteUser" id="promoteUser">
                    <option selected>...</option>
                    <?php while($user = $promoteUsers->fetch()) { ?>
                        <option value=<?= $user["user_id"]; ?>><?= $user["pseudo"]; ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="btn btn-outline-success" id="connection">Promouvoir cet utilisateur</button>
                <?php if (isset($_SESSION["promotedUser"])) : ?>
                    <span><?= $_SESSION["promotedUser"]; ?></span>
                <?php endif; unset($_SESSION["promotedUser"]); ?>
            </form>
        </p>
        <p>
            <form action="/index.php/admin/deleteUser" method="POST">
                <label for="deleteUser" class="centre">Supprimer un utilisateur : </label>
                <select name="deleteUser" id="deleteUser">
                    <option selected>...</option>
                    <?php while($user = $deleteUsers->fetch()) { ?>
                        <option value=<?= $user["user_id"]; ?>><?= $user["pseudo"]; ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="btn btn-outline-danger" id="connection">Supprimer cet utilisateur</button>
                <?php if (isset($_SESSION["deletedUser"])) : ?>
                    <span><?= $_SESSION["deletedUser"]; ?></span>
                <?php endif; unset($_SESSION["deletedUser"]); ?>
            </form>
        </p>
    </div>
</section>

<?php
    $content = ob_get_clean();
    require_once "public/template.php";
?>
