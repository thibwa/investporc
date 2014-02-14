<form method="post" action="index.php?p=recover" id="recovMForm">
    <fieldset>
        <legend>Réinitialisez votre mot de passe pour <i><?php echo $_GET['email'];?></i></legend>
        <label class="control-label">
            <b>* </b>Nouveau mot de passe
        </label>
        <div class="controls">
            <input id="Recover_motDePasse" name="Recover_motDePasse" placeholder="Votre mot de passe" style="width: 280px;" role="input" aria-required="true" type="password" maxlength="64">
            <i><span id="Recover_erreurMotDePasse" class="help-inline"></span></i>
        </div>
        
        <label class="control-label">
            <b>* </b>Confirmez votre nouveau mot de passe 
        </label>
        <div class="controls">
            <input id="Recover_motDePasse2" name="Recover_motDePasse2" placeholder="Confirmez votre mot de passe" style="width: 280px;" role="input" aria-required="true" type="password" maxlength="64">
            <i><span id="Recover_erreurMotDePasse2" class="help-inline"></span></i>
        </div>
        
        <input value="Envoyer" type="submit" name="submit" id="Recover_submitButton" class="btn btn-primary" title="Cliquez ici pour vous inscrire sur InvestPorc" /> 
        <input value="" id="Recover_motDePasseHid" name="Recover_motDePasseHid" type="hidden" />
        <input value="<?php echo $_GET['email'];?>" id="Recover_emailHid" name="Recover_emailHid" type="hidden" />
        <input value="<?php echo $_GET['key'];?>" id="Recover_keyHid" name="Recover_keyHid" type="hidden" />
    </fieldset>
</form>
