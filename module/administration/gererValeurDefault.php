<?php
    if($controleur->allowMaster())
        $controleur->forbidden();
    
    if($_POST['valeur'] != "")
    {
        $obj = new DefaultValue($_POST['intitule'], $_POST['valeur'], $_POST['description']);
        $controleur->updateDefaultValue($obj);
    }
    
    $val = NULL;
    
    if(isset($_GET["p2"]))
        if($_GET["p2"] != "")
            $val = $controleur->getInfoDefaultValue($_GET["p2"]);
        
?>

<div class="container">
    <div class="row">
        <div class="span12">
            <legend>Gèrer les valeurs par défaut</legend>
            <blockquote>
                <p style="font-size: 14px;">
                    <Strong>
                        Le module de gestion des différentes valeurs par défault utilisées par le formulaire.
                    </strong>
                </p>
            </blockquote>
        </div>
        
        <div class="span9" style="margin-left: 100px; <?php if(isset($_GET["p2"])) echo 'display: block;'; else echo 'display: none;'; ?>">
            <legend>Modification d'une donnée</legend>
            
            <form id="form-modif-var" method="post" action="index.php?p=defaultValue">
                <label class="control-label">
                    <b>* </b>Intitule <input id="intitule" name="intitule" style="width: 100px;" value="<?php if($val != NULL) echo $val->getIntitule() ?>" role="input" type="text" readonly="readonly" >
                    <b>* </b>Description <input id="description" name="description" style="width: 400px;" value="<?php if($val != NULL) echo $val->getDescription() ?>" role="input" type="text" >
                    <b>* </b>Valeur <input id="valeur" name="valeur" style="width: 100px;" step="any" role="input" value="<?php if($val != NULL) echo $val->getValeur() ?>" type="number" >
                    <button class="btn btn-mini btn-info" type="submit"><i class="icon-pencil icon-white"></i></button>
                </label>
            </form>
        </div>
        
        <div class="span12">
            <table class="table table-striped" id="tableValueFixed">
              <thead>
                <tr>
                  <th width="50px">#</th>
                  <th width="10%">Intitulé</th>
                  <th scope='col'>Description</th>
                  <th width="10%">Valeur</th>
                  <th width="5%">Modification</th>
                </tr>
              </thead>
              <tbody>
                <?php
                      //Rapatriement de tous les objets de type DefaultValue
                      $list = $controleur->getAllDefaultValue();

                      for($i = 0; $i < Count($list); $i++)
                          echo $list[$i];
                ?>
              </tbody>
            </table>
         </div>
    </div>
</div>

<script language="javascript" type="text/javascript">
//<![CDATA[
        setProtocole(2);
        
        var table1Filters = {
                col_0: "select",
                col_4: "select"
        }
        setFilterGrid("tableValueFixed",table1Filters);
//]]>
</script>