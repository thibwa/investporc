<?php
    if(isset($_GET["p2"]))
    {
        switch ($_GET["p2"])
        {
            case "informations":
                include 'module/contact/divisions/informations.php';
                break;
            case "formulaire":
                include 'module/contact/divisions/formulaire.php';
                break;
        }
    }
    else
        include 'module/contact/divisions/carte.php';
?>