<?php
    class DaoGroupe
    {
        private $connect;
        
        function __construct($connect) {
            $this->connect = $connect;
        }
        
        /*
	 * Permet de récupérer un objet via son id
	 */
	function find($idgroupe)
        {
            try
            {
                $req = $this->connect->prepare('SELECT * FROM invest_groupes WHERE id = :id');
                $req->bindValue(':id', $idgroupe, PDO::PARAM_INT);
                
                $req->execute();
                
                $tmp = $req->fetch();
                 
                if(count($tmp) > 1)
                    return (new Groupe($tmp['nom'], $tmp['id']));
                else
                    return false;
            } 
            catch (PDOException $e) 
            {
               throw new PDOException($e->getMessage());
            }
        }
    }
?>
