<?php
    ob_start();
    $title = "Mon profil -";
?>

<section>
    <div>
        <h1>
            Bonjour <?= $_SESSION["currentSessionPseudo"]; ?> !
        </h1>
    </div>
    <div class="centre">
        <?php if ($posts->rowCount() == 0) : ?>
            <p>Vous n'avez publié aucun article pour le moment ! Rendez-vous dans la section <strong>Publier un article</strong> pour le voir apparaître ici.</p>
        <?php else : ?>
            <?php while($post = $posts->fetch()) { ?>
                <article class="article_from_user">
                    <h2><?= $post["title"]; ?></h2>
                    <h4><?= $post["description"]; ?></h4>
                    <p><?= $post["content"]; ?></p>
                    <pre><?= $post["publication_date"]; ?></pre>
                    <p>
                        <a href="/index.php/page/article?article-edition=<?= $post["article_id"]; ?>">Editer</a> |
                        <a href="/index.php/process/article?delete-article=<?= $post["article_id"]; ?>">Supprimer</a>
                    </p>
                </article>
            <?php } ?>
        <?php endif; ?>
    </div>
    <div class="centre">
        <a href="/index.php/page/myProfile/edit">Editer mon profil</a> |
        <a href="/index.php/process/disconnectUser">Déconnexion</a>
    </div>
</section>

<?php
    $content = ob_get_clean();
    require "public/template.php";
?>
