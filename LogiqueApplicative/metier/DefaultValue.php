<?php
    class DefaultValue {
        var $Intitule;
        var $Description;
        var $Valeur;
        
        function __construct($Intitule, $Valeur, $Description = "") {
            $this->Intitule = $Intitule;
            $this->Description = $Description;
            /*
            $user_agent = $_SERVER['HTTP_USER_AGENT']; 

            if (preg_match('/MSIE/i', $user_agent))
                $this->Valeur = str_replace('.', ',',$Valeur);
            else */
                $this->Valeur = $Valeur;
        }
        
        public function getIntitule() {
            return $this->Intitule;
        }

        public function getDescription() {
            return $this->Description;
        }

        public function getValeur() {
            return $this->Valeur;
        }
    }
?>
