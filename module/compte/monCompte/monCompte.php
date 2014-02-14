<?php
    $nomprenom = "";
    $email = "";
    $motdepasse = "";
    
    if($controleur->allow())
    {
        $nomprenom = $controleur->user('nomprenom');
        $email = $controleur->user('email');
        $motdepasse = $controleur->user('motdepasse');
    }
   
    if(isset($_POST['Modif_nom']))
    {
        $nom = $_POST['Modif_nom'];
        
        if($valReturn= $controleur->updateInfoUser($nom, null, null))
            header("Location: index.php?p=moncompte&p2=success");
        else
            header("Location: index.php?p=moncompte&p2=error");  
    }
    
    if(isset($_POST['Modif_email']))
    {
        $emailN = $_POST['Modif_email'];
        
        if($valReturn= $controleur->updateInfoUser(null, null, $emailN))
            header("Location: index.php?p=moncompte&p2=success");
        else
            header("Location: index.php?p=moncompte&p2=error");  
    }
    
    if(isset($_POST['Modif_motDePasseHid']))
    {
        $ancienMotDePasse = $_POST['Modif_motDePasseHid'];
        
        if($controleur->updateInfoUser(null, $ancienMotDePasse, null))
            header("Location: index.php?p=moncompte&p2=success");
        else
            header("Location: index.php?p=moncompte&p2=error");  
    }
    if(isset($_GET["p3"]))
    {
        if($_GET["p3"] == "desinscription")
        {
            if ($controleur->desinscription($controleur->user('email'))) 
                header('Location: index.php');
        }
        else
            $controleur->forbidden();
            
    }
?>
<div class="container">
    <div class="row">
        <div class="span12">
            <legend>Gèrer mon compte InvestPorc</legend>
            <blockquote>
                <p style="font-size: 14px;">
                    <Strong>
                        Le module de gestion de compte vous permet de gèrer vos informations enregistrées sur l'outil InvestPorc. 
                        Vous pouvez dès à présent changer vos informations en cliquant sur le bouton à côté de votre information à modifier.
                    </strong>
                </p>
            </blockquote>
        </div>
        
        <div class="span9" id="infoCompte">
            <div>      
                <?php
                    if(isset($_GET["p2"]))
                    {
                        switch ($_GET["p2"])
                        {
                            case "error":
                                include 'module/compte/monCompte/alert/alert-errorGererCompte.php';
                                break;
                            case "success":
                                include 'module/compte/monCompte/alert/alert-successGererCompte.php';
                                break;
                            default:
                                header ('index.php?p=erreur404');
                                break;
                        }
                    }

                    include 'module/compte/monCompte/alert/alert-errorForm.php';
                ?> 
            </div>
            <?php
                include 'module/compte/monCompte/divisions/gererNomCompte.php';
            ?>

            <hr>
            
            <?php
                include 'module/compte/monCompte/divisions/gererEmailCompte.php';
            ?>
            
            <hr>
            
            <?php
                include 'module/compte/monCompte/divisions/gererMotDePasseCompte.php';
            ?>
        </div>
        
        <div class="span3 pull-right visible-desktop" id="imgCompte"></div>
        
        <div class="span12">
            <hr>
            <div class="row-fluid">
                <div class="alert alert-error">
                    <h4><img src="img/alert-error.png" alt="Error" style="border:none;" /> Désinscription:</h4>
                    Vous voulez vous désinscrire de l'outil InvestPorc, alors cliquez-ici: 
                    <a id="btnDesinscrire" class="btn btn-danger btn-mini" onClick="afficher_cacher('confirmDesinscrire'); afficher_cacher('btnDesinscrire'); return false;">
                        <i class="icon-remove icon-white"></i>
                    </a>
                    <strong id="confirmDesinscrire" style="visibility: hidden;"><a href="index.php?p=moncompte&p3=desinscription" id="MailSite">oui </a>|  <a href="index.php?p=moncompte" id="MailSite"> non </a></strong>
                </div>  
            </div>
        </div>
        </div>
    </div>
</div>
