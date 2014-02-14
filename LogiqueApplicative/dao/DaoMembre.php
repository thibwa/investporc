<?php
    class DaoMembre
    {
        private $connect;
        
        function __construct($connect) {
            $this->connect = $connect;
        }
        
        /**
	 * Permet de récupérer un objet Membre
         * en fonction de son email et son mot de passe
	 */
	function find($email, $motdepasse)
        {
            try
            {
                $req = $this->connect->prepare('SELECT * FROM invest_membre i_m JOIN invest_groupes i_g ON i_m.groupe_id = i_g.id WHERE i_m.email = :email AND i_m.motdepasse = :motdepasse');
                $req->bindValue(':email', $email, PDO::PARAM_STR);
                $req->bindValue(':motdepasse', $motdepasse, PDO::PARAM_STR);
                
                $req->execute();
                
                $tmp = $req->fetch();
                 
                if(count($tmp) > 1)
                    return (new Membre($tmp['nomprenom'], $tmp['email'], $tmp['motdepasse'], new Groupe($tmp['nom'], $tmp['groupe_id'])));
                else
                    return false;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
        
        /**
         * Permet de récupérer l'entiereté des utilisateurs dans la BD
         */
        function findAll()
        {
            try
            {
                $listMembre = Array();
                
                $req = $this->connect->prepare('SELECT * FROM invest_membre i_m JOIN invest_groupes i_g ON i_m.groupe_id = i_g.id AND i_g.nom != \'Administrateur\'');
                
                $req->execute();
                 
                while($tmp = $req->fetch())
                {
                    $m = new Membre($tmp['nomprenom'], $tmp['email'], $tmp['motdepasse'], new Groupe($tmp['nom'], $tmp['groupe_id']));
                    $listMembre[] = $m;
                }
                
                return $listMembre;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
        
        /**
	 * Permet de récupérer un objet Membre
         * enfonction de son email
	 */
	function findEmail($email)
        {
            try
            {
                $req = $this->connect->prepare('SELECT i_m.*, i_g.nom FROM invest_membre i_m JOIN invest_groupes i_g ON i_m.groupe_id = i_g.id WHERE i_m.email = :email');
                $req->bindValue(':email', $email, PDO::PARAM_STR);
                
                $req->execute();
                
                $tmp = $req->fetch();
                 
                if(count($tmp) > 1)
                {
                    $m = new Membre($tmp['nomprenom'], $tmp['email'], $tmp['motdepasse'], new Groupe($tmp['nom'], $tmp['groupe_id']));
                    $m->setId($tmp['id']);
                    return $m;
                }
                else
                    return false;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
	
	/**
	 * Permet de créer une entrée dans la base de données
	 * par rapport à un objet
         * return le nombre de lignes insérées
	 */
	function create($obj)
        {
            try
            {
                $req = $this->connect->prepare('INSERT INTO invest_membre (nomprenom, email, motdepasse) VALUES (:nomprenom, :email, :motdepasse)');
                $req->bindValue(':nomprenom', $obj->getNomPrenom(), PDO::PARAM_STR);
                $req->bindValue(':email', $obj->getEmail(), PDO::PARAM_STR);
                $req->bindValue(':motdepasse', $obj->getMotDePasse(), PDO::PARAM_STR);
                
                return ($req->execute());
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
	
	/**
	 * Permet de mettre à jour les données d'une entrée dans la base 
	 */
	function update($obj, $email)
        {
            try 
            {
                $req = $this->connect->prepare('SELECT id FROM invest_membre WHERE email = :email');
                $req->bindValue(':email', $email, PDO::PARAM_STR);
                
                $req->execute();
                
                $tmp = $req->fetch();
                 
                if(count($tmp) > 1)
                    $id = $tmp['id'];
                else
                    return false;
                
                $req = $this->connect->prepare('UPDATE invest_membre SET nomprenom = :nomprenom, motdepasse = :motdepasse, email = :email WHERE id = :id');
                $req->bindValue(':nomprenom', $obj->getNomPrenom(), PDO::PARAM_STR);
                $req->bindValue(':motdepasse', $obj->getMotDePasse(), PDO::PARAM_STR);
                $req->bindValue(':email', $obj->getEmail(), PDO::PARAM_STR);
                $req->bindValue(':id', $id, PDO::PARAM_INT);
                
                return ($req->execute());
            } 
            catch (PDOException $e) 
            {
                throw new PDOException($e->getMessage());
            }
        }
	
	/**
	 * Permet la suppression d'une entrée de la base
	 */
	function delete($obj)
        {
            try
            {
                $req = $this->connect->prepare('DELETE FROM invest_membre WHERE email = :email');
                $req->bindValue(':email', $obj->getEmail(), PDO::PARAM_STR);
                
                return ($req->execute());
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
    }
?>
