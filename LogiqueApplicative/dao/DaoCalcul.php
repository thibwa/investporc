<?php

    class DaoCalcul {
        private $connect;

        function __construct($connect) {
            $this->connect = $connect;
        }

        function findAll()
        {
            try
            {
                $listDefaultValue = Array();

                $req = $this->connect->prepare('SELECT intitule, valeur FROM invest_question UNION SELECT intitule, valeur FROM invest_defaultvalue');

                $req->execute();

                while($tmp = $req->fetch())
                {
                    $dv = new DefaultValue($tmp['intitule'], $tmp['valeur']);
                    $listDefaultValue[] = $dv;
                }

                return $listDefaultValue;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            } 
        }
        
        function findAllFixed()
        {
            try
            {
                $listDefaultValue = Array();

                $req = $this->connect->prepare('SELECT intitule, valeur FROM invest_defaultvalue');

                $req->execute();

                while($tmp = $req->fetch())
                {
                    $dv = new DefaultValue($tmp['intitule'], $tmp['valeur']);
                    $listDefaultValue[] = $dv;
                }

                return $listDefaultValue;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            } 
        }
        
        function findAllVar()
        {
            try
            {
                $listDefaultValue = Array();

                $req = $this->connect->prepare('SELECT * FROM invest_question');

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
        
        function findVar($id)
        {
            try
            {
                $req = $this->connect->prepare('SELECT * FROM invest_question WHERE id = :id');
                $req->bindValue(':id', $id, PDO::PARAM_INT);

                $req->execute();

                $tmp = $req->fetch();
                 
                if(count($tmp) > 1)
                {
                    $dv = new DefaultValue($tmp['intitule'], $tmp['valeur'], $tmp['description']);
                }
                else return null;

                return $dv;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            } 
        }
        
        function findFix($id)
        {
            try
            {
                $req = $this->connect->prepare('SELECT * FROM invest_defaultvalue WHERE id = :id');
                $req->bindValue(':id', $id, PDO::PARAM_INT);

                $req->execute();

                $tmp = $req->fetch();
                 
                if(count($tmp) > 1)
                {
                    $dv = new DefaultValue($tmp['intitule'], $tmp['valeur'], $tmp['description']);
                }
                else return null;

                return $dv;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            } 
        }
        
        function updateFix($obj){
            try 
            {
                $req = $this->connect->prepare('UPDATE invest_defaultvalue SET description = :description, valeur = :valeur WHERE intitule = :intitule');
                $req->bindValue(':description', $obj->getDescription(), PDO::PARAM_STR);
                $req->bindValue(':valeur', $obj->getValeur(), PDO::PARAM_STR);
                $req->bindValue(':intitule', $obj->getIntitule(), PDO::PARAM_STR);
                
                return ($req->execute());
            } 
            catch (PDOException $e) 
            {
                throw new PDOException($e->getMessage());
            }
        }
        
        function updateVar($obj){
            try 
            {
                $req = $this->connect->prepare('UPDATE invest_question SET description = :description, valeur = :valeur WHERE intitule like :intitule');
                $req->bindValue(':description', $obj->getDescription(), PDO::PARAM_STR);
                $req->bindValue(':valeur', $obj->getValeur(), PDO::PARAM_STR);
                $req->bindValue(':intitule', $obj->getIntitule(), PDO::PARAM_STR);
                
                return ($req->execute());
            } 
            catch (PDOException $e) 
            {
                throw new PDOException($e->getMessage());
            }
        }
    }

?>
