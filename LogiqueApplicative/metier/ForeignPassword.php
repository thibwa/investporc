<?php
    class ForeignPassword
    {
        private $Membre;
        private $Keygen; 

        function __construct($Membre, $Keygen) {
            $this->Membre = $Membre;
            $this->Keygen = $Keygen;
        }
        
        public function getMembre(){
            return $this->Membre;
        }

        public function setMembre($Membre){
            $this->Membre = $Membre;
        }

        public function getKeygen(){
            return $this->Keygen;
        }

        public function setKey($Keygen){
            $this->Keygen = $Keygen;
        }
    }
?>
