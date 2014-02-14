<?php
    class Email{
        private $MembreSrc;
        private $MembreDst;
        private $Message;
        private $Sujet = "InvestPorc Contact";


        function __construct($MembreSrc, $Message = null, $Protocole = 0) {
            $this->MembreSrc = $MembreSrc;
            $this->MembreDst = new Membre(null, 'investporcdemo@gmail.com');
            $this->Message = $Message;
            if ($Protocole == 1) $this->MembreDst->setEmail($MembreSrc->getEmail());
        }
        
        public function getMembreSrc() {
            return $this->MembreSrc;
        }

        public function setMembreSrc($MembreSrc) {
            $this->MembreSrc = $MembreSrc;
        }

        public function getMembreDst() {
            return $this->MembreDst;
        }

        public function setMembreDst($MembreDst) {
            $this->MembreDst = $MembreDst;
        }

        public function getMessage() {
            return $this->Message;
        }

        public function setMessage($Message) {
            $this->Message = $Message;
        }

        public function getSujet() {
            return $this->Sujet;
        }

        public function setSujet($Sujet) {
            $this->Sujet = $Sujet;
        }
        
        private function genererCorps(){
           $corps = "<div id=\"corps\"><p><h3><Strong>Bonjour ";
           $corps .= $this->MembreSrc->getNomPrenom()."</Strong></h3></p><p>".$this->Message."</p></div><div id=\"pied\"><p>Nous vous remercions de votre confiance.</p>";
           $corps .= "<p>Cordialement, </p><p>InvestPorc</p><table border=\"0\"><tr><td><img src=\"http://alpinistesarboricoles.be/TFE/img/investporc-logo.png\" alt=\"InvestPorc\" style=\"border:none;\" /></td>";
           $corps .= "<td><a href=\"http://www.cra.wallonie.be\" target=\"_blank\"><img src=\"http://alpinistesarboricoles.be/TFE/img/CRA-W_LOGO_RVB.png\" alt=\"CRA-W\" style=\"border:none;\" />";
           $corps .= "</a></td><td style=\"text-align: left; font-size: 14px;\"><strong>Centre wallon de Recherches agronomiques<br />Département Productions et Filières<br />";
           $corps .= "Unité Mode d'élevage, bien-être et qualité<br />Bâtiment Bertrand Vissac<br /></strong></td></tr></table><br /><hr><br/>";
           $corps .= "<div style=\"width: 800px; heigth: 150px; background-color: #F2DEDE; -webkit-border-radius: 9px; -moz-border-radius: 9px; border-radius: 9px; padding-left: 5px;";
           $corps .= "padding-top: 5px; padding-bottom: 5px;\">";
           $corps .= "<img src=\"http://alpinistesarboricoles.be/TFE/img/alert-error.png\" alt=\"InvestPorc\" style=\"border:none;\" />";
           $corps .= "Merci de ne pas répondre à cet e-mail. Celui-ci ayant été généré automatiquement nous ne pourrons traiter votre réponse.";
           $corps .= " Vous pouvez toujours nous contacter par le module de contact sur notre site ou par l'adresse mail:<u><A HREF=\"mailto:servais@cra.wallonie.be\" target=\"_blank\">servais@cra.wallonie.be</a></u>";
           $corps .= "</div></div>";
           
           return $corps;
        }
    
        public function envoyer(){

            //Préparation de l'entête du mail:
            $mail_entete = "Sujet: ".$this->Sujet
                            .'From: '.$this->MembreSrc->getEmail()."\r\n"
                            .'Reply-To: '.$this->MembreSrc->getEmail()."\r\n"
                            .'Content-type: text/html; charset=iso-8859-1"'
                            ."\r\nContent-Transfer-Encoding: 8bit\r\n"
                            .'X-Mailer:PHP/'.phpversion()."\r\n";
            
            // envoi du mail
            return (mail($this->MembreDst->getEmail(), $this->Sujet, $this->genererCorps(), $mail_entete));
        }
    }
?>
