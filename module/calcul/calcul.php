<?php
    //$controleur->resetForm($controleur->user('email'),session_id());
?>

<div class="container">
    <div class="row">
       <div class="span8">
            <legend>Conditions d'utilisation</legend>
        </div>

        <div class="pull-right img-polaroid visible-desktop">
            <div id="coin-slider">
                <?php
                     $rep = "img/layout/";
                     $extensions_autorisees = array('png', 'jpg', 'jpeg', 'gif');
                     
                     $dir = opendir($rep);

                        while ($f = readdir($dir))
                        {
                             if(is_file($rep.$f) && in_array(pathinfo($f, PATHINFO_EXTENSION), $extensions_autorisees)) {
                                echo "<img src=\"img/layout/".$f."\" />";
                                echo "<span>";
                                echo "<b>CRA-W</b>";
                                echo "</span>";
                             }
                        }
                         closedir($dir); 
                  ?>
            </div>
        </div>

        <div class="span8" id="calculContrat">
            <p><strong>A lire avant de commencer</strong></p>
            
            <p>Les résultats sont des estimations calculées sur base de données 
            de terrain et de l'encodage réalisé par l'utilisateur. 
            Ils ne garantissent nullement la rentabilité finale du projet qui est 
            dépendante de multiples facteurs (conditions pédoclimatiques, conditions 
            sanitaires, technicité de l'éleveur,… ). Le module de calcul permet 
            d'apprécier l'influence de ceux-ci.</p>
            
            <p>Ils donnent néanmoins une estimation des frais liés à l'installation, des frais 
            de fonctionnement et du revenu dégagé du projet étudié.</p>
            
            <p>L'utilisateur étant le seul responsable des calculs effectués, le CRA-W ne peut 
            être tenu pour responsable de l'utilisation de l'outil et de l'usage fait des résultats. <br />
            Il est strictement interdit de copier, de modifier, ou de diffuser le site Web en 
            tout ou en partie, sous quelque forme que ce soit à moins d'avoir obtenu préalablement 
            l'autorisation écrite du CRA-W. </p>
           
            <br/>
            <a class="btn btn-primary visible-phone" type="button" href="index.php?p=formulaire">J'accepte</a>
            <br />
            <div class="pull-right hidden-phone" style="padding-bottom: 5px;">
            <a class="btn btn-primary" type="button" href="index.php?p=formulaire">J'accepte</a>
            </div>
        </div> 
    </div>
</div>
