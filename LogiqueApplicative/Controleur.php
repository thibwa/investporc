<?php
    require_once ('metier/Email.php');
    require_once ('metier/Captcha.php');
    require_once ('metier/Membre.php');
    require_once ('metier/Groupe.php');
    require_once ('metier/ForeignPassword.php');
    require_once ('metier/DefaultValue.php');
    require_once ('metier/Reponse.php');
    require_once ('metier/Businessplan.php');
    //-------------------------------------------------
    require_once ('dao/DaoMembre.php');
    require_once ('dao/DaoGroupe.php');
    require_once ('dao/DaoForeignPassword.php');
    require_once ('dao/DaoDefaultValue.php');
    require_once ('dao/DaoCalcul.php');
    require_once ('dao/DaoReponse.php');
    require_once ('dao/DaoBusinessPlan.php');
    //-------------------------------------------------
    
    class Controleur {
        private $connexion;
        private $daoMembre;
        private $daoGroupe;
        private $daoForeignPassword;
        private $daoDefaultValue;
        private $daoCalcul;
        private $daoReponse;
        private $daoBusinessPlan;
        //----------------------------------

        function __construct()
        {
            $this->connexionBD();
            
            $this->daoMembre = new DaoMembre($this->connexion);
            $this->daoGroupe = new DaoGroupe($this->connexion);
            $this->daoForeignPassword = new DaoForeignPassword($this->connexion);
            $this->daoDefaultValue = new DaoDefaultValue($this->connexion);
            $this->daoCalcul = new DaoCalcul($this->connexion);
            $this->daoReponse = new DaoReponse($this->connexion);
            $this->daoBusinessPlan = new DaoBusinessPlan($this->connexion);
        }
        
        /*
         * Permet la connexion à la base de données en utilisant
         * un objet de type PDO
         */
        private function connexionBD()
        {
            try
            {
                $this->connexion = new PDO('mysql:host='.$this->PARAM_hote.';dbname='.$this->PARAM_nom_bd, $this->PARAM_utilisateur, $this->PARAM_mot_passe);
                $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connexion->exec("SET CHARACTER SET utf8");
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_connexion: '.$e->getMessage());
                die();
            }
        }

        /*
         * Permet l'inscription d'un membre dans la base de données
         * Un mail lui sera envoyé
         */
        public function ajouterMembre($nom, $email, $motDePasse)
        {
            //Test de la longueur des champs
            if(!$this->maxLength($nom, 200) && !$this->maxLength($email, 200) && !$this->maxLength($motDePasse, 64))
                return false;
            
            /* Début d'une transaction, désactivation du mode autocommit */
            $this->connexion->beginTransaction();
            
            $m = new Membre($nom, $email, $motDePasse);
            
            try
            {
                if($this->daoMembre->create($m));
                {
                    $this->connexion->commit();
                    
                    $s = '"InvestPorc" vous souhaite la bienvenue.<br/>';
                    $s .= 'Connectez avec votre adresse email: '.$m->getEmail();
                    $s .= ' pour profiter des avantages en tant que membre de notre outil.';
                    
                    $email = new Email($m, $s, 1);   

                    if(!$email->envoyer()) throw new Exception;
                    
                    return true;
                }
            }
            catch (PDOException $e)
            {
                $this->insertInLog('Erreur_insertion: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return false;
            }
            catch(Exception $e)
            {
                $this->insertInLog('Erreur_insertion_Envoi_Mail: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return false;
            }
        }
        
        /*
         * Permet à un utilisateur identifié par son adresse email
         * de récupérer son mot de passe.
         * Un mail lui sera envoyé pour réinitialiser son mot de passe
         */
        public function recupererMotDePasse($email)
        {      
            //Test de la longueur des champs
            if(!$this->maxLength($email, 200))
                    return false;
            
            try
            {
                /* Début d'une transaction, désactivation du mode autocommit */
                $this->connexion->beginTransaction();
            
                $m = $this->daoMembre->findEmail($email);
                
                if($m)
                {
                    $fpwd = new ForeignPassword($m, $this->genererCle());
                 
            
                    if($this->daoForeignPassword->create($fpwd))
                    {
                        $this->connexion->commit();
                        
                        $s = 'Pour réinitialiser votre adresse email: '.$m->getEmail();
                        // TODO UPDATE LINK !!!
                        $s .= '<br/> Allez à cette adresse <a href=\"http://investporc.cra.wallonie.be/index.php?p=recover&email='.$fpwd->getMembre()->getEmail().'&key='.$fpwd->getKeygen();
                        $s .= '/>http://investporc.cra.wallonie.be/index.php?p=recover&email='.$fpwd->getMembre()->getEmail().'&key='.$fpwd->getKeygen().'</a>';
                        $s .= '<br /><br />Attention, cette adresse n\'est valide que 30 minutes, après quoi vous devrez recommencer votre manipulation ';
                        $s .= 'de réinitialisation de votre mot de passe.';
                        
                        $email = new Email($m, $s, 1);
                        
                        if(!$email->envoyer()) throw new Exception;
                        
                        return true;
                    }
                }
                else
                    return false;
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_récupération_MDP: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return false;
            }
            catch(Exception $e)
            {
                $this->insertInLog('Erreur_récupération_MDP_Envoi_Mail: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return false;
            }
        }
        
        /*
         * Permet de réinitialiser le mot de passe d'un membre
         * identifié par son adresse email, une clé aléatoire
         */
        public function reinitialiserMotDePasse($email, $key, $motDePasse)
        {
            //Test de la longueur des champs
            if(!$this->maxLength($email, 200))
                    return false;
            
            /* Début d'une transaction, désactivation du mode autocommit */
            $this->connexion->beginTransaction();
             
            try
            {
                $fpwd = $this->daoForeignPassword->find($key);

                if($fpwd)
                {
                    $m = $fpwd->getMembre();
                    $m->setMotDePasse($motDePasse);
                    $fpwd->setMembre($m);
                    
                    if($this->daoMembre->update($fpwd->getMembre(), $email))
                    {
                        if($this->daoForeignPassword->delete($fpwd))
                        {
                            $this->connexion->commit();
                            
                            $s = 'Votre mot de passe a bien été réinitialisé. <br /> Dès à présent, vous pouvez vous connecter avec votre nouveau mot de passe';
                            $email = new Email($fpwd->getMembre(), $s, 1);   
                            
                            if(!$email->envoyer()) throw new Exception;
                            
                            return true;
                        }
                    }
                    else
                        return false;
                }
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_réinitialisation_MDP: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return false;
            }
            catch(Exception $e)
            {
                $this->insertInLog('Erreur_réinitialisation_MDP_Envoi_Mail: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return false;
            }
        }

        /*
         * Permet à un utlisateur enregistré de se connecter sur l'outil
         */
        public function connexionMembre($email, $motDePasse)
        {
            //Test de la longueur des champs
            if(!$this->maxLength($email, 200))
                return false;
            
            try
            {
                $m = $this->daoMembre->find($email, $motDePasse);

                if($m)
                {
                    $_SESSION['InvestPorc'] = serialize($m);
                    return true;
                }
                
                return false;
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_connexion: '.$e->getMessage());
                return false;
            }
        }
        
        /*
         * Permet à un utilisateur de mettre à jour ses informations
         */
        public function updateInfoUser($nom, $motdepasse, $email)
        {        
            //Test de la longueur des champs
            if(!$this->maxLength($nom, 200) && !$this->maxLength($email, 200))
                    return false;
            
            /* Début d'une transaction, désactivation du mode autocommit */
            $this->connexion->beginTransaction();
             
            try
            {
                $emailN = $this->user('email');
                
                $m = $this->daoMembre->findEmail($emailN);
                
                if($m)
                {
                    if($nom != null)
                        $m->setNomPrenom($nom);

                    if($email != null)
                        $m->setEmail($email);

                    if($motdepasse != null)
                        $m->setMotDePasse($motdepasse);
                    
                    if($this->daoMembre->update($m, $emailN))
                    {
                        $this->connexion->commit();
                        
                        $_SESSION['InvestPorc'] = serialize($m);
                        return true;
                    }
                }
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_updateInfoUser: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return false;
            }
        }
        
        /*
         * Permet à un utilisateur de se désinscrire de l'outil
         */
        public function desinscription($email)
        {
            //Test de la longueur des champs
            if(!$this->maxLength($email, 200))
                    return false;
            
            /* Début d'une transaction, désactivation du mode autocommit */
            $this->connexion->beginTransaction();
             
            try
            {
                $m = $this->daoMembre->findEmail($email);
                
                if($m)
                {
                    if($this->daoMembre->delete($m))
                    {
                        $this->connexion->commit();
                        
                        session_destroy();
                        
                        $s = 'Merci de votre confiance pour notre outil.<br />A bientôt.';
                        
                        $email = new Email($m, $s, 1);
                        
                        if(!$email->envoyer()) throw new Exception;
                        
                        return true;
                    }
                }
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_désinscriptionUser: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return false;
            }
        }
        
        public function suppressionUser($email)
        {
            //Test de la longueur des champs
            if(!$this->maxLength($email, 200))
                    return false;
            
            /* Début d'une transaction, désactivation du mode autocommit */
            $this->connexion->beginTransaction();
             
            try
            {
                $m = $this->daoMembre->findEmail($email);
                
                if($m)
                {
                    if($this->daoMembre->delete($m))
                    {
                        $this->connexion->commit();
                        
                        $s = 'Merci de votre confiance pour notre outil.<br />A bientôt.';
                        
                        $email = new Email($m, $s, 1);
                        
                        if(!$email->envoyer()) throw new Exception;
                        
                        return true;
                    }
                }
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_désinscriptionUser: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return false;
            }
        }

        public function getInfoQuestionValue($id){
            try
            {
                $m = $this->daoCalcul->findVar($id);
                
                return $m;
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_getInfoQuestionValue: '.$e->getMessage());
                
                return false;
            }
        }
        
        public function getInfoDefaultValue($id){
            try
            {
                $m = $this->daoCalcul->findFix($id);
                
                return $m;
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_getInfoQuestionValue: '.$e->getMessage());
                
                return false;
            }
        }
        
        public function updateDefaultValue($val){
            try
            {
                return $this->daoCalcul->updateFix($val);
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_updateDefaultValue: '.$e->getMessage());
                
                return false;
            }
        }
        
        public function updateQuestionValue($val){
            try
            {
                return $this->daoCalcul->updateVar($val);
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_updateQuestionValue: '.$e->getMessage());
                
                return false;
            }
        }
        
        /*
         * Permet de se déconnecter de l'outil
         */
        public function deconnexionMembre()
        {
            if(isset($_SESSION['InvestPorc'])){
                session_destroy();
                return true;
            }
            else
                return false;
        }
        
        /*
         * 
         */
        public function getAllUser()
        {
            try
            {
                $listMembre = Array();
                $listMembre = $this->daoMembre->findAll();
                
                if($listMembre)
                {
                    $listLigne = Array();

                    for($i = 0; $i < Count($listMembre); $i++)
                    {
                        $listLigne[$i] = 
                            "<tr>
                                <td>".($i+1)."</td><td>".$listMembre[$i]->getNomPrenom()."</td><td>".
                                    $listMembre[$i]->getEmail().
                                "</td><td style=\"text-align: center;\">
                                    <a href=\"index.php?p=allUser&p3=".$listMembre[$i]->getEmail()."\"><button class=\"btn btn-mini btn-info\" type=\"button\">
                                    <i class=\"icon-search icon-white\"></i></button></a>
                                </td>
                                </td><td style=\"text-align: center;\">
                                    <a id=\"btnDesinscrire".$i."\" class=\"btn btn-danger btn-mini\" onClick=\"afficher_cacher('confirmDesinscrire".$i."'); afficher_cacher('btnDesinscrire".$i."'); return false;\">
                                        <i class=\"icon-remove icon-white\"></i>
                                    </a>
                                    <strong id=\"confirmDesinscrire".$i."\" style=\"visibility: hidden;\">
                                        <a href=\"index.php?p=allUser&p2=".$listMembre[$i]->getEmail()."\" id=\"MailSite\">oui </a>|  <a href=\"index.php?p=allUser\" id=\"MailSite\"> non </a>
                                    </strong>
                                </td>
                            </tr>";
                    }

                    return $listLigne;
                }
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_récupération_AllUser: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return null;
            }
        }
        
        /*
         * 
         */
        public function getAllDefaultValue()
        {
            try
            {
                $listValue = Array();
                $listValue = $this->daoDefaultValue->findAll();
                
                if($listValue)
                {
                    $listLigne = Array();

                    for($i = 0; $i < Count($listValue); $i++)
                    {
                        $listLigne[$i] = 
                            "<tr>
                                <td>".($i+1)."</td><td>".$listValue[$i]->getIntitule()."</td><td>".
                               stripslashes($listValue[$i]->getDescription()).
                                "<td>".$listValue[$i]->getValeur()."</td>".
                                "<td style=\"text-align: center;\">
                                    <a href=\"index.php?p=defaultValue&p2=".($i+1)."\"><button class=\"btn btn-mini btn-info\" type=\"button\">
                                    <i class=\"icon-pencil icon-white\"></i></button></a>
                                </td>
                            </tr>";
                    }

                    return $listLigne;
                }
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_récupération_AllUser: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return null;
            }
        }
        
        public function getAllQuestionValue()
        {
            try
            {
                $listValue = Array();
                $listValue = $this->daoCalcul->findAllVar();
                
                if($listValue)
                {
                    $listLigne = Array();

                    for($i = 0; $i < Count($listValue); $i++)
                    {
                        $listLigne[$i] = 
                            "<tr>
                                <td>".($i+1)."</td><td>".$listValue[$i]->getIntitule()."</td><td>".
                                stripslashes($listValue[$i]->getDescription()).
                                "<td>".$listValue[$i]->getValeur()."</td>".
                                "<td style=\"text-align: center;\">
                                    <a href=\"index.php?p=defaultQuestion&p2=".($i+1)."\"><button class=\"btn btn-mini btn-info\" type=\"button\">
                                    <i class=\"icon-pencil icon-white\"></i></button></a>
                                </td>
                            </tr>";
                    }

                    return $listLigne;
                }
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_récupération_AllUser: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return null;
            }
        }
        
        /*
         * Autorise un utilisateur d'accèder à la page
         * de réinitialisation de son mot de passe
         */
        public function allowForeignPwd($email, $key)
        {
            try
            {
                $fpwd = $this->daoForeignPassword->find($key);
                
                if(!$fpwd)
                    $this->forbidden ();
            }
            catch (PDOException $e)
            {
                $this->insertInLog('Erreur_redirection_AllowForeignPwd: '.$e->getMessage());
                return false;
            }
        }
        
        /*
         * Autorise seulement un utilisateur d'accéder à une page
         * redirigé vers forbidden
         */
        public function allow()
        {
            try
            {
                if(!isset($_SESSION['InvestPorc']))
                    $this->forbidden ();

                $g = $this->daoGroupe->find($this->user('idgroupe'));
                
                if($g) return true; else return true;
            }
            catch (PDOException $e)
            {
                $this->forbidden ();
                 
                $this->insertInLog('Erreur_FindGroupe_Allow: '.$e->getMessage());
                return false;
            }
        }
        
        /*
         * Autorise l'accès seulement à un administrateur
         */
        public function allowMaster()
        {
            try
            {
                if(!isset($_SESSION['InvestPorc']))
                    $this->forbidden ();

                $g = $this->daoGroupe->find($this->user('idgroupe'));
                
                if($g)
                    if($g->getNomGroupe() == "Utilisateur") return true; else return false;
            }
            catch (PDOException $e)
            {
                $this->forbidden ();
                 
                $this->insertInLog('Erreur_FindGroupe_AllowMaster: '.$e->getMessage());
                return false;
            }
        }       
        
        public function getAllValueFormCalcul()
        {
            try
            {
                $listValueFC = Array();
                $listValueFC = $this->daoCalcul->findAll();
                
                if($listValueFC)
                    return $listValueFC;
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_récupération_AllValueFormCalcul: '.$e->getMessage());
                
                return null;
            }
        }
        
        public function getAllFixedValue()
        {
            try
            {
                $listValueF = Array();
                $listValueF = $this->daoCalcul->findAllFixed();
                
                if($listValueF)
                    return $listValueF;
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_récupération_AllValueFormCalcul: '.$e->getMessage());
                
                return null;
            }
        }
        
        public function calculResultatEco($array, $email, $sessionId)
        {
            try
            {
                 /* Début d'une transaction, désactivation du mode autocommit */
                $this->connexion->beginTransaction();
                        
                if($email != "")
                {
                    $m = $this->daoMembre->findEmail($email);
                    
                    if($m)
                    {
                        $key = $this->genererCle();

                        foreach($array as &$o)
                        {
                            $o->setSession($sessionId);
							$exist = $this->daoReponse->find($o);
							if($exist != NULL) {
								$this->daoReponse->update($o);
							} else {
								$this->daoReponse->create($o);
							}
                            $r = $this->daoReponse->find($o);
                            $this->daoBusinessPlan->create($m->getId(), $r->getId(), $key);
                        }

                        unset($o); // Détruit la référence sur le dernier élément
                    }
                    else return false;
                }
                else
                {
                    
                    //Suppression si existe des réponses de la session
                    $this->daoReponse->delete($sessionId);

                    foreach($array as &$o)
                    {
                        $o->setSession($sessionId);
                        $this->daoReponse->create($o);
                    }
                    
                    unset($o); // Détruit la référence sur le dernier élément
                }
                
                return true;
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_calcul_businessplan: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return false;
            }
        }
        
        public function getAllReponseFormCalcul($session){
            try
            {
                $listValueR = Array();
                $listValueR = $this->daoReponse->findSession($session);

                if($listValueR)
                    return $listValueR;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_récupération_getAllReponseFormCalcul: '.$e->getMessage());
                
                return null;
            }
        }
        
        public function getAllReponseFormCalculByKey($keygen){
            try
            {
                $listValueR = Array();
                $listValueR = $this->daoReponse->findKey($keygen);

                if($listValueR)
                    return $listValueR;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_récupération_getAllReponseFormCalculKey: '.$e->getMessage());
                
                return null;
            }
        }
        
        /*
        public function resetForm($email,$sessionId, $keygen)
        {
            /* Début d'une transaction, désactivation du mode autocommit
            $this->connexion->beginTransaction();
             
            try
            {   if($email){
                    $m = $this->daoMembre->findEmail($email);

                    if($m){
                        $this->daoBusinessPlan->delete($m->getId());

                        $this->daoReponse->delete($sessionId);

                        return true;
                    }
                    else return false;
                }
                else
                {
                    $this->daoReponse->delete($sessionId);

                    return true;
                }
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_suppressionBusinessplan: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications
                $this->connexion->rollBack();
                
                return false;
            }
        }*/
        
        public function getAllBusinessPlan($email){
            try
            {
                $m = $this->daoMembre->findEmail($email);
                
                if($m)
                {
                    $listBusinessplan = Array();
                    $listBusinessplan = $this->daoBusinessPlan->find($m->getId());

                    if($listBusinessplan)
                    {
                        for($i = 0; $i < Count($listBusinessplan); $i++)
                        {
                            $listLigne[$i] = 
                            "<tr>
                                <td>".($i+1)."</td><td>".$listBusinessplan[$i]->getDate()."</td>".
                                "<td style=\"text-align: center;\">
                                    <a href=\"index.php?p=formulaire&p4=".$listBusinessplan[$i]->getKeygen()."\"><button class=\"btn btn-mini btn-info\" type=\"button\">
                                    <i class=\"icon-pencil icon-white\"></i></button></a>
                                </td>";
                            
                            if($this->allowMaster())
                                $listLigne[$i] .= "<td style=\"text-align: center;\">
                                                        <a id=\"btnDesinscrire".$listBusinessplan[$i]->getKeygen()."\" class=\"btn btn-danger btn-mini\" 
                                                            onClick=\"afficher_cacher('confirmDesinscrire".$listBusinessplan[$i]->getKeygen()."'); 
                                                            afficher_cacher('btnDesinscrire".$listBusinessplan[$i]->getKeygen()."'); return false;\">
                                                            <i class=\"icon-remove icon-white\"></i>
                                                        </a>
                                                        <strong id=\"confirmDesinscrire".$listBusinessplan[$i]->getKeygen()."\" style=\"visibility: hidden;\">
                                                            <a href=\"index.php?p=mesbusinessplan&p2=".$listBusinessplan[$i]->getKeygen().
                                                                "&p3=".$listBusinessplan[$i]->getSession()."\" id=\"MailSite\">oui </a>|  <a href=\"index.php?p=mesbusinessplan\" id=\"MailSite\"> non </a>
                                                        </strong>
                                                    </td>";
                                    
                            $listLigne[$i] .= "</tr>";
                        }
                        
                        return $listLigne;
                    }
                    else
                        return false;
                }
                else return false;
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_récupération_getAllReponseFormCalcul: '.$e->getMessage());
                
                return null;
            }
        }
        
        public function suppressionBusinessplan($keygen, $session){
            /* Début d'une transaction, désactivation du mode autocommit */
            $this->connexion->beginTransaction();
             
            try
            {
                $this->daoBusinessPlan->delete($keygen);

                $this->daoReponse->delete($session);

                return true;
            }
            catch(PDOException $e)
            {
                $this->insertInLog('Erreur_suppressionBusinessplan: '.$e->getMessage());
                
                /* On s'aperçoit d'une erreur et on annule les modifications */
                $this->connexion->rollBack();
                
                return false;
            }
        }


        //**************************************************************************************
        /*
         * Récupère une information de l'utilisateur en fonction du paramètre
         * field
         */
        public function user($field){
            if(isset($_SESSION['InvestPorc'])){
                switch (trim($field))
                {
                case 'email':
                    return unserialize($_SESSION['InvestPorc'])->getEmail();
                    break;
                case 'motdepasse':
                    return unserialize($_SESSION['InvestPorc'])->getMotDePasse();
                    break;
                case 'nomprenom':
                    return unserialize($_SESSION['InvestPorc'])->getNomPrenom();
                    break;
                case 'idgroupe':
                    return unserialize($_SESSION['InvestPorc'])->getGroupe()->getIdGroupe();
                    break;
                default :
                    return false;
                    break;
                }
            }
            else
                return false;
        }
        
        public function getValue($initule_s, $array)
        {
            $valeur = '0';
            
            if($array != NULL)
                {
                foreach($array as &$o)
                    if($o->getIntitule() == $initule_s)  
                        $valeur = $o->getValeur();

                // Détruit la référence sur le dernier élément    
                unset($o);
            }
            
            return $valeur;
        }
        
        public function chkSel($get){
            return $get != '' ;
        }
        
        /*
         * Permet de rediriger vers page de non accès
         */
        public function forbidden()
        {
            header('Location: index.php?p=errorAccess');
        }

        /*
         * Permet de vérifier la taille d'un champs
         */
        private function maxLength($element, $max)
        {
            if(strlen($element) > $max)
                return false;
            
            return true;
        }
        
        /*
         * Permet la création d'un captcha
         */
        public function captcha()
        {
            $captcha = new Captcha();            
            return $captcha;
        }
        
        /*
         * Permet à un utilisateur de contacter le gèrant de l'outil
         */
        public function contactMail($nom, $email, $message)
        {
            try
            {
                $m = new Membre($nom, $email);
                
                $email = new Email($m, $message, 0);   
                
                if(!$email->envoyer(true)) throw new Exception;
                
                return true;
            }
            catch(Exception $e)
            {
                $this->insertInLog('Erreur_contactMail_Envoi_Mail: '.$e->getMessage());
                
                return false;
            }
        }
        
        /*
         * Permet de générer une clé aléatoire de 64 caractères
         */
        private function genererCle()
        {
            return md5(uniqid(rand(), true)); 
        }
        
        /*
         * Permet de sauvegarder toutes les erreurs d'accès à la base de données
         * dans un fichier text (genre de log)
         */
        private function insertInLog($errtxt)
        {
            //Ouverture en lecture et écriture ; 
            //place le pointeur de fichier à la fin du fichier. 
            //Si le fichier n'existe pas, on tente de le créer. 
            $fp = fopen('logBD.txt','a+');

            fputs($fp, date("d-m-Y").' - '.date("H:i").' - '.$errtxt."\r\n");
            
            //Fermeture du fichier
            fclose($fp);
        }
    }
?>
