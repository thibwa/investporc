<?php

    class DaoBusinessPlan {
        private $connect;

        function __construct($connect) {
            $this->connect = $connect;
        }

        function create($membreId, $reponseId, $keygen)
        {
            try
            {
                $req = $this->connect->prepare('INSERT INTO invest_businessplan (membre_id, reponse_id, keygen) VALUES (:membre_id, :reponse_id, :keygen)');
                $req->bindValue(':membre_id', $membreId, PDO::PARAM_INT);
                $req->bindValue(':reponse_id', $reponseId, PDO::PARAM_INT);
                $req->bindValue(':keygen', $keygen, PDO::PARAM_STR);
                
                return ($req->execute());
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
        
        function delete($keygen)
        {
            try
            {
                $req = $this->connect->prepare('DELETE FROM invest_businessplan WHERE keygen = :keygen');
                $req->bindValue(':keygen', $keygen, PDO::PARAM_STR);
                
                return ($req->execute());
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
        
        function find($id)
        {
            try
            {
                $listBusinessplan = Array();
                
                $req = $this->connect->prepare('SELECT * FROM invest_businessplan ib LEFT JOIN invest_reponse ir ON ib.reponse_id = ir.id 
                    WHERE membre_id = :id GROUP BY keygen ORDER BY ib.insert DESC');
                $req->bindValue(':id', $id, PDO::PARAM_INT);

                $req->execute();

                while($tmp = $req->fetch())
                {
                    $dv = new Businessplan($tmp['insert'], $tmp['session'], $tmp['keygen']);
                    $listBusinessplan[] = $dv;
                }

                return $listBusinessplan;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            } 
        }
    }

?>
