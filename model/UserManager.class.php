<?php

    require_once "DbConnector.class.php";
    require_once "VerificationManager.class.php";
    
    /**
     * Cette classe servira à gérer les informations des utilisateurs.
     */
    class UserManager
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
        * Méthode qui ajoutera un nouvel utilisateur dans la base de données lors de son inscription.
        *
        * @param void
        * @return void
        */
        public function setNewUser()
        {
            $pseudo = $this->_verifManager->securisation($_POST["cr_pseudo"]);
            $pseudoExists = $this->_verifManager->verificationPseudo($pseudo);
            $name = $this->_verifManager->securisation($_POST["cr_name"]);
            $lastname = $this->_verifManager->securisation($_POST["cr_lastname"]);
            $mailAdress = $this->_verifManager->securisation($_POST["cr_mail"]);
            $mailExists = $this->_verifManager->verificationMail($mailAdress);
            $password = $this->_verifManager->securisation($_POST["cr_password"]);
            $password_verification = $this->_verifManager->securisation($_POST["cr_password_verification"]);
            $errors = [];
            
            if ($pseudoExists) { $errors["p_exists"] = "Ce pseudo est déjà utilisé !"; }
            elseif ($mailExists) { $errors["m_exists"] = "Cette adresse mail est déjà utilisée !"; }
            elseif ($password !== $password_verification) { $errors["missmatch_pwd"] = "Les mots de passe ne correspondent pas !"; }
            
            if(empty($errors))
            {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $sql = "INSERT INTO Users(pseudo, name, lastname, mail_adress, password) VALUES(?,?,?,?,?)";
                $req = $this->_dbCnx->insert($sql, [$pseudo, $name, $lastname, $mailAdress, $hashedPassword]);
                if ($req)
                {
                    $_SESSION["currentSessionPseudo"] = $pseudo;
                    $_SESSION["currentSessionMail"] = $mailAdress;
                    $sessionId = $this->_getIdFromUser($_SESSION["currentSessionMail"]);
                    $_SESSION["currentSessionId"] = $sessionId;
                }
            }
            else
            {
                $_SESSION["errors"] = $errors;
                header("Location: /index.php/page/createAccount");
                exit;
            }
        }
        
        /**
        * Méthode qui établira la connexion d'un utilisateur.
        *
        * @param void
        * @return void
        */
        public function setUserConnection()
        {
            $conMail = $this->_verifManager->securisation($_POST["conMail"]);
            $mailExists = $this->_verifManager->verificationMail($conMail);
            $conPassword = $this->_verifManager->securisation($_POST["conPassword"]);
            $connectErrors = [];
            if (!$mailExists)
            {
                $connectErrors["emptyFields"] = "Cette adresse mail n'est pas attribuée, veuillez vous inscrire !";
                $_SESSION["connectErrors"] = $connectErrors;
                header("Location: /index.php/page/connect");
                exit;
            }
            
            if (empty($connectErrors))
            {
                $sql = "SELECT user_id, pseudo, mail_adress, password, rights FROM Users WHERE mail_adress=?";
                $req = $this->_dbCnx->query($sql, [$conMail]);
                $result = $req->fetch();
                if (password_verify($conPassword, $result["password"]))
                {
                    $_SESSION["currentSessionId"] = $result["user_id"];
                    $_SESSION["currentSessionPseudo"] = $result["pseudo"];
                    $_SESSION["currentSessionMail"] = $conMail;
                    $_SESSION["currentSessionRights"] = $result["rights"];
                }
                else
                {
                    $connectErrors["wrongInfos"] = "Vous avez entré de mauvaises informations.";
                    $_SESSION["connectErrors"] = $connectErrors;
                    header("Location: /index.php/page/connect");
                    exit;
                }
            }
        }
        
        
        /*******************************
        * Statement of getter functions
        *******************************/
        
        /**
        * Méthode qui récupère certaines informations des utilisateurs inscrits.
        *
        * @param void
        * @return PDOStatement $req Renvoi les résultats bruts pour exploitation.
        */
        public function getAllUsers()
        {
            $sql = "SELECT user_id, pseudo FROM Users";
            $req = $this->_dbCnx->query($sql, []);
            return $req;
        }
        
        /**
        * Méthode qui récupère l'identifiant unique d'un utilisateur à partir de son adresse mail.
        *
        * @param string $mailAdress Adresse mail d'un utilisateur.
        * @return int $value["user_id"] Retourne l'identifiant unique d'un utilisateur.
        */
        private function _getIdFromUser(String $mailAdress)
        {
            $sql = "SELECT user_id FROM Users WHERE mail_adress=?";
            $req = $this->_dbCnx->query($sql, [$mailAdress]);
            $value = $req->fetch();
            return $value["user_id"];
        }
        
        /**
        * Méthode qui récupère le pseudo d'un utilisateur à partir de son adresse mail.
        *
        * @param string $mailAdress Adresse mail d'un utilisateur.
        * @return string $value["pseudo"] Retourne le pseudo de l'utilisateur.
        */
        public function getPseudoFromUser(String $mailAdress)
        {
            $sql = "SELECT pseudo FROM Users WHERE mail_adress=?";
            $req = $this->_dbCnx->query($sql, [$mailAdress]);
            $value = $req->fetch();
            return $value["pseudo"];
        }
        
        
        /*******************************
        * Statement of delete functions
        *******************************/
        
        /**
        * Méthode qui supprime un utilisateur à partir de son identifiant unique.
        *
        * @param int Identifiant unique de l'utilisateur.
        * @return void
        */
        public function deleteUserById(int $userId)
        {
            $sql = "DELETE FROM Users WHERE user_id=?";
            $req = $this->_dbCnx->delete($sql, [$userId]);
            if ($req === True) $_SESSION["deletedUser"] = "Utilisateur supprimé."; header("Location: ".$_SERVER["HTTP_REFERER"].""); exit;
        }
        
        
        /********************************
        * Statement of promote functions
        ********************************/
        
        /**
        * Méthode qui promouvoit un utilisateur à partir de son identifiant unique.
        * @param int $userId Identifiant unique de l'utilisateur.
        * @return void
        */
        public function promoteUserById(int $userId)
        {
            $sql = "UPDATE Users SET rights=2 WHERE user_id=?";
            $req = $this->_dbCnx->update($sql, [$userId]);
            if ($req === True) $_SESSION["promotedUser"] = "Utilisateur promu."; header("Location: ".$_SERVER["HTTP_REFERER"].""); exit;
        }
        
    }
