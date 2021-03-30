<?php

    require_once "DbConnector.class.php";
    require_once "VerificationManager.class.php";

    /**
     * Cette classe se chargera de la gestion des commentaires.
     */
    class CommentManager
    {
        /**
        * @var null $_dbCnx Une fois la classe instanciée, sera un objet de liaison à la base de données.
        */
        private $_dbCnx;
        
        /**
        * @var null $_verifManager Une fois la classe instanciée, sera un objet de la classe VerificationManager.
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
        * Statement of setter functions
        *******************************/
        
        /**
        * Méthode destinée à relier un commentaire à un article en particulier.
        *
        * @param int $articleId Identifiant unique de l'article.
        * @return void
        */
        public function setCommentToArticle(int $articleId)
        {
            $content = $this->_verifManager->securisation($_POST["addComment"]);
            $sql = "INSERT INTO comments(author, content, article_id, date) VALUES(?,?,?, NOW())";
            $req = $this->_dbCnx->insert($sql, [$_SESSION["currentSessionPseudo"], $content, $articleId]);
            if ($req === True) header("Location: ".$_SERVER["HTTP_REFERER"].""); exit;
        }
        
        
        /*******************************
        * Statement of getter functions
        *******************************/
        
        /**
        * Méthode qui retourne les commentaires par rapport à un article en particulier.
        *
        * @param int $articleId Identifiant unique de l'article.
        * @return PDOStatement $req Permet d'exploiter les résultats de la requête.
        */
        public function getCommentsByArticle(int $articleId)
        {
            $sql = "SELECT * FROM comments WHERE article_id=?";
            $req = $this->_dbCnx->query($sql, [$articleId]);
            return $req;
        }
        
        /**
        * Méthode qui retourne les informations d'un commentaire par rapport à son identifiant unique.
        *
        * @param int $commentId Identifiant unique du commentaire.
        * @return PDOStatement $req Permet d'exploiter les résultats de la requête.
        */
        public function getCommentInfosById(int $commentId)
        {
            $sql = "SELECT * FROM comments WHERE comment_id=?";
            $req = $this->_dbCnx->query($sql, [$commentId]);
            return $req;
        }
        
        
        /*******************************
        * Statement of update functions
        *******************************/
        
        /**
        * Méthode qui met à jour le contenu du commentaire par rapport à son identifiant unique.
        *
        * @param int $commentId Identifiant unique du commentaire.
        * @return void
        */
        public function updateComment(int $commentId)
        {
            $content = $this->_verifManager->securisation($_POST["editComment"]);
            $sql = "UPDATE comments SET content=? WHERE comment_id=?";
            $req = $this->_dbCnx->update($sql, [$content, $commentId]);
        }
        
        
        /*******************************
        * Statement of delete functions
        *******************************/
        
        /**
        * Méthode qui supprime commentaire par rapport à son identifiant unique.
        *
        * @param int $commentId Identifiant unique du commentaire.
        * @return void
        */
        public function deleteComment(int $commentId)
        {
            $sql = "DELETE FROM comments WHERE comment_id=?";
            $req = $this->_dbCnx->delete($sql, [$commentId]);
            if ($req) header("Location: ".$_SERVER["HTTP_REFERER"].""); exit;
        }
        
    }
    
