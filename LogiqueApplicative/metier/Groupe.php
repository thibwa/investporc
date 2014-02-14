<?php
    class Groupe {
        private $NomGroupe;
        private $IdGroupe;

        function __construct($NomGroupe, $IdGroupe) {
            $this->NomGroupe = $NomGroupe;
            $this->IdGroupe = $IdGroupe;
        }
        
        public function getNomGroupe() {
            return $this->NomGroupe;
        }

        public function setNomGroupe($NomGroupe) {
            $this->NomGroupe = $NomGroupe;
        }
        
        public function getIdGroupe()
        {
            return $this->IdGroupe;
        }

        public function setIdGroupe($IdGroupe)
        {
            $this->IdGroupe = $IdGroupe;
        }
    }
?>
