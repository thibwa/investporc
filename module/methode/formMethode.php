<?php
    if(isset($_GET["p2"]))
    {
        switch ($_GET["p2"])
        {
            case "resultat":
                include 'module/methode/divisions/resultat.php';
                break;
            case "precision":
                include 'module/methode/divisions/precision.php';
                break;
        }
    }
    else
        include 'module/methode/divisions/informations.php';
?>