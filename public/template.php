<!DOCTYPE html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title; ?></title>
        <meta name="description" content="Site de devoir sur le PHP" />
        <meta name="keywords" content="devoir PHP, article, note" />
        <meta name="author" content="Chloé STIZI" />
        <link rel="icon" type="image/png" href="favicon.png" />
        <link rel="stylesheet" type="text/css" media="screen" href=<?php ROOT ?>"/public/css/style.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src=<?php ROOT ?>"/public/js/research.js"></script>
    </head>
    <body>
        <section id="main">
        <?php require_once ROOT."/pages/header.php"; ?>
        
        <?= $content; ?>
        
        </section>
        
        <?php require_once ROOT."/pages/footer.html"; ?>
        
    </body>
</html>
