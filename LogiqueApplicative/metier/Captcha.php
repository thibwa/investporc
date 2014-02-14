<?php
    class Captcha{
        var $nb1;
        var $nb2;
        
        function __construct() {
            $this->nb1 = mt_rand(1, 9);
            $this->nb2 = mt_rand(1, 19);
        }
        
        public function getNb1() {
            return $this->nb1;
        }

        public function getNb2() {
            return $this->nb2;
        }
        
        public function __toString()
        {
            return $this->nb1.' + '.$this->nb2;
        }
    }
?>
