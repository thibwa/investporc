<?php session_start();
    ob_start();
?>
<!-- DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" -->
<html xmlns="http://www.w3.org/1999/xhtml" lang=fr>
    <head>
        <?php 
            include 'module/index/header.php'; 
        ?>
    </head>
    <body id="body">
        <?php
            include 'module/index/menu.php';
            
            echo "<div id=\"wrap\">";
            if (isset($_GET["p"])) {
                switch ($_GET["p"]) {
                    case "calcul":
                        include 'module/calcul/calcul.php';
                        break;
                    case "formulaire":
                        include 'module/calcul/calculForm.php';
                        break;
                    case "methode":
                        include 'module/methode/methode.php';
                        break;
                    case "contact":
                        include 'module/contact/contact.php';
                        break;
                    case "register":
                        include 'module/compte/creation/compte.php';
                        break;
                    case "recover":
                        include 'module/compte/oubli/compte.php';
                        break;
                    case "moncompte":
                        include 'module/compte/monCompte/monCompte.php';
                        break;
                    case "allUser":
                        include 'module/administration/gererCompteAllUser.php';
                        break;
                    case "defaultValue":
                        include 'module/administration/gererValeurDefault.php';
                        break;
                    case "defaultQuestion":
                        include 'module/administration/gererValeurQuestion.php';
                        break;
                    case "mesbusinessplan":
                        include 'module/compte/businessplan/gererBusinessplan.php';
                        break;
                    case "statistique":
                        include 'module/administration/statistique.php';
                        break;
                    case "errorAccess":
                        include 'module/error/errorAccess.php';
                        break;
                    case "erreur404":
                        include 'module/error/error404.php';
                        break;
                    default:
                        include 'module/error/error404.php';
                        break;
                }
            } else
                include 'module/index/corps.php';
            
            echo "<div class=\"push\"></div>";
            echo "</div>";
            include 'module/index/footer.php';
        ?>
    </body>
</html>
<?php ob_end_flush(); ?>
