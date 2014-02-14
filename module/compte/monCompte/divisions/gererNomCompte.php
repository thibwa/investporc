<div class="row">
    <div class="span3"><strong>Nom, Prénom</strong></div>
    <div class="pull-right">
        <div class="span3" style="font-size: 16px;"><i><?php echo $nomprenom; ?></i></div>
        <div class="span1"><a href="#" onclick="$('#modifNom').slideToggle('slow')"><i class="icon-pencil"></i></a></div>
    </div>

    <div class="span9 pull-right" id="modifNom" style="display: none;">
        <div class="pull-right" style="margin-top: 15px; margin-right: 65px;">
            <form method="post" action="index.php?p=moncompte" id="modifNomForm">
                <label class="control-label" style="font-size: 14px;">
                    <b>* </b>Nom, prénom
                </label>
                <div class="controls">
                    <input id="Modif_nom" name="Modif_nom" style="width: 300px;" role="input" placeholder="Votre nom" type="text" maxlength="200">
                    <br /><i><span id="Modif_erreurNom" class="help-inline"></span></i>
                </div>

                <input value="Modifier nom" type="submit" id="Modif_submitButtonNom" class="btn btn-primary" title="Cliquez ici pour modifier votre nom" /> 
            </form>
        </div>
    </div>
</div>