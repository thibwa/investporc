<?php
    if(isset($_GET["p2"]))
    {
        switch ($_GET["p2"])
        {
            case "error":
                include 'module/compte/oubli/divisions/alert/alert-errorOubli.php';
                break;
            case "success":
                include 'module/compte/oubli/divisions/alert/alert-successOubli.php';
                break;
            case "reset":
                include 'module/compte/oubli/divisions/alert/alert-successReset.php';
                break;
            default:
                header ('index.php?p=erreur404');
                break;
        }
    }
    
    include 'module/compte/oubli/divisions/alert/alert-errorForm.php';
?> 

<form method="post" action="index.php?p=recover" id="recovEForm">
    <fieldset>
        <legend>Mot de passe oublié ?</legend>
        <label class="control-label">
            <b>* </b>Email
        </label>
        <div class="controls">
            <input id="Recover_email" name="Recover_email" placeholder="Votre email" style="width: 280px;" role="input" aria-required="true" type="text" maxlength="200">
            <i><span id="Recover_erreurEmail" class="help-inline"></span></i>
        </div>
        
        <input value="Envoyer" type="submit" name="submit" id="Recover_submitButton" class="btn btn-primary" title="Cliquez ici pour vous inscrire sur InvestPorc" /> 
    </fieldset>
</form>