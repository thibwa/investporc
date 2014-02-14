<?php
    class Membre {
        private $id;
        private $NomPrenom;
        private $Email;
        private $MotDePasse;        
        private $Groupe;

        function __construct($NomPrenom = null, $Email = null, $MotDePasse = null, $Groupe = null) {
            $this->NomPrenom = $NomPrenom;
            $this->Email = $Email;
            $this->MotDePasse = $MotDePasse;
            $this->Groupe = $Groupe;
        }
        
        public function getNomPrenom() {
            return $this->NomPrenom;
        }

        public function setNomPrenom($NomPrenom) {
            $this->NomPrenom = $NomPrenom;
        }

        public function getEmail() {
            return $this->Email;
        }

        public function setEmail($Email) {
            $this->Email = $Email;
        }

        public function getMotDePasse() {
            return $this->MotDePasse;
        }

        public function setMotDePasse($MotDePasse) {
            $this->MotDePasse = $MotDePasse;
        }
        
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getGroupe() {
            return $this->Groupe;
        }

        public function setGroupe($Groupe) {
            $this->Groupe = $Groupe;
        }
    }
?>
