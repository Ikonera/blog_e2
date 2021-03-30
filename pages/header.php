<header>
    <div id="page_menu">
        <nav class="menu"> <!-- navigation principal du site -->
            <a href="/index.php/page/lastArticles" alt="Page d'accueil" title="Page d'accueil" class="menu">Accueil</a> |
            <a href="/index.php/page/<?php if(!empty($_SESSION["currentSessionId"])) echo "myProfile"; else echo "connect"; ?>" alt="Mon mur avec mes publications" title="Mon mur avec mes publications" class="menu">Mon profil</a> |
            <a href="/index.php/page/<?php if(!empty($_SESSION["currentSessionId"])) echo "postArticle"; else echo "connect"; ?>" alt="Publier une publication" title="Publier une publication" class="menu">Publier un article</a>
            <?php if ((isset($_SESSION["currentSessionRights"])) && ($_SESSION["currentSessionRights"] == 2)) : ?>
                | <a href="/index.php/admin" class="menu">Administration</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
