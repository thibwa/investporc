<div class="row">
    <div class="span3"><strong>Adresse e-mail</strong></div>
    <div class="pull-right">
        <div class="span3"  style="font-size: 16px;"><i><?php echo $email; ?></i></div>
        <div class="span1">
            <a href="#" onclick="$('#modifEmail').slideToggle('slow')"><i class="icon-pencil"></i></a>
        </div>
    </div>
    <div class="span9 pull-right" id="modifEmail" style="display: none;">
        <div class="pull-right" style="margin-top: 15px; margin-right: 65px;">
            <form method="post" action="index.php?p=moncompte"id="modifEmailForm">
                <label class="control-label" style="font-size: 14px;">
                    <b>* </b>Email
                </label>
                <div class="controls">
                    <input id="Modif_email" name="Modif_email" style="width: 300px;" role="input" placeholder="Votre email" type="text"  maxlength="200">
                    <br /><i><span id="Modif_erreurEmail" class="help-inline"></span></i>
                </div>

                <input value="Modifier e-mail" type="submit" id="Modif_submitButtonEmail" class="btn btn-primary" title="Cliquez ici pour modifier votre email" /> 
            </form>
        </div>
    </div>
</div>