<?php
    ob_start();
    $title = "Editer un article -";
?>

<?php $articleEdit = $editInfos->fetch(); ?>

<section>
    <div>
        <form action="/index.php/process/updateArticle" method="POST">
            <p>
                <label for="ed_title">Titre de l'article : </label>
                <input type="text" name="ed_title" id="ed_title" required value="<?= $articleEdit["title"]; ?>" />
            </p>
            <p>
                <label for="ed_cat">Catégorie : </label>
                <select name="ed_cat">
                    <option value="" selected>...</option>
                    <?php while ($catinfo = $categories->fetch()) { ?>
                        <option value=<?= $catinfo["category_id"]; ?>><?= $catinfo["name"]; ?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="ed_decription">Descriptif : </label>
                <input type="text" name="ed_description" id="ed_description" required value="<?= $articleEdit["description"]; ?>" />
            </p>
            <div>
                <p>Contenu de l'article :</p>
                <textarea name="ed_content" rows="8" cols="80" required ><?= $articleEdit["content"]; ?></textarea>
            </div>
            <p>En date du : <i><?= $date; ?></i></p>
            <div>
                <p>
                    <label>Choisissez une image d'illustration : </label>
                    <input type="file" name="ed_image" accept="image/jpeg" /> (facultatif)
                </p>
                <p>
                    <label for="ed_keywords">Mots-clé : </label>
                    <input type="text" name="ed_keywords" id="ed_keywords" required value="<?= $articleEdit["keywords"]; ?>" />
                </p>
            </div>
            <button type="submit">Editer !</button>
        </form>
    </div>
</section>

<?php
    $content = ob_get_clean();
    require_once "public/template.php";
?>
