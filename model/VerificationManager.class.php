<?php

    require_once "DbConnector.class.php";

    /**
     * Cette classe servira à sécuriser ou à vérifier la présence des données reçues.
     */
    class VerificationManager
    {
        /**
        * @var null $_dbCnx Une fois la classe instanciée, sera un objet de liaison à la base de données.
        */
        private $_dbCnx;
        
        /**
        * Création de l'objet relatif à la classe DbConnector à l'instanciation de la classe.
        */
        function __construct()
        {
            $this->_dbCnx = new DbConnector;
        }
        
        /*********************************
        * Sécurisation des données reçues
        *********************************/
        
        /**
        * Méthode de sécurisation d'une donnée reçue.
        *
        * @param mixed $data Donnée à sécuriser.
        * @return mixed $data Donnée sécurisée.
        */
        public function securisation(String $data)
        {
            $data = htmlspecialchars($data);
            $data = stripslashes($data);
            $data = trim($data);
            $data = strip_tags($data);
            return $data;
        }
        
        /************************************************
        * Vérification du pseudo dans la base de données
        ************************************************/
        
        /**
        * Méthode de vérification de la présence de l'occurence du pseudo dans la base de données.
        *
        * @param string $pseudo Pseudo entré par l'utilisateur.
        * @return bool True Si la valeur est trouvée dans la base de données, False si elle n'est pas présente.
        */
        public function verificationPseudo(String $pseudo)
        {
            $sql = "SELECT pseudo FROM users WHERE pseudo=?";
            $req = $this->_dbCnx->query($sql, [$pseudo]);
            return $req->rowCount() == 0 ? False : True ;
        }
        
        /********************************************************
        * Vérification de l'adresse mail dans la base de données
        ********************************************************/
        
        /**
        * Méthode de vérification de l'occurene de l'adresse mail dans la base de données.
        *
        * @param string $mailAdress Adresse mail entrée par l'utilisateur.
        * @return bool True Si la valeur est trouvée dans la base de données, False si elle n'est pas présente.
        */
        public function verificationMail(String $mailAdress)
        {
            $sql = "SELECT user_id FROM users WHERE email=?";
            $req = $this->_dbCnx->query($sql, [$mailAdress]);
            return $req->rowCount() == 0 ? False : True ;
        }
    }
    
