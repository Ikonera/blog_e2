<?php
    ob_start();
    $title = "Une erreur est survenue...";
?>

<section>
    <div>
        <p><?= $_SESSION["error"]; ?></p>
    </div>
</section>

<?php
    $content = ob_get_clean();
    require_once "public/template.php";
?>
