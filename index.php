<?php

    session_start();
    define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
    $pathUrl = $_SERVER["REQUEST_URI"];
    require_once "controller/GlobalController.php";
    if (isset($_SESSION["type"]))
    {
        echo $_SESSION["type"];
    }
    
    if ($pathUrl == "/index.php/page/lastArticles")
    {
        listArticles();
    }
    elseif ($pathUrl == "/index.php/page/connect")
    {
        userConnect();
    }
    elseif ($pathUrl == "/index.php/page/createAccount")
    {
        createAccount();
    }
    elseif ($pathUrl == "/index.php/process/createUser")
    {
        createNewUser();
    }
    elseif ($pathUrl == "/index.php/page/myProfile")
    {
        unset($_SESSION["articleId"]);
        myProfile();
    }
    elseif ($pathUrl == "/index.php/page/myProfile/edit")
    {
        editProfile();
    }
    elseif($pathUrl == "/index.php/process/updateProfile")
    {
        updateProfile();
    }
    elseif ($pathUrl == "/index.php/process/disconnectUser")
    {
        disconnectUser();
    }
    elseif ($pathUrl == "/index.php/process/userConnection")
    {
        userConnection();
    }
    elseif ($pathUrl == "/index.php/page/postArticle")
    {
        postArticle();
    }
    elseif ($pathUrl == "/index.php/process/setNewArticle")
    {
        setNewArticle(); 
    }
    elseif (isset($_GET["article-edition"]))
    {
        $_SESSION["articleId"] = $_GET["article-edition"];
        editArticle($_SESSION["articleId"]);
    }
    elseif ($pathUrl == "/index.php/process/updateArticle")
    {
        updateArticle($_SESSION["articleId"]);
        unset($_SESSION["articleId"]);
    }
    elseif (isset($_GET["article-view"]))
    {
        $_SESSION["articleId"] = $_GET["article-view"];
        articleView($_SESSION["articleId"]);
    }
    elseif ($pathUrl == "/index.php/process/setCommentToArticle")
    {
        setCommentToArticleId($_SESSION["articleId"]);
        unset($_SESSION["articleId"]);
    }
    elseif (isset($_GET["delete-comment"]))
    {
        deleteCommentById($_GET["delete-comment"]);
    }
    elseif (isset($_GET["comment-edition"]))
    {
        editCommentById($_GET["comment-edition"], $_GET["article"]);
    }
    elseif ($pathUrl == "/index.php/process/updateComment")
    {
        updateCommentById($_SESSION["commentId"]);
    }
    elseif (isset($_GET["delete-article"]))
    {
        deleteArticleById($_GET["delete-article"]);
    }
    elseif ($pathUrl == "/index.php/admin")
    {
        adminPanel();
    }
    elseif ($pathUrl == "/index.php/admin/promoteUser")
    {
        promoteUser($_POST["promoteUser"]);
    }
    elseif ($pathUrl == "/index.php/admin/deleteUser")
    {
        deleteUser($_POST["deleteUser"]);
    }
    elseif ($pathUrl == "/index.php/admin/setNewCategory")
    {
        setCategory($_POST["newCategoryName"]);
    }

    else
    {
        listArticles();
    }
