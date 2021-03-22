<?php
    ob_start();
    $title = "View article -";
?>

<?php
    $article = $viewArticle->fetch();
?>

<section>
    <div>
        <article>
            <h1><?= $article["title"]; ?></h1>
            <h3><?= $article["description"]; ?></h3>
            <p><?= $article["content"]; ?></p>
            <pre><?= $article["publication_date"]; ?></pre>

            <details open>
            <summary>Commentaires</summary>
            <?php if ($comments->rowCount() == 0) : ?>
                <p>Aucun commentaire n'a été fait sur cet article.</p>
            <?php else : ?>
                <?php while ($comment = $comments->fetch()) { ?>
                    <div class="commentaire">
                        <p>
                            
                        <p class="contcom"><?= $comment["content"]; ?></p>
                        <?php if ((isset($_SESSION["currentSessionId"])) && ($_SESSION["currentSessionPseudo"] == $comment["comment_author_pseudo"])) : ?>
                            <div id="edComment"><a href="/index.php/page/comment?comment-edition=<?= $comment["comment_id"]; ?>&article=<?= $article["article_id"]; ?>">Editer</a> |
                            <?php if (((isset($_SESSION["rights"])) && ($_SESSION["rights"] == 2)) OR ($_SESSION["currentSessionPseudo"] == $comment["comment_author_pseudo"])) : ?>
                                <a href="/index.php/process/comment?delete-comment=<?= $comment["comment_id"]; ?>">Supprimer</a></div>
                            <?php endif; ?>
                            
                        </p>
                        <?php endif; ?>
                        
                        <pre><?= $comment["comment_author_pseudo"]; ?> - <i><?= $comment["publication_date"]; ?></i></pre>
                    </div>
                <?php } ?>
            <?php endif; ?>
            <?php if (empty($_SESSION["currentSessionId"])) : ?>
                <strong>Vous devez être connecté pour rédiger un commentaire !</strong>
            <?php else : ?>
                <form action="/index.php/process/setCommentToArticle" method="POST">
                    <p>
                        <textarea name="addComment" placeholder="Ajoutez un commentaire..." rows="8" cols="80" class="form-control" id="exampleFormControlTextarea1"></textarea>
                    </p>
                    <button type="submit" class="btn btn-outline-secondary">Valider</button>
                </form>
            <?php endif; ?>
        </details>
        </article>
    </div>
</section>

<?php
    $content = ob_get_clean();
    require_once "public/template.php";
?>
