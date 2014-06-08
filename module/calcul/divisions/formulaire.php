<?php
    if($controleur->getAllReponseFormCalcul(session_id()) != null){
        ?>
            <div class="visible-desktop pull-right" style="margin-bottom: -40px;">
                <img src="img/printer.png" id="printerForm" onclick="javascript:printDataProject()" title="Impression des données du projet" />
            </div>
        <?php
    }
?>
<form id="form-calcul-projet" method="post" action="/TFE/index.php?p=formulaire&p2=calcul">
    
    <div idid="etape-1" style="">
        <legend>ETAPE 1 : Contexte</legend>
        
            <div style="margin-left: 50px">
            <label class="control-label">
                Profil utilisateur

                <select name='pu' id='pu'>
                        <option value='' <?php if(is_numeric($controleur->getValue("pu",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                        <option value='provisoire' <?php if($controleur->getValue("pu",$list) == 'provisoire') echo 'selected="selected"'; ?>>Agriculteur (Projet provisoire)</option>
                        <option value='concret' <?php if($controleur->getValue("pu",$list) == 'concret') echo 'selected="selected"'; ?>>Agriculteur (Projet concret)</option>
                        <option value="encadrement" <?php if($controleur->getValue("pu",$list) == "encadrement") echo 'selected="selected"'; ?>>Service d'encadrement</option>
                        <option value='autre' <?php if($controleur->getValue("pu",$list) == 'autre') echo 'selected="selected"'; ?>>Autre</option>
                </select>
            </label>

            <label class="control-label">
                Exploitation agricole

                <select name='ea' id='ea'>
                        <option value='' <?php if(is_numeric($controleur->getValue("ea",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                        <option value='NE' <?php if($controleur->getValue("ea",$list) == 'NE') echo 'selected="selected"'; ?>>Nouvelle exploitation</option>
                        <option value='EEAP' <?php if($controleur->getValue("ea",$list) == 'EEAP') echo 'selected="selected"'; ?>>Exploitation existante avec porcs</option>
                        <option value="EESP" <?php if($controleur->getValue("ea",$list) == 'EESP') echo 'selected="selected"'; ?>>Exploitation existante sans porc</option>
                </select>
            </label>

            <label class="control-label">
                Financement

                <select name='financement' id='financement'
                        onchange="if(this.value == 'FP') javascript:bascule('3-DIV-fonds_propres_disponibles', null, true); else 
                            { javascript:bascule('3-DIV-fonds_propres_disponibles', null, false);}">
                        <option value='' <?php if(is_numeric($controleur->getValue("financement",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                        <option value='Emprunt' <?php if($controleur->getValue("financement",$list) == 'Emprunt') echo 'selected="selected"'; ?>>Emprunt (6%)</option>
                        <option value='FP' <?php if($controleur->getValue("financement",$list) == 'FP') echo 'selected="selected"'; ?>>Fonds propres (2% - capital immobilisé)</option>
                </select>
                <div id='3-DIV-fonds_propres_disponibles' style='display:none; margin-left: 50px;'>
                    <blockquote>
                        <label class="control-label">Entrez fonds propres disponibles: </label>
                        <input size='8' type=text name='fp' id='fp' value="<?php echo $controleur->getValue("fp",$list); ?>">
                    </blockquote>
                </div>
            </label>

            <label class="control-label">
                Commercialisation<br>
                <small><em>Il s'agit du type de filière choisie pour la commercialisation des porcs produits.</em></small>
            </label>
            <select name='commercialisation' id='commercialisation' onchange="javascript:getCalcul_com()">
                    <option value='' <?php if(is_numeric($controleur->getValue("commercialisation",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                    <option value='Filière porc en plein air' <?php if($controleur->getValue("commercialisation",$list) == 'Filière porc en plein air') echo 'selected="selected"'; ?>>Filière porc en plein air</option>
                    <option value='Filière bio' <?php if($controleur->getValue("commercialisation",$list) == 'Filière bio') echo 'selected="selected"'; ?>>Filière bio</option>
                    <option value='Autre commercialisation' <?php if($controleur->getValue("commercialisation",$list) == 'Autre commercialisation') echo 'selected="selected"'; ?>>Autre commercialisation</option>
            </select>

            <label class="control-label">
                Elevage<br>
                <small><em>Voulez-vous faire du naissage?</em></small>
            </label>
            <select name='naissage' id='naissage'
                    onchange="if(this.value == 'Oui') 
                        { 
                            javascript:bascule('etape-2-elevage', null, true); 
                            javascript:bascule('etape-4-generalite', null, false);
                            document.getElementById('ce').selectedIndex = 0;
                            javascript:bascule('etape-3-engraissement', null, false);
                            document.getElementById('icde25a125').selectedIndex = 0;
                            document.getElementById('hpe').selectedIndex = 0;
                            document.getElementById('pe').selectedIndex = 0;
                            javascript:bascule('101-poids_achat_porcelets', null, false);
                        } else if(this.value == 'Non') { 
                            javascript:bascule('101-poids_achat_porcelets', null, true); 
                            javascript:bascule('etape-2-elevage', null, false);
                            document.getElementById('icde25a125').selectedIndex = 0;
                            document.getElementById('hpe').selectedIndex = 0;
                            document.getElementById('pe').selectedIndex = 0;
                            document.getElementById('ceb').selectedIndex = 0;
                            document.getElementById('nbps').selectedIndex = 0;
                            document.getElementById('hm').selectedIndex = 0;
                            document.getElementById('pm').selectedIndex = 0;
                            document.getElementById('hg').selectedIndex = 0;
                            document.getElementById('pg').selectedIndex = 0;
                            document.getElementById('dpn').selectedIndex = 0;
                            document.getElementById('hpav').selectedIndex = 0;
                            javascript:bascule('etape-3-engraissement', null, true);
                            javascript:bascule('etape-4-generalite', null, false); 
                            document.getElementById('ce').selectedIndex = 0;
                        } else
                        {
                            javascript:bascule('etape-4-generalite', null, false); 
                            javascript:bascule('etape-2-elevage', null, false);
                            javascript:bascule('101-poids_achat_porcelets', null, false);
                            javascript:bascule('etape-3-engraissement', null, false);
                            document.getElementById('ceb').selectedIndex = 0;
                            document.getElementById('nbps').selectedIndex = 0;
                            document.getElementById('hm').selectedIndex = 0;
                            document.getElementById('pm').selectedIndex = 0;
                            document.getElementById('hg').selectedIndex = 0;
                            document.getElementById('pg').selectedIndex = 0;
                            document.getElementById('dpn').selectedIndex = 0;
                            document.getElementById('hpav').selectedIndex = 0;

                            document.getElementById('icde25a125').selectedIndex = 0;
                            document.getElementById('hpe').selectedIndex = 0;
                            document.getElementById('pe').selectedIndex = 0;

                            document.getElementById('ce').selectedIndex = 0;
                        } javascript:getCalcul_nais();">
                    <option value='' <?php if(is_numeric($controleur->getValue("naissage",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                    <option value='Oui' <?php if($controleur->getValue("naissage",$list) == 'Oui') echo 'selected="selected"'; ?>>Oui</option>
                    <option value='Non' <?php if($controleur->getValue("naissage",$list) == 'Non') echo 'selected="selected"'; ?>>Non</option>
            </select>
            <div id='101-poids_achat_porcelets' style='display:none; margin-left: 20px;'>
               <blockquote>
                    <label class="control-label">Poids d'achat des porcelets (6 kg - 30 kg): </label>
                    <input type=text size=3 name='pdvpa' onkeyup="javascript:getPvpa()" id='pdvpa' value="<?php echo $controleur->getValue("pdvp",$list); ?>" onchange="javascript:checkValue(this.value, 6, 30)"> kg

                    <label class="control-label">Prix d'achat des porcelets (20€ - 100€): </label>
                    <input type=text size=3 name='pvpa' id='pvpa' value="<?php echo $controleur->getValue("pvp",$list); ?>" onchange="javascript:checkValue(this.value, 20, 100)"> <span class='unit'>€</span>
                </blockquote>
            </div>
        </div>
    </div>
    
    <div id="etape-2-elevage" style="display: none;">
        <legend>ETAPE 2 : Elevage</legend>
            <div style="margin-left: 50px;">
            <label class="control-label">
                <b>Paramètres élevages</b><br>
            </label>
            <blockquote>
                <p>Nombre de truies (10 - 150) : <input id="nbt" name="nbt" onkeyup="javascript:getCalcul_nbt()" style="width: 100px;" value="<?php echo $controleur->getValue("nbt",$list); ?>" role="input" type=text onchange="javascript:checkValue(this.value, 10, 150);"></p>
                <p>Prix d'achat d'une truie (150€ - 350€) : <input id="pat" name="pat" style="width: 100px;" value="<?php echo $controleur->getValue("pat",$list); ?>" role="input" type=text onchange="javascript:checkValue(this.value, 150, 350)"></p>
                <p>Prix de vente d'une truie de réforme (100€ - 400€) : <input id="prt" name="prt" value="<?php echo $controleur->getValue("prt",$list); ?>" style="width: 100px;" role="input" type=text onchange="javascript:checkValue(this.value, 100, 400)"></p>
                <p>Nombre de verrats (0 - 4) : <input style="width: 50px;" id="nbv" name="nbv" value="<?php echo $controleur->getValue("nbv",$list); ?>" role="input" type=text onchange="javascript:checkValue(this.value, 0, 4)"></p>
                <p>Prix d'achat d'un verrat (100€ - 2000€) : <input id="pav" name="pav" style="width: 100px;" value="<?php echo $controleur->getValue("pav",$list); ?>" role="input" type=text onchange="javascript:checkValue(this.value, 100, 2000)"></p>
            </blockquote>

            <label class="control-label">
                Conduite en bandes<br>
                <small><em>Seules les 2 conduites les plus courantes sont proposées. Ce choix a un impact sur le nombre de places à prévoir.</em></small>
            </label>
            <select name='ceb' id='ceb' onchange="javascript:getCalcul_ceb()">
                    <option value='' <?php if(is_numeric($controleur->getValue("ceb",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                    <option value='4 bandes' <?php if($controleur->getValue("ceb",$list) == '4 bandes') echo 'selected="selected"'; ?>>4 bandes</option>
                    <option value='7 bandes' <?php if($controleur->getValue("ceb",$list) == '7 bandes') echo 'selected="selected"'; ?>>7 bandes</option>
            </select>

            <label class="control-label">
                Performance<br>
                <small><em>Il s'agit du nombre de porcelets sevrés annuellement par truie.</em></small>
            </label>
            <select name='nbps' id='nbps' onchange="javascript:getCalcul_nbps()">
                    <option value='' <?php if(is_numeric($controleur->getValue("nbps",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                    <option value='24' <?php if($controleur->getValue("nbps",$list) == '24') echo 'selected="selected"'; ?>>Elevé (24)</option>
                    <option value='22' <?php if($controleur->getValue("nbps",$list) == '22') echo 'selected="selected"'; ?>>Moyen (22)</option>
                    <option value='20' <?php if($controleur->getValue("nbps",$list) == '20') echo 'selected="selected"'; ?>>Faible (20)</option>
            </select>

            <label class="control-label">
                <b>Paramètres divers</b><br>
            </label>
            <blockquote>
                <p>Nombre de cycles par an (1,8 cycles - 2,6 cycles) : <input id="nbcy" name="nbcy" onchange="javascript:getCalcul_nbps()()" value="<?php echo $controleur->getValue("nbcy",$list); ?>" style="width: 100px;" role="input" type=text onchange="javascript:checkValue(this.value, 1.8, 2.6)"></p>
                <p>Age des porcelets au sevrage (20 jours - 40 jours) : <input id="aps" name="aps" style="width: 100px;" value="<?php echo $controleur->getValue("aps",$list); ?>" role="input" type=text onchange="javascript:checkValue(this.value, 20, 40)"></p>
                <p>Consommation journalière d'aliments lactation par truie (4 kg - 10 kg) : <input id="cjal" name="cjal" value="<?php echo $controleur->getValue("cjal",$list); ?>" style="width: 100px;" role="input" type=text onchange="javascript:checkValue(this.value, 4, 10)"></p>
                <p>Consommation journalière d'aliments gestation par truie (1 kg - 5 kg) : <input id="cjag" name="cjag" value="<?php echo $controleur->getValue("cjag",$list); ?>" style="width: 100px;" role="input" type=text onchange="javascript:checkValue(this.value, 1, 5)"></p>
                <p>Prix d'achat d'un silo (100 € - 2000 €) : <input id="cs" name="cs" style="width: 100px;" value="<?php echo $controleur->getValue("cs",$list); ?>" role="input" type=text onchange="javascript:checkValue(this.value, 100, 2000)"></p>
                <p>Nombre de silos : <input id="nbslg" name="nbslg" value="<?php echo $controleur->getValue("nbslg",$list); ?>" style="width: 100px;" role="input" type=text></p>
                <p>Prix de l'aliment de lactation (€/kg) : <input id="pal" name="pal" value="<?php echo $controleur->getValue("pal",$list); ?>" style="width: 100px;" role="input" type=text></p>
                <p>Prix de l'aliment de gestation (€/kg) : <input id="pag" name="pag" style="width: 100px;" value="<?php echo $controleur->getValue("pag",$list); ?>" role="input" type=text></p>
                <p>Prix de l'aliment de sevrage pour porcelets (€/kg) : <input id="pase" name="pase" value="<?php echo $controleur->getValue("pase",$list); ?>" style="width: 100px;" role="input" type=text></p>
                <p>Mortalité des porcelets en post-sevrage (0 % - 10 %) : <input id="mse" name="mse" style="width: 100px;" value="<?php echo $controleur->getValue("mse",$list); ?>" role="input" type=text onchange="javascript:checkValue(this.value, 0, 10)"></p>
            </blockquote>

            <label class="control-label">
                Hébergement en maternité<br>
                <small><em>Veuillez choisir où seront hébergées les truies en maternité. 
                    Le nombre de places est calculé automatiquement. Le coût d'une place est 
                    prédéfini mais peut être modifié dans le cas d'un nouveau bâtiment. Si un 
                    bâtiment existant est utilisé pour la maternité mais peut-être aussi pour 
                    d'autres fins, sa valeur actuelle sera demandée en fin de module.</em></small>
            </label>
            <select name='hm' id="hm"
                    onchange="if(this.value == 'Bâtiment neuf') 
                        javascript:bascule('10-DIV-montant_batiment_neuf_maternite', null, true); else 
                        { javascript:bascule('10-DIV-montant_batiment_neuf_maternite', null, false);} javascript:getMbnm();">
                    <option value='' <?php if(is_numeric($controleur->getValue("hm",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                    <option value='Cabanes' <?php if($controleur->getValue("hm",$list) == 'Cabanes') echo 'selected="selected"'; ?>>Cabanes</option>
                    <option value='Bâtiment existant' <?php if($controleur->getValue("hm",$list) == 'Bâtiment existant') echo 'selected="selected"'; ?>>Bâtiment existant</option>
                    <option value='Bâtiment neuf' <?php if($controleur->getValue("hm",$list) == 'Bâtiment neuf') echo 'selected="selected"'; ?>>Bâtiment neuf</option>
            </select>
                <div id='10-DIV-montant_batiment_neuf_maternite' style='display:none; margin-left: 20px;'>
                    <blockquote>    
                        <label class="control-label">Montant du bâtiment neuf:</label>
                        <input type=text size=8 name='mbnm' id='mbnm' value="<?php echo $controleur->getValue("mbnm",$list); ?>"> <span class='unit'>€</span>
                    </blockquote>
                </div>


            <label class="control-label">
                Prairie en maternité ?<br>
                <small><em>Les truies en lactation ont-elles accès à des prairies? 
                    Si oui, la surface pour toutes les places nécessaires est 
                    calculée automatiquement mais peut-être modifiée.</em></small>
            </label>
            <select name='pm' id="pm"
                    onchange="if(this.value == 'Oui') javascript:bascule('11-DIV-prairie-maternite', null, true); else { javascript:bascule('11-DIV-prairie-maternite', null, false);}
                        javascript:getSpatm();">
                    <option value='' <?php if(is_numeric($controleur->getValue("pm",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                    <option value='Oui' <?php if($controleur->getValue("pm",$list) == 'Oui') echo 'selected="selected"'; ?>>Oui</option>
                    <option value='Non' <?php if($controleur->getValue("pm",$list) == 'Non') echo 'selected="selected"'; ?>>Non</option>
            </select><br /><br />
                <div id='11-DIV-prairie-maternite' style='display:none;  margin-left: 20px;'>
                    <blockquote>    
                        <label class="control-label">Surface nécessaire:</label>
                        <input type=text size=3 name='spatm' id="spatm" onkeyup="javascript:lt()" value="<?php echo $controleur->getValue("spatm",$list); ?>"> Ha
                    </blockquote>
                </div>

            <label class="control-label">
                Hébergement en gestation<br>
                <small><em>Veuillez choisir où seront hébergées les truies après sevrage et en gestation. 
                    Le nombre de places est calculé automatiquement. Le coût d'une place est prédéfini 
                    mais peut-être modifié dans le cas d'un nouveau bâtiment. Si un bâtiment existant 
                    est utilisé pour la gestation mais peut-être aussi pour d'autres fins, sa valeur 
                    actuelle sera demandée en fin de module.</em></small>
            </label>
            <select name='hg' id="hg"
                    onchange="if(this.value == 'Bâtiment neuf') javascript:bascule('12-DIV-montant-batiment-neuf', null, true); else { 
                        javascript:bascule('12-DIV-montant-batiment-neuf', null, false);} javascript:getMbng();">
                    <option value='' <?php if(is_numeric($controleur->getValue("hg",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                    <option value='Cabanes' <?php if($controleur->getValue("hg",$list) == 'Cabanes') echo 'selected="selected"'; ?>>Cabanes</option>
                    <option value='Bâtiment existant' <?php if($controleur->getValue("hg",$list) == 'Bâtiment existant') echo 'selected="selected"'; ?>>Bâtiment existant</option>
                    <option value='Bâtiment neuf' <?php if($controleur->getValue("hg",$list) == 'Bâtiment neuf') echo 'selected="selected"'; ?>>Bâtiment neuf</option>
            </select>
                <div id='12-DIV-montant-batiment-neuf' style='display:none; margin-left: 20px;'>
                    <blockquote>
                        <label class="control-label">Montant du bâtiment neuf: </label>
                        <input type=text size=8 name='mbng' id="mbng" value="<?php echo $controleur->getValue("mbng",$list); ?>"> <span class='unit'>€</span>
                    </blockquote>
                </div>

            <label class="control-label">
                Prairie en gestation?<br>
                <small><em>Les truies gestantes ont-elles accès à des prairies? 
                    Si oui, la surface pour toutes les places nécessaires est 
                    calculée automatiquement mais peut être modifiée.</em></small>
            </label>
            <select name='pg' id="pg"
                    onchange="if(this.value == 'Oui') javascript:bascule('13-DIV-prairie-gestation', null, true); else { 
                    javascript:bascule('13-DIV-prairie-gestation', null, false);} javascript:getSpatg();">
                    <option value='' <?php if(is_numeric($controleur->getValue("pg",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                    <option value='Oui' <?php if($controleur->getValue("pg",$list) == 'Oui') echo 'selected="selected"'; ?>>Oui</option>
                    <option value='Non' <?php if($controleur->getValue("pg",$list) == 'Non') echo 'selected="selected"'; ?>>Non</option>
            </select><br /><br />
            <div id='13-DIV-prairie-gestation' style='display:none; margin-left: 20px;'>
                <blockquote>
                    <label class="control-label">Surface nécessaire: </label>
                    <input type=text size="3" name='spatg' id='spatg' onkeyup=" javascript:lt()" value="<?php echo $controleur->getValue("spatg",$list); ?>"> Ha<br />
                </blockquote>
            </div>

            <label class="control-label">
                Engraissement<br>
                <small><em>Comment seront valorisés les porcelets après le sevrage?</em></small>
            </label>
            <select name='dpn' id="dpn"
                    style="width: 400px !important;"
                    onchange = '
                    switch(this.value){
                        case "VTPE" :
                            javascript:bascule("14-DIV-engraissement-poids-vente-porcelets", null, true);
                            javascript:bascule("hebergement-porcelets", null, true);
                            javascript:bascule("14-DIV-engraissement-poids-sevrage", null, false); 
                            javascript:bascule("etape-4-generalite", null, true); 
                            javascript:bascule("etape-3-engraissement", null, false);
                            document.getElementById("icde25a125").selectedIndex = 0;
                            document.getElementById("hpe").selectedIndex = 0;
                            document.getElementById("pe").selectedIndex = 0;
							javascript:sommeBatiment(); javascript:sommeMar();
                            javascript:bascule("201-DIV-montant-batiment-neuf", null, false);
                            break;
                        case "VPPE" :
                            javascript:bascule("14-DIV-engraissement-poids-vente-porcelets", null, true);
                            javascript:bascule("hebergement-porcelets", null, true);
                            javascript:bascule("14-DIV-engraissement-poids-sevrage", null, false);
                            javascript:bascule("etape-4-generalite", null, false); 
                            document.getElementById("ce").selectedIndex = 0;
                            javascript:bascule("etape-3-engraissement", null, true);
                            javascript:bascule("201-DIV-montant-batiment-neuf", null, false);
                            break;
                        case "EPCF" :
                            javascript:bascule("14-DIV-engraissement-poids-vente-porcelets", null, false); 
                            javascript:bascule("hebergement-porcelets", null, true);
                            javascript:bascule("14-DIV-engraissement-poids-sevrage", null, true); 
                            javascript:bascule("etape-4-generalite", null, false); 
                            document.getElementById("ce").selectedIndex = 0;
                            javascript:bascule("etape-3-engraissement", null, true);
                            javascript:bascule("201-DIV-montant-batiment-neuf", null, false);
                            document.getElementById("hpav").selectedIndex = 0;
                            break;
                        case "" :
                            javascript:bascule("14-DIV-engraissement-poids-sevrage", null, false); 
                            javascript:bascule("201-DIV-montant-batiment-neuf", null, false);
                            javascript:bascule("hebergement-porcelets", null, false);
                            javascript:bascule("14-DIV-engraissement-poids-vente-porcelets", null, false);
                            javascript:bascule("etape-4-generalite", null, false); 
                            document.getElementById("ce").selectedIndex = 0;
                            javascript:bascule("etape-3-engraissement", null, false);
                            document.getElementById("icde25a125").selectedIndex = 0;
                            document.getElementById("hpe").selectedIndex = 0;
                            document.getElementById("pe").selectedIndex = 0;
                            document.getElementById("hpav").selectedIndex = 0;
                            break;
                    }javascript:getCalcul_dpn(); javascript:getCalcul_com(); javascript:nbpeTheorique();'>
                    <option value='' <?php if(is_numeric($controleur->getValue("dpn",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                    <option value='VTPE' <?php if($controleur->getValue("dpn",$list) == 'VTPE') echo 'selected="selected"'; ?>>Vente des porcelets (100%)</option>
                    <option value='VPPE' <?php if($controleur->getValue("dpn",$list) == 'VPPE') echo 'selected="selected"'; ?>>Engraissement d'une partie et vente des excédants</option>
                    <option value='EPCF' <?php if($controleur->getValue("dpn",$list) == 'EPCF') echo 'selected="selected"'; ?>>Engraissement en circuit fermé (0%)</option>
            </select>
            <div id='14-DIV-engraissement-poids-vente-porcelets' style='display:none; margin-left: 20px;'>
                <blockquote>
                    <label class="control-label">Poids de vente des porcelets (6 kg - 30 kg): </label>
                    <input type=text size=3 name='pdvp' onkeyup="javascript:getPvp()" id='pdvp' value="<?php echo $controleur->getValue("pdvp",$list); ?>" onchange="javascript:checkValue(this.value, 6, 30)"> kg

                    <label class="control-label">Prix de vente des porcelets (20€ - 100€): </label>
                    <input type=text size=3 name='pvp' id='pvp' value="<?php echo $controleur->getValue("pvp",$list); ?>" onchange="javascript:checkValue(this.value, 20, 100)"> <span class='unit'>€</span>
                </blockquote>
            </div>
            <div id='14-DIV-engraissement-poids-sevrage' style='display:none; margin-left: 20px;'>
                <blockquote> 
                    <label class="control-label">Poids au sevrage: </label>
                     <input type=text size=3 name='pdps' id='pdps' value="<?php echo $controleur->getValue("pdps",$list); ?>"> kg
                </blockquote>
            </div>

            <div id='hebergement-porcelets' style='display:none;'>
                <label class="control-label">
                    Hébergement des porcelets<br>
                    <small><em>Veuillez choisir où seront hébergés les porcelets sevrés. 
                        Le montant d'une place est prédéfini mais peut être modifié dans 
                        le cas d'un nouveau bâtiment. Si un bâtiment existant est utilisé 
                        pour la gestation mais peut-être aussi pour d'autres fins, son montant 
                        actuel sera demandé en fin de module.</em></small>
                </label>
                <select name='hpav' id="hpav"
                        onchange="if(this.value == 'Bâtiment neuf') javascript:bascule('201-DIV-montant-batiment-neuf', null, true); else {
                            javascript:bascule('201-DIV-montant-batiment-neuf', null, false);} javascript:getMbnpav();">
                        <option value='' <?php if(is_numeric($controleur->getValue("hpav",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                        <option value='Cabanes' <?php if($controleur->getValue("hpav",$list) == 'Cabanes') echo 'selected="selected"'; ?>>Cabanes</option>
                        <option value='Bâtiment existant' <?php if($controleur->getValue("hpav",$list) == 'Bâtiment existant') echo 'selected="selected"'; ?>>Bâtiment existant</option>
                        <option value='Bâtiment neuf' <?php if($controleur->getValue("hpav",$list) == 'Bâtiment neuf') echo 'selected="selected"'; ?>>Bâtiment neuf</option>
                </select>
                <div id='201-DIV-montant-batiment-neuf' style='display:none; margin-left: 20px;'>
                    <blockquote>
                        <label class="control-label">Montant du bâtiment neuf: </label>
                        <input type=text size=3 name='mbnpav' id='mbnpav' value="<?php echo $controleur->getValue("mbnpav",$list); ?>">
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    
    <div id='etape-3-engraissement' style='display:none;'>
        <legend>ETAPE 3 : Engraissement</legend>
        
        <div style="margin-left: 50px;">
            <label class="control-label">
                Nombre de places à l'engraissement (0 - 1500)
            </label>
            <input type=text size=3 name='nbpe' id="nbpe" value="<?php echo $controleur->getValue("nbpe",$list); ?>" 
                   onchange="javascript:checkValue(this.value, 0, 1500);javascript:infoNbpe();"
                   onkeyup="javascript:getNbse(); javascript:getSpape(); javascript:getMbne();"
                   onblur="if(document.getElementById('dpn').value == 'EPCF') javascript:nbpeTheorique();">

            <div class="alert alert-info" id="info_nbpe" style="display:none;">
               <div id="textError"></div>
            </div> 

            <label class="control-label">
                Indice de consommation
                <select name='icde25a125' id="icde25a125">
                        <option value='' <?php if(is_numeric($controleur->getValue("icde25a125",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                        <option value='Elevé' <?php if($controleur->getValue("icde25a125",$list) == 'Elevé') echo 'selected="selected"'; ?>>Elevé (3.3)</option>
                        <option value='Moyen' <?php if($controleur->getValue("icde25a125",$list) == 'Moyen') echo 'selected="selected"'; ?>>Moyen (3.5)</option>
                        <option value='Faible' <?php if($controleur->getValue("icde25a125",$list) == 'Faible') echo 'selected="selected"'; ?>>Faible (3.7)</option>
                </select>
            </label>

            <blockquote>
                <p>Prix des aliments de croissance (€/kg) : 
                    <input id="pac" type=text size=3 name='pac' value="<?php echo $controleur->getValue("pac",$list); ?>">
                </p>
                <p>Prix des aliments de finition (€/kg) : 
                    <input id="paf" type=text size=3 name='paf' value="<?php echo $controleur->getValue("paf",$list); ?>">
                </p>
                <p>Nombre de silos d'engraissement (0 - 3) : 
                    <input id="nbse" type=text size=3 name='nbse' value='<?php echo $controleur->getValue("nbse",$list); ?>' onchange="javascript:checkValue(this.value, 0, 3)">
                </p>
                <p>Mortalité en engraissement (0% - 10%) : 
                    <input id="me" type=text size=3 name='me' value="<?php echo $controleur->getValue("me",$list); ?>" onchange="javascript:checkValue(this.value, 0, 10)">
                </p>
            </blockquote>

            <label class="control-label">
                <b>Paramètres d'abattage</b>
            </label>
            <blockquote>
                <p>Poids d'abattage (110kg - 135kg) : 
                    <input id="pda" type=text size=3 name='pda' value="<?php echo $controleur->getValue("pda",$list); ?>" onchange="javascript:checkValue(this.value, 110, 135)">
                </p>
                <p>Prix de vente (€/kg de poids vif (0.5-3.5)) : 
                    <input id="prixdevente" type=text size=3 name='prixdevente' value="<?php echo $controleur->getValue("prixdevente",$list); ?>" onchange="javascript:checkValue(this.value, 0.5, 3.5)">
                </p>
            </blockquote>

            <label class="control-label">
                    Hébergement en engraissement<br>
                    <small><em>Veuillez choisir où seront hébergés les porcs à l'engraissement. 
                            Le nombre de places est calculé automatiquement. Le coût d'une place est 
                            prédéfini mais peut être modifié dans le cas d'un nouveau bâtiment. Si un 
                            bâtiment existant est utilisé pour l'engraissement , son valeur actuelle sera 
                            demandée ultérieurement.</em></small>
            </label>
            <select name='hpe' id="hpe"
                    onchange="if(this.value == 'Bâtiment neuf') javascript:bascule('403-DIV-montant-batiment-neuf', null, true); else {
                        javascript:bascule('403-DIV-montant-batiment-neuf', null, false);} javascript:getMbne();">
                    <option value='' <?php if(is_numeric($controleur->getValue("hpe",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                    <option value='Cabanes' <?php if($controleur->getValue("hpe",$list) == 'Cabanes') echo 'selected="selected"'; ?>>Cabanes</option>
                    <option value='Bâtiment existant' <?php if($controleur->getValue("hpe",$list) == 'Bâtiment existant') echo 'selected="selected"'; ?>>Bâtiment existant</option>
                    <option value='Bâtiment neuf' <?php if($controleur->getValue("hpe",$list) == 'Bâtiment neuf') echo 'selected="selected"'; ?>>Bâtiment neuf</option>
            </select>
            <div id='403-DIV-montant-batiment-neuf' style='display:none; margin-left: 20px;'>
                <blockquote>
                    <label class="control-label">Montant du bâtiment neuf: </label>
                    <input type=text size=3 name='mbne' id='mbne' value="<?php echo $controleur->getValue("mbne",$list); ?>">
                </blockquote>
            </div>

            <label class="control-label">
                Prairie en engraissement ?
            </label>
            <select name='pe' id="pe"
                    onchange="if(this.value == 'Oui') { 
                            javascript:bascule('404-DIV-prairie-gestation', null, true); 
                            javascript:bascule('etape-4-generalite', null, true);
                        } 
                        else if(this.value == 'Non') { 
                            javascript:bascule('404-DIV-prairie-gestation', null, false);
                            javascript:bascule('etape-4-generalite', null, true);
                        }
                        else { 
                            javascript:bascule('404-DIV-prairie-gestation', null, false); 
                            javascript:bascule('etape-4-generalite', null, false);
                            document.getElementById('ce').selectedIndex = 0;
                        } javascript:getSpape(); javascript:sommeBatiment(); javascript:sommeMar(); javascript:isAtLeastOneYesPrairieSelected();">
                    <option value='' <?php if(is_numeric($controleur->getValue("pe",$list))) echo 'selected="selected"'; ?>>[choisir]</option>
                    <option value='Oui' <?php if($controleur->getValue("pe",$list) == 'Oui') echo 'selected="selected"'; ?>>Oui</option>
                    <option value='Non' <?php if($controleur->getValue("pe",$list) == 'Non') echo 'selected="selected"'; ?>>Non</option>
            </select><br /><br />
            <div id='404-DIV-prairie-gestation' style='display:none; margin-left: 20px;'>
                <blockquote>
                    <label class="control-label">Surface nécessaire: </label>
                    <input type=text size=3 name='spape' id='spape' onkeyup="javascript:lt()" value="<?php echo $controleur->getValue("spape",$list); ?>"> Ha<br />
                </blockquote>
            </div>
        </div>
    </div>

    <div id='etape-4-generalite' style='display:none;'>
        <legend>ETAPE 4 : Généralités</legend>

        <div style="margin-left: 50px;">
            <div id="etape-4-prairie" style="display: none;">
                <label class="control-label">
                    <b>Prairies</b>
                </label>
                <blockquote>
                    <p>Coût du fermage par ha (€ / ha / an & 100 - 400) : <input id="cf" type=text size=3 name='cf' value="<?php echo $controleur->getValue("cf",$list); ?>" onchange="javascript:checkValue(this.value, 100, 400)"></p>
                    <p>Coût d'entretien des pâtures (€ / ha / an & 0 - 30) : <input id="cep" type=text size=3 name='cep' value="<?php echo $controleur->getValue("cep",$list); ?>" onchange="javascript:checkValue(this.value, 0, 30)"></p>
                    <p>Coût d'un mètre de clôture électrique et les piquets sont compris (€ /m & : 0.1 - 0.5) : <input id="cmce" type=text size=3 name='cmce' value="<?php echo $controleur->getValue("cmce",$list); ?>" onchange="javascript:checkValue(this.value, 0.1, 0.5)"></p>
                    <p>Coût d'un mètre de treillis et les piquets sont compris (€ /m & : 1 - 5) : <input id="cmt" type=text size=3 name='cmt' value="<?php echo $controleur->getValue("cmt",$list); ?>" onchange="javascript:checkValue(this.value, 1, 5)"></p>
                    <p>Longueur de clôture électrique (m) : <input id="lce" type=text size=6 name='lce' value="<?php echo $controleur->getValue("lce",$list); ?>"></p>
                    <p>Longueur de treillis (m) : <input id="lt" onkeyup="javascript:getLce()" type=text size=6 name='lt' value="<?php echo $controleur->getValue("lt",$list); ?>"></p>
                </blockquote>
            </div>

            <label class="control-label">
                Eau : <input id="ce" type=text size=3 name='ce' value="<?php echo $controleur->getValue("ce",$list); ?>">
            </label>

            <label class="control-label">
                Utilisation de véhicules agricoles
            </label>
            <table class="table">
                 <thead>
                    <tr>
                        <th>Choix</th>
                        <th>Véhicule</th>
                        <th>Temps annnuel (0h - 1000h)</th>
                        <th>Coût horaire (2€ - 25€)</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td><input type='checkbox' name='tracteur' id='tracteur' onclick="javascript:grise(this.checked,'ttp', 'tc');javascript:sommeMar();" <?php if($controleur->getValue("ttp",$list) != 0) echo 'checked=true'; ?>></td>
                          <td>Tracteur</td>
                          <td><input type=text size=3 name='ttp' id="ttp" onkeyup="javascript:sommeMar()" value="<?php echo $controleur->getValue("ttp",$list); ?>" onchange="javascript:checkValue(this.value, 0, 1000)" <?php if($controleur->getValue("ttp",$list) == 0) echo 'disabled=true'; ?>></td>
                          <td><input type=text size=3 name='tc' id='tc' onkeyup="javascript:sommeMar()" value="<?php echo $controleur->getValue("tc",$list); ?>" onchange="javascript:checkValue(this.value, 2, 25)" <?php if($controleur->getValue("ttp",$list) == 0) echo 'disabled=true'; ?>></td>
                      </tr>
                      <tr>
                          <td><input type='checkbox' name='telescopique' id='telescopique' onclick="javascript:grise (this.checked,'ttep', 'tec');javascript:sommeMar();" <?php if($controleur->getValue("ttep",$list) != 0) echo 'checked=true'; ?>></td>
                          <td>Téléscopique</td>
                          <td><input type=text size=3 name='ttep' id="ttep" onkeyup="javascript:sommeMar()" value="<?php echo $controleur->getValue("ttep",$list); ?>" onchange="javascript:checkValue(this.value, 0, 1000)" <?php if($controleur->getValue("ttep",$list) == 0) echo 'disabled=true'; ?>></td>
                          <td><input type=text size=3 name='tec' id='tec' onkeyup="javascript:sommeMar()" value="<?php echo $controleur->getValue("tec",$list); ?>" onchange="javascript:checkValue(this.value, 2, 25)" <?php if($controleur->getValue("tec",$list) == 0) echo 'disabled=true'; ?>></td>
                      </tr>
                      <tr>
                          <td><input type='checkbox' name='quad' id='quad' onclick="javascript:grise (this.checked,'qtp','qc');javascript:sommeMar();" <?php if($controleur->getValue("qtp",$list) != 0) echo 'checked=true'; ?>></td>
                          <td>Quad</td>
                          <td><input type=text size=3 name='qtp' id="qtp" onkeyup="javascript:sommeMar()" value="<?php echo $controleur->getValue("qtp",$list); ?>" onchange="javascript:checkValue(this.value, 0, 1000)" <?php if($controleur->getValue("qtp",$list) == 0) echo 'disabled=true'; ?>></td>
                          <td><input type=text size=3 name='qc' id='qc' onkeyup="javascript:sommeMar()" value="<?php echo $controleur->getValue("qc",$list); ?>" onchange="javascript:checkValue(this.value, 2, 25)" <?php if($controleur->getValue("qc",$list) == 0) echo 'disabled=true'; ?>></td>
                      </tr>

                      <tr>
                          <td><input type='checkbox' name='autre1' id='autre' onclick="javascript:grise (this.checked,'atp','ac');javascript:sommeMar();" <?php if($controleur->getValue("atp",$list) != 0) echo 'checked=true'; ?>></td>
                          <td>Autre</td>
                          <td><input type=text size=3 name='atp' id="atp" onkeyup="javascript:sommeMar()" value="<?php echo $controleur->getValue("atp",$list); ?>" onchange="javascript:checkValue(this.value, 0, 1000)" <?php if($controleur->getValue("atp",$list) == 0) echo 'disabled=true'; ?>></td>
                          <td><input type=text size=3 name='ac' id='ac' onkeyup="javascript:sommeMar()" value="<?php echo $controleur->getValue("ac",$list); ?>" onchange="javascript:checkValue(this.value, 2, 25)" <?php if($controleur->getValue("ac",$list) == 0) echo 'disabled=true'; ?>></td>
                      </tr>
                  </tbody>
            </table>
            <hr>
            <p>Total coût véhicule <input type=text name='mar' id="mar" size='6' value="<?php  echo $controleur->getValue("mar",$list); ?>"> <span class='unit'>€</span></p>

            <div class="alert alert-info">
                Vous pouvez calculer en vous aidant du module <a href="http://mecacost.cra.wallonie.be/index.php?page=7" id="MailSite" target="_blank">Mecacost</a>. 
                Celui-ci est basé sur une méthode reconnue et des données fiables représentatives du marché .Il vous permet de calculer le coût 
                d’utilisation prévisionnel total mais également par postes (consommation, entretien, réparation, amortissement, intérêts, 
                assurances/taxes et main d’œuvre du matériel agricole). Le calcul peut être effectué pour une seule machine ou pour un chantier.
            </div>

            <label class="control-label">
                Valeur actuelle d'autres bâtiments destinés à la spéculation porcine
            </label>
            <blockquote>
                <p>Bâtiment 1 <input type=text name='mab1' id="mab1" size='6' onkeyup="javascript:sommeBatiment()" value="<?php echo $controleur->getValue("mab1",$list); ?>"> <span class='unit'>€</span></p>
                <p>Bâtiment 2 <input type=text name='mab2' id="mab2" size='6' onkeyup="javascript:sommeBatiment()" value="<?php echo $controleur->getValue("mab2",$list); ?>"> <span class='unit'>€</span></p>
                <p>Bâtiment 3 <input type=text name='mab3' id="mab3" size='6' onkeyup="javascript:sommeBatiment()" value="<?php echo $controleur->getValue("mab3",$list); ?>"> <span class='unit'>€</span></p>
                <p>Bâtiment 4 <input type=text name='mab4' id="mab4" size='6' onkeyup="javascript:sommeBatiment()" value="<?php echo $controleur->getValue("mab4",$list); ?>"> <span class='unit'>€</span></p>
                <p>Bâtiment 5 <input type=text name='mab5' id="mab5" size='6' onkeyup="javascript:sommeBatiment()" value="<?php echo $controleur->getValue("mab5",$list); ?>"> <span class='unit'>€</span></p>
                <hr>
                <p>Total coût bâtiment <input type=text name='mab' id="mab" size='6' value="<?php echo $controleur->getValue("mab",$list); ?>" readonly> <span class='unit'>€</span></p>
            </blockquote>
        </div>
    </div>

    <hr />
    
    <button type="submit" id="btn-calculer" class="btn btn-primary">Calculer</button>
    <a href="index.php?p=calcul" class="btn">Réinitialiser</a>
</form>


<!--Zone caché permettant de stocker des variables contenant des valeurs par défaut -->
<input type=text style="display: none;" id="palbio" value="<?php echo $controleur->getValue("palbio",$listF); ?>" />
<input type=text style="display: none;" id="palpp" value="<?php echo $controleur->getValue("palpp",$listF); ?>" />
<input type=text style="display: none;" id="pagbio" value="<?php echo $controleur->getValue("pagbio",$listF); ?>" />
<input type=text style="display: none;" id="pagpp" value="<?php echo $controleur->getValue("pagpp",$listF); ?>" />
<input type=text style="display: none;" id="pasebio" value="<?php echo $controleur->getValue("pasebio",$listF); ?>" />
<input type=text style="display: none;" id="pasepp" value="<?php echo $controleur->getValue("pasepp",$listF); ?>" />
<input type=text style="display: none;" id="cpmb" value="<?php echo $controleur->getValue("cpmb",$listF); ?>" />
<input type=text style="display: none;" id="sptm" value="<?php echo $controleur->getValue("sptm",$listF); ?>" />
<input type=text style="display: none;" id="cpgb" value="<?php echo $controleur->getValue("cpgb",$listF); ?>" />
<input type=text style="display: none;" id="ntgha" value="<?php echo $controleur->getValue("ntgha",$listF); ?>" />
<input type=text style="display: none;" id="pvp10bio" value="<?php echo $controleur->getValue("pvp10bio",$listF); ?>" />
<input type=text style="display: none;" id="pvp10pp" value="<?php echo $controleur->getValue("pvp10pp",$listF); ?>" />
<input type=text style="display: none;" id="spvpbio" value="<?php echo $controleur->getValue("spvpbio",$listF); ?>" />
<input type=text style="display: none;" id="spvppp" value="<?php echo $controleur->getValue("spvppp",$listF); ?>" />
<input type=text style="display: none;" id="pacbio" value="<?php echo $controleur->getValue("pacbio",$listF); ?>" />
<input type=text style="display: none;" id="pacpp" value="<?php echo $controleur->getValue("pacpp",$listF); ?>" />
<input type=text style="display: none;" id="pafbio" value="<?php echo $controleur->getValue("pafbio",$listF); ?>" />
<input type=text style="display: none;" id="pafpp" value="<?php echo $controleur->getValue("pafpp",$listF); ?>" />
<input type=text style="display: none;" id="nbae" value="<?php echo $controleur->getValue("nbae",$listF); ?>" />
<input type=text style="display: none;" id="cepeb" value="<?php echo $controleur->getValue("cepeb",$listF); ?>" />
<input type=text style="display: none;" id="nbpc" value="<?php echo $controleur->getValue("nbpc",$listF); ?>" />
<input type=text style="display: none;" id="cppb" value="<?php echo $controleur->getValue("cppb",$listF); ?>" />
<input type=text style="display: none;" id="cpeb" value="<?php echo $controleur->getValue("cpeb",$listF); ?>" />
<input type=text style="display: none;" id="prixdeventepp" value="<?php echo $controleur->getValue("prixdeventepp",$listF); ?>" />
<input type=text style="display: none;" id="prixdeventebio" value="<?php echo $controleur->getValue("prixdeventebio",$listF); ?>" />
<input type=text style="display: none;" id="prixdeventeautre" value="<?php echo $controleur->getValue("prixdeventeautre",$listF); ?>" />

<script type="text/javascript">
    if(document.getElementById('financement').value == 'FP') 
        javascript:bascule('3-DIV-fonds_propres_disponibles', null, true);
                    
    if(document.getElementById('naissage').value == 'Oui') 
    { 
        javascript:bascule('etape-2-elevage', null, true); 
    } else if(document.getElementById('naissage').value == 'Non') { 
        javascript:bascule('101-poids_achat_porcelets', null, true); 
        javascript:bascule('etape-3-engraissement', null, true);
    }
                
    if(document.getElementById('hm').value == 'Bâtiment neuf') 
    javascript:bascule('10-DIV-montant_batiment_neuf_maternite', null, true);
    
    if(document.getElementById('pm').value == 'Oui') javascript:bascule('11-DIV-prairie-maternite', null, true);
                    
    if(document.getElementById('hg').value == 'Bâtiment neuf') javascript:bascule('12-DIV-montant-batiment-neuf', null, true);
                
    if(document.getElementById('pg').value == 'Oui') javascript:bascule('13-DIV-prairie-gestation', null, true);
            
    switch(document.getElementById('dpn').value){
        case "VTPE" :
            javascript:bascule("14-DIV-engraissement-poids-vente-porcelets", null, true);
            javascript:bascule("hebergement-porcelets", null, true);
            javascript:bascule("etape-4-generalite", null, true); 
            break;
        case "VPPE" :
            javascript:bascule("14-DIV-engraissement-poids-vente-porcelets", null, true); 
            javascript:bascule("hebergement-porcelets", null, true);
            javascript:bascule("etape-3-engraissement", null, true);
            break;
        case "EPCF" :
            javascript:bascule("14-DIV-engraissement-poids-sevrage", null, true); 
            javascript:bascule("etape-3-engraissement", null, true);
            break;
    }

    if(document.getElementById('hpav').value == 'Bâtiment neuf') javascript:bascule('201-DIV-montant-batiment-neuf', null, true);
            
    if(document.getElementById('hpe').value == 'Bâtiment neuf') javascript:bascule('403-DIV-montant-batiment-neuf', null, true);
                
    if(document.getElementById('pe').value == 'Oui') { 
        javascript:bascule('404-DIV-prairie-gestation', null, true); 
        javascript:bascule('etape-4-generalite', null, true);
    } 
    else if(document.getElementById('pe').value== 'Non') { 
        javascript:bascule('etape-4-generalite', null, true); 
    }
    
    javascript:infoNbpe();
</script>