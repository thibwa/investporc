<?php
    class Reponse {
        private $id;
        private $intitule;
        private $valeur;
        private $session;
        
        function __construct($intitule, $valeur,$session="", $id=-1) {
            $this->intitule = $intitule;
            $this->valeur = $valeur;
            
            $this->session = $session;
            $this->id = $id;
        }
        
        public function getIntitule() {
            return $this->intitule;
        }

        public function setIntitule($intitule) {
            $this->intitule = $intitule;
        }
        
        public function getValeur() {
            return $this->valeur;
        }

        public function setValeur($valeur) {
            $this->valeur = $valeur;
        }

        public function getSession() {
            return $this->session;
        }

        public function setSession($session) {
            $this->session = $session;
        }
        
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }
    }

?>
