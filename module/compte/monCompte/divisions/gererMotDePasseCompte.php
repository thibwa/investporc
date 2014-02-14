<div class="row">
    <div class="span3"><strong>Mot de passe</strong></div>
    <div class="pull-right">
        <div class="span3"  style="font-size: 16px;"><i>*******************</i></div>
        <div class="span1"><a href="#" onclick="$('#modifMotDePasse').slideToggle('slow')"><i class="icon-pencil"></i></a></div>
    </div>
    <div class="span9 pull-right" id="modifMotDePasse" style="display: none;">
        <div class="pull-right" style="margin-top: 15px; margin-right: 65px;">
            <form method="post" action="index.php?p=moncompte" id="modifMotDePasseForm">
                <label class="control-label" style="font-size: 14px;">
                    <b>* </b>Ancien mot de passe
                </label>
                <div class="controls">
                    <input id="Modif_ancienMotDePasse" name="Modif_ancienMotDePasse" placeholder="Votre ancien mot de passe" style="width: 300px;" role="input" aria-required="true" type="password" maxlength="64">
                    <br /><i><span id="Modif_ancienErreurMotDePasse" class="help-inline"></span></i>
                </div>

                <label class="control-label" style="font-size: 14px;">
                    <b>* </b>Mot de passe
                </label>
                <div class="controls">
                    <input id="Modif_motDePasse" name="Modif_motDePasse" placeholder="Votre mot de passe" style="width: 300px;" role="input" aria-required="true" type="password" maxlength="64">
                    <br /><i><span id="Modif_erreurMotDePasse" class="help-inline"></span></i>
                </div>

                <label class="control-label" style="font-size: 14px;">
                    <b>* </b>Confirmez votre mot de passe
                </label>
                <div class="controls">
                    <input id="Modif_motDePasse2" name="Modif_motDePasse2" placeholder="Confirmez votre mot de passe" style="width: 300px;" role="input" aria-required="true" type="password" maxlength="64">
                    <br /><i><span id="Modif_erreurMotDePasse2" class="help-inline"></span></i>
                </div>

                <input value="Modifier mot de passe" type="submit" id="Modif_submitButtonMdp" class="btn btn-primary" title="Cliquez ici pour modifier votre mot de passe" /> 
                <input value="<?php echo $controleur->user('motdepasse'); ?>" type="hidden" id="Modif_ancienMotDePasseHid" name="Modif_ancienMotDePasseHid"/>
                <input type="hidden" id="Modif_motDePasseHid" name="Modif_motDePasseHid"/>
            </form>
        </div>
    </div>
</div>