<?php
    if(isset($_POST['Recover_email']))
    {
        $email = $_POST['Recover_email'];
        
        if($controleur->recupererMotDePasse($email))
            header("Location: index.php?p=recover&p2=success");
        else
            header("Location: index.php?p=recover&p2=error");
    } 
    
    if(isset($_POST['Recover_motDePasse']) && isset($_POST['Recover_motDePasse2']))
    {
        $email = $_POST['Recover_emailHid'];
        $key = $_POST['Recover_keyHid'];
        $motDePasse = $_POST['Recover_motDePasseHid'];

        if($controleur->reinitialiserMotDePasse($email, $key, $motDePasse))
            header("Location: index.php?p=recover&p2=reset");
        else
            header("Location: index.php?p=recover&p2=error");
    } 
?>
<div class="container">
    <div class="row">
        <div class="span12">
               <?php
                    if(isset($_GET['email']) && isset($_GET['key']))
                    {
                        $controleur->allowForeignPwd($_GET['email'], $_GET['key']);
                        include 'module/compte/oubli/divisions/formulaireRecuperer.php';
                    }
                    else
                        include 'module/compte/oubli/divisions/formulaireOublier.php';
                ?>
        </div>
    </div>
</div>
