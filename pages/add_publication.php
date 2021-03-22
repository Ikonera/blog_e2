<?php
    ob_start();
    $title = "Ajouter un article -";
?>

<section>
    <div class="publication">
        <form action="/index.php/process/setNewArticle" method="POST">
            <p>
                <label for="art_title">Titre de l'article : </label>
                <input type="text" name="art_title" id="art_title" />
            </p>
            <p>
                <label for="art_cat">Catégorie : </label>
                <select name="art_cat">
                    <option value="" selected>...</option>
                    <?php while ($catinfo = $categories->fetch()) { ?>
                        <option value=<?= $catinfo["category_id"]; ?>><?= $catinfo["name"]; ?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="art_decription">Descriptif : </label>
                <input type="text" name="art_description" id="art_description" class="form-control" />
            </p>
            <div>
                <p>Contenu de l'article :</p>
                <textarea name="art_content" rows="8" cols="80" class="form-control" draggable="false"></textarea>
            </div>
            <p id="signature">En date du : <i><?= $date; ?></i></p>
            <div>
                <p>
                    <label>Choisissez une image d'illustration : </label>
                    <input type="file" name="art_image" accept="image/jpeg" /> (facultatif)
                </p>
                <p>
                    <label for="art_keywords" class="centre">Mots-clé : </label>
                    <input type="text" name="art_keywords" id="art_keywords" class="form-control" />
                </p>
            </div>
            <button type="submit" class="btn btn-outline-secondary" id="connection">Publier !</button>
        </form>
    </div>
</section>

<?php
    $content = ob_get_clean();
    require "public/template.php";
?>
