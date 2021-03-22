<?php
    ob_start();
    $title = "Editer un commentaire -";
?>

<?php
    $articleTitle = $articleInfo->fetch();
    $commentContent = $commentInfo->fetch();
    $_SESSION["commentId"] = $commentContent["comment_id"];
?>

<section>
    <h2 class="centre">Editer un commentaire de l'article : <?= $articleTitle["title"]; ?></h2>
    <form action="/index.php/process/updateComment" method="POST" id="modifCom">
        <textarea name="editComment" rows="8" cols="80" class="form-control" id="exampleFormControlTextarea1"><?= $commentContent["content"]; ?></textarea>
        <p>
            <button type="submit" class="btn btn-outline-secondary">Valider</button>
        </p>
    </form>
</section>

<?php
    $content = ob_get_clean();
    require_once "public/template.php";
?>
