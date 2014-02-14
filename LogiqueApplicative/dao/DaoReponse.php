<?php

    class DaoReponse {
        private $connect;

        function __construct($connect) {
            $this->connect = $connect;
        }

        function create($obj)
        {
            try
            {
                $req = $this->connect->prepare('INSERT INTO invest_reponse (reponse, intitule, session) VALUES (:reponse, :intitule, :session)');
                $req->bindValue(':reponse', $obj->getValeur(), PDO::PARAM_STR);
                $req->bindValue(':intitule', $obj->getIntitule(), PDO::PARAM_STR);
                $req->bindValue(':session', $obj->getSession(), PDO::PARAM_STR);
                
                return ($req->execute());
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
        
        function find($obj)
        {
            try
            {
                $req = $this->connect->prepare('SELECT * FROM invest_reponse WHERE session = :session AND intitule = :intitule');
                $req->bindValue(':intitule', $obj->getIntitule(), PDO::PARAM_STR);
                $req->bindValue(':session', $obj->getSession(), PDO::PARAM_STR);
                
                $req->execute();
                
                $tmp = $req->fetch();
                 
                if(count($tmp) > 1)
                    return (new Reponse($tmp['reponse'], $tmp['intitule'], $tmp['session'], $tmp['id']));
                else
                    return false;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
        
        function findSession($session)
        {
            try
            {
                
                
                $req = $this->connect->prepare('SELECT * FROM invest_reponse WHERE session = :session GROUP BY intitule ORDER BY id');
                $req->bindValue(':session', $session, PDO::PARAM_STR);
                
                $req->execute();
                
                $listReponse = Array();
                 
                while($tmp = $req->fetch())
                {
                    //function __construct($intitule, $valeur,$session)
                    $r = new Reponse($tmp['intitule'], $tmp['reponse'], $tmp['session'],$tmp['id']);
                    $listReponse[] = $r;
                }
                
                return $listReponse;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
        
        function findKey($key)
        {
            try
            {
                $req = $this->connect->prepare('SELECT * FROM invest_reponse JOIN invest_businessplan ON reponse_id = id AND keygen = :keygen');
                $req->bindValue(':keygen', $key, PDO::PARAM_STR);
                
                $req->execute();
                
                $listReponse = Array();
                 
                while($tmp = $req->fetch())
                {
                    //function __construct($intitule, $valeur,$session)
                    $r = new Reponse($tmp['intitule'], $tmp['reponse'], $tmp['session'],$tmp['id']);
                    $listReponse[] = $r;
                }
                
                return $listReponse;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
        
        function findMembre($idMembre)
        {
            try
            {
                $req = $this->connect->prepare('SELECT ir.* FROM invest_reponse ir LEFT JOIN invest_businessplan ib ON ib.reponse_id = ir.membre_id = :idMembre');
                $req->bindValue(':idMembre', $idMembre, PDO::PARAM_STR);
                
                $req->execute();
                
                $tmp = $req->fetch();
                
                $listReponse = Array();
                 
                while($tmp = $req->fetch())
                {
                    //function __construct($intitule, $reponse,$session)
                    $r = new Reponse($tmp['intitule'], $tmp['reponse'], $tmp['session']);
                    $r->setId($tmp['id']);
                    $listReponse[] = $r;
                }
                
                return $listReponse;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
        
        function delete($session)
        {
            try
            {
                $req = $this->connect->prepare('DELETE FROM invest_reponse WHERE session = :session');
                $req->bindValue(':session', $session, PDO::PARAM_STR);
                
                return ($req->execute());
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
    }

?>
