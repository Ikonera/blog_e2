<?php
    
    require_once "public/functions/functions.php";

    /*********************************************
    *   Import des classes qui nous serviront ici
    *********************************************/
    require_once "model/ArticleManager.class.php";
    require_once "model/CommentManager.class.php";
    require_once "model/UserManager.class.php";
    require_once "model/CategoriesManager.class.php";
    require_once "model/ProfileManager.class.php";
    
    /********************************************
    *   Fonctions qui redirigeront l'utilisateur
    ********************************************/
    
    /**
    * Fonction qui redirigera l'utilisateur vers la page de connection.
    *
    * @param void
    * @return void
    */
    function userConnect()
    {
        require_once "pages/connect.php";
    }
    
    /**
    * Fonction qui instancie la classe UserManager et permet la connexion d'un utilisateur.
    *
    * @param void
    * @return void
    */
    function userConnection()
    {
        $userManager = new UserManager;
        $userManager->setUserConnection();
        
        header("Location: /index.php/page/myProfile");
        exit;
    }
    
    /**
    * Fonction qui redirigera l'utilisateur vers la page de création d'un compte.
    *
    * @param void
    * @return void
    */
    function createAccount()
    {
        require_once "pages/createAccount.php";
    }
    
    /**
    * Fonction qui instancie les classes UserManager, ArticleManager et permet la création d'un nouvel utilisateur dans la base de données.
    *
    * Redirige l'utilisateur nouvellement inscrit vers son profil.
    *
    * @param void
    * @return void
    */
    function createNewUser()
    {
        $userManager = new UserManager;
        $userManager->setNewUser();
        $articleManager = new ArticleManager;
        $posts = $articleManager->getArticlesFromUser();
        
        header("Location: /index.php/page/myProfile");
        exit;
    }
    
    /**
    * Fonction qui instancie la classe ArticleManager, récupère les articles publiés par l'utilisateur courant s'il y en a.
    *
    * Redirige l'utilisateur vers son profil.
    *
    * @param void
    * @return void
    */
    function myProfile()
    {
        $articleManager = new ArticleManager;
        $posts = $articleManager->getArticlesFromUser();
        
        require_once "pages/myWall.php";
    }
    
    /**
    * Fonction qui redirige l'utilisateur vers la page d'édition de son profil.
    *
    * @param void
    * @return void 
    */
    function editProfile()
    {
        require_once 'pages/edit_profile.php';
    }
    
    /**
    * Fonction qui instancie la classe ProfileManager et redirige l'utilisateur vers la page de processus de mise à jour de son profil.
    *
    * @param void
    * @return void 
    */
    function updateProfile()
    {
        $profileManager = new ProfileManager;
        $profileManager->updateUserProfile();
        
        header("Location: /index.php/page/myProfile/edit");
        exit;
    }

    /**
    * Fonction qui détruit la session de l'utilisateur courant et le redirige vers la page des articles publiés.
    *
    * @param void
    * @return void
    */
    function disconnectUser()
    {
        session_destroy();
        
        header("Location: /index.php/page/lastArticles");
        exit;
    }
    
    /**
    * Fonction qui instancie la classe CategoriesManager et permet la récupération des noms de catégories existantes.
    *
    * @param void
    * @return void
    */
    function postArticle()
    {
        $categoriesManager = new CategoriesManager;
        $date = get_date();
        $categories = $categoriesManager->getCategories();
        
        require_once "pages/add_publication.php";
    }
    
    /**
    * Fonction qui instancie la classe ArticleManager et permet la création d'un nouvel article.
    *
    * @param void
    * @return void
    */
    function setNewArticle()
    {
        $articleManager = new ArticleManager;
        // DEBUG: var_dump($_POST);
        $articleManager->setNewArticle();
        header("Location: /index.php/page/myProfile");
        exit;
    }
    
    /**
    * Fonction qui instancie les classes CategoriesManager, ArticleManager et permet l'édition d'un article.
    *
    * @param int $articleId Identifiant unique de l'article.
    * @return void
    */
    function editArticle(int $articleId)
    {
        $date = get_date();
        $categoriesManager = new CategoriesManager;
        $categories = $categoriesManager->getCategories();
        $articleManager = new ArticleManager;
        $editInfos = $articleManager->getArticleInfosForEdit($articleId);
        
        require_once "pages/edit_publication.php";
    }
    
    /**
    * Fonction qui instancie la classe ArticleManager et permet la mise à jour d'un article.
    *
    * @param void
    * @return void
    */
    function updateArticle()
    {
        $articleManager = new ArticleManager;
        $articleManager->updateArticleInfos($_SESSION["articleId"]);
        unset($_SESSION["articleId"]);
        
        header("Location: /index.php/page/myProfile");
        exit;
    }
    
    /**
    * Fonction qui instancie les classes ArticleManager, CommentManager et permet des voir un article rédigé.
    *
    * @param int $articleId Identifiant unique de l'article.
    * @return void
    */
    function articleView(int $articleId)
    {
        $articleManager = new ArticleManager;
        $commentManager = new CommentManager;
        $viewArticle = $articleManager->getArticleViewById($articleId);
        $comments = $commentManager->getCommentsByArticle($articleId);
        
        require_once "pages/view_article.php";
    }
    
    /**
    * Fonction qui instancie la classe CommentManager et permet la rédaction d'un commentaire par rapport à un article.
    *
    * @param int $articleId Identifiant unique de l'article.
    * @return void
    */
    function setCommentToArticleId(int $articleId)
    {
        $commentManager = new CommentManager;
        
        $commentManager->setCommentToArticle($articleId);
        unset($_SESSION["articleId"]);
    }
    
    /**
    * Fonction qui instancie les classes ArticleManager, CommentManager et permet l'édition d'un commentaire par rapport à un article.
    *
    * @param int $commentId Identifiant unique du commentaire.
    * @param int $articleId Identifiant unique de l'article.
    * @return void
    */
    function editCommentById(int $commentId, int $articleId)
    {
        $articleManager = new ArticleManager;
        $commentManager = new CommentManager;
        $articleInfo = $articleManager->getArticleInfosForEdit($articleId);
        $commentInfo = $commentManager->getCommentInfosById($commentId);
        
        require_once "pages/edit_comment.php";
    }
    
    /**
    * Fonction qui instancie la classe CommentManager et permet la mise à jour d'un commentaire à partir de son identifiant unique.
    *
    * @param int $commentId Identifiant unique du commentaire.
    * @return void
    */
    function updateCommentById(int $commentId)
    {
        $commentManager = new CommentManager;
        
        $commentManager->updateComment($commentId);
        unset( $_SESSION["commentId"]);
        header("Location: /index.php/page/article?article-view=".$_SESSION["articleId"]."");
        unset($_SESSION["articleId"]);
        exit;
    }
    
    /**
    * Fonction qui instancie la classe CommentManager et permet la suppression d'un commentaire à partir de son identifiant unique.
    *
    * @param int $commentId Identifiant unique du commentaire.
    * @return void
    */
    function deleteCommentById(int $commentId)
    {
        $commentManager = new CommentManager;
        $commentManager->deleteComment($commentId);
    }
    
    /**
    * Fonction qui instancie la classe ArticleManager et permet la suppression d'un article à partir de son identifiant unique.
    *
    * @param int $articleId Identifiant unique de l'article.
    * @return void
    */
    function deleteArticleById(int $articleId)
    {
        $articleManager = new ArticleManager;
        $articleManager->deleteArticle($articleId);
    }
    
    /**
    * Fonction qui instancie les classes UserManager, CategoriesManager et permet la redirection vers la page d'administration.
    *
    * @param void
    * @return void
    */
    function adminPanel()
    {
        $userManager = new UserManager;
        $categoriesManager = new CategoriesManager;
        $promoteUsers = $userManager->getAllUsers();
        $deleteUsers = $userManager->getAllUsers();
        $categories = $categoriesManager->getCategories();
        
        require_once "pages/adminPanel.php";
    }
    
    /**
    * Fonction qui instancie la classe UserManager et permet de promouvoir un utilisateur en tant qu'administrateur.
    *
    * @param int $userId Identifiant unique de l'utilisateur.
    * @return void
    */
    function promoteUser(int $userId)
    {
        $userManager = new UserManager;
        
        $userManager->promoteUserById($userId);
    }
    
    /**
    * Fonction qui instancie la classe UserManager et permet la suppression d'un utilisateur à partir de son identifiant unique.
    *
    * @param int $userId Identifiant unique de l'utilisateur.
    * @return void
    */
    function deleteUser(int $userId)
    {
        $userManager = new UserManager;
        
        $userManager->deleteUserById($userId);
    }
    
    /**
    * Fonction qui instancie la classe CategoriesManager et permet de créer une nouvelle catégorie.
    *
    * @param string $categoryName Nom de la nouvelle catégorie.
    * @return void
    */
    function setCategory(String $categoryName)
    {
        $categoriesManager = new CategoriesManager;
        
        $categoriesManager->setNewCategory($categoryName);
    }
    
    /**
    * Fonction qui instancie les classes ArticleManager, CommentManager. Elle est appelée par défaut si l'URI demandée n'est pas connue.
    *
    * @param void
    * @return void
    */
    function listArticles()
    {
        
        $articleManager = new ArticleManager;
        $commentManager = new CommentManager;
        $articles = $articleManager->getArticles();
        
        require_once "pages/Home.php";
    }
