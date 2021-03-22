<?php

    require_once "DbConnector.class.php";
    require_once "VerificationManager.class.php";

    /**
     * Cette classe fera la gestion des catégories.
     */
    class CategoriesManager
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
        * Méthode pour créer une nouvelle catégorie sur le site.
        *
        * @param string $categoryName Nom de la nouvelle catégorie.
        * @return void
        */
        public function setNewCategory(String $categoryName)
        {
            $categoryName = $this->_verifManager->securisation($categoryName);
            $sql = "INSERT INTO Categories(name) VALUES(?)";
            $req = $this->_dbCnx->insert($sql, [$categoryName]);
            if ($req === True) $_SESSION["newCategorySet"] = "Catégorie ajoutée !"; header("Location: ".$_SERVER["HTTP_REFERER"].""); exit;
        }
        
        
        /*******************************
        * Statement of getter functions
        *******************************/
        
        /**
        * Méthode des informations de chaque catégorie.
        *
        * @param void
        * @return PDOStatement Objet exploitable.
        */
        public function getCategories()
        {
            $sql = "SELECT * FROM Categories ORDER BY category_id ASC";
            $req = $this->_dbCnx->query($sql, []);
            return $req;
        }
        
        
        /*******************************
        * Statement of delete functions
        *******************************/
        
        /**
        * Méthode de suppression d'une catégorie à partir de son identifiant unique.
        *
        * @param int $categoryId Identifiant unique de la catégorie.
        * @return void
        */
        public function deleteCategory(int $categoryId)
        {
            $deletedCategory = $this->_verifManager->securisation($categoryId);
            $sql = "DELETE FROM Categories WHERE category_id=?";
            $req = $this->_dbCnx->delete($sql, [$deletedCategory]);
            if ($req) $_SESSION["deletedCategory"] = "Catégorie supprimée !"; header("Location: ".$_SERVER["HTTP_REFERER"].""); exit;
        }
        
    }
    
