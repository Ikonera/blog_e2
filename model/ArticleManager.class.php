<?php

    require_once "DbConnector.class.php";
    require_once "VerificationManager.class.php";

    /**
     * Cette classe servira de gestionnaire des articles publiés.
     */
    class ArticleManager
    {
        /**
        * @var object $_dbCnx Une fois la classe instanciée, sera un objet de liaison à la base de données.
        */
        private $_dbCnx;
        
        /**
        * @var object $_verifManager Une fois la classe instanciée, sera un objet de la classe VerificationManager.
        */
        private $_verifManager;
        
        /**
        * Création des objets relatifs à la classe DbConnector et VerificationManager à l'instanciation de la classe.
        */
        function __construct()
        {
            $this->_dbCnx = new DbConnector;
            $this->_verifManager = new VerificationManager;
        }
        
        
        /*******************************
        * Statement of getter functions
        *******************************/
        
        /**
        * Méthode qui récupère tous les articles ayant été postés.
        *
        * @param void
        * @return PDOStatement Retourne un objet exploitable.
        */
        public function getArticles()
        {
            $sql = "SELECT * FROM articles";
            $req = $this->_dbCnx->query($sql, []);
            return $req;
        }
        
        /**
        * Méthode qui récupère les articles postés par l'utilisateur courant.
        *
        * @param void
        * @return PDOStatement Retourne un objet exploitable.
        */
        public function getArticlesFromUser()
        {
            $sql = "SELECT * FROM articles WHERE author=?";
            $req = $this->_dbCnx->query($sql, [$_SESSION["currentSessionPseudo"]]);
            return $req;
        }
        
        /**
        * Méthode qui récupère les informations d'un article à partir de son identifiant unique pour modification.
        *
        * @param int $articleId Identification unique de l'article.
        * @return PDOStatement Retourne un objet exploitable.
        */
        public function getArticleInfosForEdit(int $articleId)
        {
            $sql = "SELECT title, description, content, keywords FROM articles WHERE article_id=?";
            $req = $this->_dbCnx->query($sql, [$articleId]);
            return $req;
        }
        
        /**
        * Méthode qui récupère les informations d'un article à partir de son identifiant unique.
        *
        * @param int $articleId Identifiant unique de l'article.
        * @return PDOStatement Retourne un objet exploitable.
        */
        public function getArticleViewById(int $articleId)
        {
            $sql = "SELECT * FROM articles WHERE article_id=?";
            $req = $this->_dbCnx->query($sql, [$articleId]);
            return $req;
        }
        
        
        /*
        * Statement of setter functions
        */
        
        /**
        * Méthode qui injecte un nouvel article dans la base de données.
        *
        * @param void
        * @return void
        */
        public function setNewArticle()
        {
            $title = $this->_verifManager->securisation($_POST["art_title"]);
            $description = $this->_verifManager->securisation($_POST["art_description"]);
            $content = $this->_verifManager->securisation($_POST["art_content"]);
            $article_author_pseudo = $_SESSION["currentSessionPseudo"];
            $categoryId = $this->_verifManager->securisation($_POST["art_cat"]);
            $keywords = $this->_verifManager->securisation($_POST["art_keywords"]);

            $sql = "INSERT INTO articles(title, description, content, author, category, keywords, date) VALUES(?,?,?,?,?,?, NOW())";
            $req = $this->_dbCnx->insert($sql, [$title, $description, $content, $article_author_pseudo, $categoryId, $keywords]);
        }
        
        
        /*
        * Statement of update functions
        */
        
        /**
        * Méthode qui met à jour les informations d'un article à partir de son identifiant unique dans la base de données.
        *
        * @param int $articleId Idnetifiant unique de l'article.
        * @return void
        */
        public function updateArticleInfos(int $articleId)
        {
            $title = $this->_verifManager->securisation($_POST["ed_title"]);
            $description = $this->_verifManager->securisation($_POST["ed_description"]);
            $content = $this->_verifManager->securisation($_POST["ed_content"]);
            $keywords = $this->_verifManager->securisation($_POST["ed_keywords"]);
            // $image = $this->_verifManager->securisation($ed_image);
            $sql = "UPDATE articles SET title=?, description=?, content=?, keywords=? WHERE article_id=?";
            $req = $this->_dbCnx->update($sql, [$title, $description, $content, $keywords, $articleId]);
        }
        
        
        /*
        * Statement of delete functions
        */
        
        /**
        * Méthode qui supprime un article à partir de son identifiant unique.
        *
        * @param int $articleId Identifiant unqiue de l'article.
        * @return void
        */
        public function deleteArticle(int $articleId)
        {
            $sql = "DELETE FROM articles WHERE article_id=?";
            $req = $this->_dbCnx->delete($sql, [$articleId]);
            
            header("Location: ".$_SERVER["HTTP_REFERER"]."");
            exit;
        }
        
    }
    
