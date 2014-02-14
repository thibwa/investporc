<?php
    class DaoDefaultValue {
        private $connect;
        
        function __construct($connect) {
            $this->connect = $connect;
        }
        
        /*
	 * Permet de récupérer un objet via l'adresse email et la key générée
	 */
	function find($email, $key)
        {
            try
            {
                $req = $this->connect->prepare('SELECT * FROM invest_defaultvalue WHERE email = :email AND keygen = :keygen');
                $req->bindValue(':email', $email, PDO::PARAM_STR);
                $req->bindValue(':keygen', $key, PDO::PARAM_STR);
                
                $req->execute();
                
                $tmp = $req->fetch();
                 
                if(count($tmp) > 1)
                    return (new ForeignPassword($tmp['email'], $tmp['keygen']));
                else
                    return false;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
        
        /*
         * 
         */
        function findAll()
        {
            try
            {
                $listDefaultValue = Array();
                
                $req = $this->connect->prepare('SELECT * FROM invest_defaultvalue');
                
                $req->execute();
                 
                while($tmp = $req->fetch())
                {
                    $dv = new DefaultValue($tmp['intitule'], $tmp['valeur'], $tmp['description']);
                    $listDefaultValue[] = $dv;
                }
                
                return $listDefaultValue;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }   
        }
    }
?>
