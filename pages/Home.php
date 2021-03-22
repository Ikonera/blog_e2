<?php
    ob_start();
    $title = "Accueil -";
?>

<section>
    <div>
        <input type="text" id="search-bar" placeholder="Votre recherche" id="" class="form-control"/>
        <p id="unresult-search"></p>
    </div>
    <div id="centreHome">
        <?php if ($articles->rowCount() == 0) : ?>
            <p>Aucun article n'a été publié ! Rendez-vous dans la section <strong>Publier un article</strong> pour le voir apparaître ici.</p>
        <?php else : ?>
            <?php while($article = $articles->fetch()) { ?>
                <article>
                    <h2>
                        <a href="/index.php/page/article?article-view=<?= $article["article_id"]; ?>">
                            <?= $article["title"]; ?>
                        </a>
                    </h2>
                    <h3><?= $article["description"]; ?></h3>
                    <pre><i><?= $article[4]; ?></i> - à <?= $article["publication_date"]; ?></pre>
                    <?php if ((isset($_SESSION["rights"]) && ($_SESSION["rights"] == 2))) : ?>
                        <a href="/index.php/process/artcle?delete-article=<?= $article["article_id"]; ?>">Supprimer</a>
                    <?php endif; ?>
                </article>
            <?php } ?>
        <?php endif; ?>
    </div>
</section>

<?php
    $content = ob_get_clean();      //on referme le buffer et on le stocke dans la variable "content"
    require_once "public/template.php";   //on spécifie que lorsque l'utilisateur charge la page, le buffer sera copié dans le $content du template
?>
