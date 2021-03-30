<?php

    require_once "DbConnector.class.php";
    require_once "VerificationManager.class.php";
    
    class ProfileManager
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
        * @var null $errors Une fois la classe instanciée, stockera un tableau des erreurs utilisateur.
        */
        public $errors;
        
        /**
        * Création des objets relatifs à la classe DbConnector et VerificationManager à l'instanciation de la classe.
        */
        function __construct()
        {
            $this->_dbCnx = new DbConnector;
            $this->_verifManager = new VerificationManager;
            $this->errors = [];
        }
        
        
        /********************************
        * Statement for update functions
        ********************************/
        
        /**
        * Méthode pour mettre à jour les informations de l'utilisateur suivant le formulaire envoyé.
        *
        * @param void
        * @return void
        */
        public function updateUserProfile()
        {
            if (isset($_POST["pseudoUpdate"]))
            {
                $this->_updateUserPseudo();
            }
            elseif (isset($_POST["mailUpdate"]))
            {
                $this->_updateUserMail();
            }
            elseif (isset($_POST["passwordUpdate"]))
            {
                $this->_updateUserPassword();
            }
        }
        
        /**
        * Méthode pour mettre à jour le pseudo de l'utilisateur.
        *
        * @param void
        * @return void
        */
        private function _updateUserPseudo()
        {
            $newPseudo = $this->_verifManager->securisation($_POST["edNewPseudo"]);
            if (empty($newPseudo))
            {
                $this->errors["unsuccess"] = "Si vous voulez changer votre pseudo, veuillez renseigner le champ correspondant !";
                $_SESSION["update"] = $this->errors;
                header("Location: /index.php/page/myProfile/edit");
                exit;
            }
            else {
                $pseudoExists = $this->_verifManager->verificationPseudo($newPseudo);
                if (!$pseudoExists)
                {
                    $sqlPseudoUpdate = "UPDATE users SET pseudo=? WHERE user_id=?";
                    $req = $this->_dbCnx->update($sqlPseudoUpdate, [$newPseudo, $_SESSION["currentSessionId"]]);
                    if ($req === True)
                    {
                        $_SESSION["currentSessionPseudo"] = $newPseudo;
                        $this->errors["success"] = "Votre pseudo à été changé avec succès !";
                        $_SESSION["update"] = $this->errors;
                        header("Location: /index.php/page/myProfile/edit");
                        exit;
                    }
                }
                else
                {
                    $this->errors["unsuccess"] = "Le pseudo renseigné est déjà pris !";
                    $_SESSION["update"] = $this->errors;
                    header("Location: /index.php/page/myProfile/edit");
                    exit;
                }
            }
        }
        
        /**
        * Méthode pour mettre à jour l'adresse mail de l'utilisateur.
        *
        * @param void
        * @return void
        */
        private function _updateUserMail()
        {
            $newMailAdress = $this->_verifManager->securisation($_POST["edMailAdress"]);
            if (empty($newMailAdress))
            {
                $this->errors["unsuccess"] = "Si vous voulez changer votre adresse mail, veuillez renseigner le champ correspondant !";
                $_SESSION["update"] = $this->errors;
                header("Location: /index.php/page/myProfile/edit");
                exit;
            }
            else {
                $mailExists = $this->_verifManager->verificationMail($newMailAdress);
                if (!$mailExists)
                {
                    $sqlMailUpdate = "UPDATE users SET email=? WHERE user_id=?";
                    $req = $this->_dbCnx->update($sqlMailUpdate, [$newMailAdress, $_SESSION["currentSessionId"]]);
                    if ($req === True)
                    {
                        $_SESSION["currentSessionMail"] = $newMailAdress;
                        $this->errors["success"] = "Votre adresse mail à été changée avec succès !";
                        $_SESSION["update"] = $this->errors;
                        header("Location: /index.php/page/myProfile/edit");
                        exit;
                    }
                }
                else
                {
                    $this->errors["unsuccess"] = "L'adresse mail renseignée est déjà prise !";
                    $_SESSION["update"] = $this->errors;
                    header("Location: /index.php/page/myProfile/edit");
                    exit;
                }
            }
        }
        
        /**
        * Méthode pour changer le mot de passe utilisateur.
        *
        * @param void
        * @return void
        */
        private function _updateUserPassword()
        {
            $oldPassword = $this->_verifManager->securisation($_POST["edOldPwd"]);
            $newPassword = $this->_verifManager->securisation($_POST["edNewPwd"]);
            $newPasswordVerif = $this->_verifManager->securisation($_POST["edNewPwdVerif"]);
            if ((empty($oldPassword)) || (empty($newPassword)) || (empty($newPasswordVerif)))
            {
                $this->errors["unsuccess"] = "Si vous voulez changer votre mot de passe, veuillez renseigner tous les champs coreespondant !";
                $_SESSION["update"] = $this->errors;
                header("Location: /index.php/page/myProfile/edit");
                exit;
            }
            else
            {
                $sqlCurrentPassword = "SELECT password FROM users WHERE user_id=?";
                $req = $this->_dbCnx->query($sqlCurrentPassword, [$_SESSION["currentSessionId"]]);
                $currentPassword = $req->fetch();
                if ((!password_verify($oldPassword, $currentPassword["password"])) || ($newPassword !== $newPasswordVerif))
                {
                    $this->errors["unsuccess"] = "Les mots de passe ne correspondent pas !";
                    $_SESSION["update"] = $this->errors;
                    header("Location: /index.php/page/myProfile/edit");
                    exit;
                }
                else
                {
                    $sqlPasswordUpdate = "UPDATE users SET password=? WHERE user_id=?";
                    $hashedPassword = password_hash($newPasswordVerif, PASSWORD_BCRYPT);
                    $req = $this->_dbCnx->update($sqlPasswordUpdate, [$hashedPassword, $_SESSION["currentSessionId"]]);
                    $this->errors["success"] = "Votre mot de passe à bien été changé !";
                    $_SESSION["update"] = $this->errors;
                    header("Location: /index.php/page/myProfile/edit");
                    exit;
                }
            }
        }
        
    }
    
