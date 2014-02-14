<form method="post" class="form form-inline" action="index.php" id="connectionForm">
    <div class="input-prepend">
        <span class="add-on"><i class="icon-envelope"></i></span>
        <input class="input-small" id="Connect_email" name="Connect_email" type="text" placeholder="Email" style="width:120px;" maxlength="200">
    </div>

    <div class="input-prepend">
        <span class="add-on"><i class="icon-lock"></i></span>
        <input type="password" class="input-small" id="Connect_motDePasse2" name="Connect_motDePasse2" placeholder="Mot de passe" style="width:120px;" maxlength="64">
    </div>
    <input value="Connexion" type="submit" class="btn btn-small btn-primary" style="font-size: 13px;" title="Cliquez ici pour vous connecter sur InvestPorc" />

    <!-- Champs caché -->
    <input value="" id="Connect_motDePasseHid" name="Connect_motDePasseHid" type="hidden" />

    <div class="controls controls-row" style="font-size: 13px;">       
        <div id="controlErrorChamps" style="display: none;">
            <i><span id="Connect_erreurEmail" class="help-inline"></span></i>  <i><span id="Connect_erreurMdp" class="help-inline"></span></i> <br />
        </div>
        <a href="index.php?p=register"> Enregistrer un compte</a> | 
        <a href="index.php?p=recover"> Mot de passe oublié ?</a>
    </div>
</form>
