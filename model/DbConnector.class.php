<?php

    /**
     * Cette classe permettra le lien entre le site et la base de données.
     */
    class DbConnector
    {
        /**
        * @var string $_host Hôte de la base de données.
        */
        private $_host;
        
        /**
        * @var string $_user informations de connexion à la base de données.
        */
        private $_user;
        
        /**
        * @var string $_pwd informations de connexion à la base de données.
        */
        private $_pwd;
        
        /**
        * @var string $_base Nom de la base de données.
        */
        private $_base;
        
        /**
        * @var string $_dsn Initialisation de connection à la base de données.
        */
        private $_dsn;
        
        /**
        * Assignation des informations de connexion à la base de données dès l'instanciation de la classe.
        */
        function __construct()
        {
            $this->_host = "localhost";
            $this->_user = "root";
            $this->_pwd = "";
            $this->_base = "blog_e2";
            $this->_dsn = "mysql:dbname=".$this->_base.";host=".$this->_host.";";
        }
        
        /**
        * Méthode de récupération du lien à la base de données pour interagir avec elle.
        */
        private function _dbConnect()
        {
            try
            {
                $db = new PDO($this->_dsn, $this->_user, $this->_pwd);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $db;
            }
            catch (PDOExecpetion $e)
            {
                echo "PDO connexion error : ".$e->getMessage();
            }
        }
        
        /**
        * Méthode de récupération d'occurences dans la base de données.
        *
        * La méthode traîte la requête comme requête préparée par défaut,
        * $args peut être vide si la requête SQL le permet.
        *
        * @param string $sql Requête SQL vers la base de données.
        * @param array $args Tableau contenant les marqueurs de position. Laisser vide si la requête SQL le permet.
        * @return object $stmt Retourne un objet exploitable.
        */
        public function query(String $sql, array $args)
        {
            $stmt = $this->_dbConnect()->prepare($sql);
            $req = $stmt->execute($args);
            return (!$req) ? $this->dbConnect()->errorCode() : $stmt ;
        }
        
        /**
        * Méthode de récupération d'occurences dans la base de données.
        *
        * La méthode traîte la requête comme requête préparée par défaut,
        * $args peut être vide si la requête SQL le permet.
        *
        * @param string $sql Requête SQL vers la base de données.
        * @param array $args Tableau contenant les marqueurs de position. Laisser vide si la requête SQL le permet.
        * @return mixed ...->errorCode() Retourne le code erreur SQLState si une erreur survient, retourne True sinon.
        */
        public function insert(String $sql, array $args)
        {
            $stmt = $this->_dbConnect()->prepare($sql);
            $req = $stmt->execute($args);
            return (!$req) ? $this->dbConnect()->errorCode() : True ;
        }
        
        /**
        * Méthode de récupération d'occurences dans la base de données.
        *
        * La méthode traîte la requête comme requête préparée par défaut,
        * $args peut être vide si la requête SQL le permet.
        *
        * @param string $sql Requête SQL vers la base de données.
        * @param array $args Tableau contenant les marqueurs de position. Laisser vide si la requête SQL le permet.
        * @return mixed ...->errorCode() Retourne le code erreur SQLState si une erreur survient, retourne True sinon.
        */
        public function update(String $sql, array $args)
        {
            $stmt = $this->_dbConnect()->prepare($sql);
            $req = $stmt->execute($args);
            return (!$req) ? $this->dbConnect()->errorCode() : True ;
        }
        
        /**
        * Méthode de récupération d'occurences dans la base de données.
        *
        * La méthode traîte la requête comme requête préparée par défaut,
        * $args peut être vide si la requête SQL le permet.
        *
        * @param string $sql Requête SQL vers la base de données.
        * @param array $args Tableau contenant les marqueurs de position. Laisser vide si la requête SQL le permet.
        * @return mixed ...->errorCode() Retourne le code erreur SQLState si une erreur survient, retourne True sinon.
        */
        public function delete(String $sql, array $args)
        {
            $stmt = $this->_dbConnect()->prepare($sql);
            $req = $stmt->execute($args);
            return (!$req) ? $this->dbConnect()->errorCode() : True ;
        }
        
    }
    
