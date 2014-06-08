<?php
    if(isset($_POST['Re_name']) && isset($_POST['Re_email']) && isset($_POST['Re_motDePasseHid']))
    {
        $name = $_POST['Re_name'];
        $email = $_POST['Re_email']; 
        $mdp = $_POST['Re_motDePasseHid'];
        echo $mdp;
        if($controleur->ajouterMembre($name, $email, $mdp))
            header("Location: index.php?p=register&p2=success");
        else
            header("Location: index.php?p=register&p2=error");
    } 
?>

<form method="post" action="index.php?p=register" id="creationCompteForm">
    <fieldset>
        <legend>Inscrivez-vous sur InvestPorc</legend>
        <div>      
            <?php
                if(isset($_GET["p2"]))
                {
                    switch ($_GET["p2"])
                    {
                        case "error":
                            include 'module/compte/creation/divisions/alert/alert-errorCreation.php';
                            break;
                        case "success":
                            include 'module/compte/creation/divisions/alert/alert-successCreation.php';
                            break;
                        default:
                            header ('index.php?p=erreur404');
                            break;
                    }
                }
                
                include 'module/compte/creation/divisions/alert/alert-errorForm.php';
            ?> 
        </div>
        <label class="control-label">
            <b>* </b>Nom, Prénom
        </label>
        <div class="controls">
            <input id="Re_name" name="Re_name" style="width: 300px;" role="input" placeholder="Votre nom" type="text" maxlength="200">
            <i><span id="Re_erreurName" class="help-inline"></span></i>
        </div>
        <label class="control-label">
            <b>* </b>Email
        </label>
        <div class="controls">
            <input id="Re_email" name="Re_email" placeholder="Votre email" style="width: 300px;" role="input" aria-required="true" type="text" maxlength="200">
            <i><span id="Re_erreurEmail" class="help-inline"></span></i>
        </div>
        <label class="control-label">
            <b>* </b>Mot de passe
        </label>
        <div class="controls">
            <input id="Re_motDePasse" name="Re_motDePasse" placeholder="Votre mot de passe" style="width: 300px;" role="input" aria-required="true" type="password" maxlength="64">
            <i><span id="Re_erreurMotDePasse" class="help-inline"></span></i>
        </div>
        
        <label class="control-label">
            <b>* </b>Confirmez votre mot de passe
        </label>
        <div class="controls">
            <input id="Re_2motDePasse" name="Re_2motDePasse" placeholder="Confirmez votre mot de passe" style="width: 300px;" role="input" aria-required="true" type="password" maxlength="64">
            <i><span id="Re_2erreurMotDePasse" class="help-inline"></span></i>
        </div>
        
        <input value="S'inscrire" type="submit" id="Re_submitButton" class="btn btn-primary" title="Cliquez ici pour vous inscrire sur InvestPorc" /> 
        <input value="" id="Re_motDePasseHid" name="Re_motDePasseHid" type="hidden" />
    </fieldset>
</form>