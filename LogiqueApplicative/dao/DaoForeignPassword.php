<?php
    class DaoForeignPassword
    {
        private $connect;
        
        function __construct($connect) {
            $this->connect = $connect;
        }
        
        /*
	 * Permet de récupérer un objet via l'adresse email et la key générée
	 */
	function find($key)
        {
            try
            {
                $req = $this->connect->prepare('SELECT * FROM invest_foreignpassword i_fp JOIN invest_membre i_m ON i_m.id = i_fp.membre_id WHERE i_fp.keygen = :keygen');
                $req->bindValue(':keygen', $key, PDO::PARAM_STR);
                
                $req->execute();
                
                $tmp = $req->fetch();
                 
                if(count($tmp) > 1)
                    return (new ForeignPassword(new Membre($tmp['nomprenom'], $tmp['email'], $tmp['motdepasse']), $tmp['keygen']));
                else
                    return false;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }      
	
	/*
	 * Permet de créer une entrée dans la base de données
	 * par rapport à un objet
         * return le nombre de lignes insérées
	 */
	function create($obj)
        {
            try
            {
                $req = $this->connect->prepare('INSERT INTO invest_foreignpassword (membre_id, keygen, dateCurrent) VALUES (:id, :key, now())');
                $req->bindValue(':id', $obj->getMembre()->getId(), PDO::PARAM_STR);
                $req->bindValue(':key', $obj->getKeygen(), PDO::PARAM_STR);
                
                return ($req->execute());
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
	
	/*
	 * Permet la suppression d'une entrée de la base
	 */
	function delete($obj)
        {
            try
            {
                $req = $this->connect->prepare('DELETE FROM invest_foreignpassword WHERE keygen = :key');
                $req->bindValue(':key', $obj->getKeygen(), PDO::PARAM_STR);
                
                return ($req->execute());
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
    }
?>
