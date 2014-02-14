<?php
    class Businessplan {
        var $Date;
        var $Session;
        var $Keygen;
        
        function __construct($date, $session, $keygen) {
            $this->Date = $date;
            $this->Session = $session;
            $this->Keygen = $keygen;
        }
        
        public function getDate() {
            return $this->Date;
        }

        public function setDate($Date) {
            $this->Date = $Date;
        }
        
        public function getSession() {
            return $this->Session;
        }

        public function setSession($Session) {
            $this->Session = $Session;
        }
        
        public function getKeygen() {
            return $this->Keygen;
        }

        public function setKeygen($Keygen) {
            $this->Keygen = $Keygen;
        }
    }
?>
