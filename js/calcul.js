function getCalcul_ceb(){
    getMbnm();
    getNbslg();
    getMbng();
    getSpatm();
    getLce();
    getMbnpav();
    getSpatg();
    lt();
}

function getCalcul_nais(){
    getSpatm();
    getSpape();
    getMbnm();
    getNbslg();
    getMbng();
    getSpatm();
    getLce();
    getMbnpav();
    getSpatg();
    lt();
    getNbse();
    getPrixdevente();
}

function getCalcul_com(){
    getPaf();
    getPal();
    getPag();
    getPase();
    getPac();
    getPvp();
    getPvpa();
    getPrixdevente();
}

function getCalcul_nbt(){
    getNbslg();
    getLce();
    getMbnm();
    getMbng();
    getSpatm();
    lt();
    getMbnpav();
    getSpatg();
    getMbne();
    getSpape();
}

function getCalcul_dpn(){
    getMbne();
    getSpape();
    getLce();
    nbpeTheorique();
    getNbse();
    lt();
    getPrixdevente();
}

function getCalcul_nbps(){
    getMbnm();
    getNbslg();
    getMbng();
    getSpatm();
    getLce();
    getMbnpav();
    getSpatg();
    lt();
}

//Calcul le nombre de silo : nbsl+nbsg = [SI(nbt>=20;1;0)] + [=SI(nbt>=10;1;0)]
function getNbslg(){
    document.getElementById('nbslg').value =(parseInt(document.getElementById('nbt').value) >= 20 ? 1 : 0) + (parseInt(document.getElementById('nbt').value) >= 10 ? 1 : 0);
}

//Calcul le prix d'aliment de lactation : pal = Si (commercialisation="bio"; palbio; palpp) 
function getPal(){
    document.getElementById('pal').value = (document.getElementById('commercialisation').value == 'Filière bio' ? document.getElementById('palbio').value : document.getElementById('palpp').value);
}

//Calcul le prix d'aliment de gestation : pag = pag = Si (commercialisation="bio"; pagbio; pagpp) 
function getPag(){
    document.getElementById('pag').value = (document.getElementById('commercialisation').value == 'Filière bio' ? document.getElementById('pagbio').value : document.getElementById('pagpp').value);
}

//Calcul le prix d'aliment en PS : pase = Si (commercialisation="bio"; pasebio; pasepp) 
function getPase(){
    document.getElementById('pase').value = (document.getElementById('commercialisation').value == 'Filière bio' ? document.getElementById('pasebio').value : document.getElementById('pasepp').value);
}

//Calcul le montant batiment neuf maternité mbnm =SI(hm<>2;0;cpmb*nbtm)
function getMbnm(){
    document.getElementById('mbnm').value = Math.round((document.getElementById('hm').value == 'Bâtiment neuf' ?
        parseInt(document.getElementById('cpmb').value)*_nbtm() : 0)*100)/100;
}

//Calcul surfarce de prairie maternité : spatm=SI(naissage="oui";SI(pm=non;0; (SI(ceb=4;nbt/4;nbt/7*2)+1)*sptm);0)
function getSpatm(){
    document.getElementById('spatm').value = (document.getElementById('pm').value == 'Oui' ? 
        _nbtm()*document.getElementById('sptm').value:0).toFixed(2);
}

//Calcul le montant batiment neuf gestatiion mbnm =SI(hg<>2;0;cpgb*nbtg)
function getMbng(){
    document.getElementById('mbng').value = Math.round((document.getElementById('hg').value == 'Bâtiment neuf' ? 
        parseInt(document.getElementById('cpgb').value)*_nbtg() : 0)*100)/100;
}

//Calcul surfarce de prairie gestation : spatg=SI(naissage="oui";SI(pg=non;0; (SI(ceb=4;nbt/4*3;nbt/7*4)/ntgha);0)
function getSpatg(){
    document.getElementById('spatg').value = (document.getElementById('naissage').value == 'Oui' ? _nbtg()/parseInt(document.getElementById('ntgha').value) : 0).toFixed(2); ///parseInt(document.getElementById('ntgha').value)
}

//calcul du prix de vente des procelets : pvp=si (commercialisation = BIO; pvp10bio+(spvpbio*(pdv-10)) ;  pvp10pp+(spvppp*(pdvp-10)))
function getPvp(){
    if(document.getElementById('commercialisation').value == 'Filière bio')
        document.getElementById('pvp').value = (parseInt(document.getElementById('pvp10bio').value)+
        (parseInt(document.getElementById('spvpbio').value)*(parseInt(document.getElementById('pdvp').value)-10)));
    else
        document.getElementById('pvp').value = (parseInt(document.getElementById('pvp10pp').value)+
        (parseInt(document.getElementById('spvppp').value)*(parseInt(document.getElementById('pdvp').value)-10)));   
}

function getPvpa(){
    if(document.getElementById('commercialisation').value == 'Filière bio')
        document.getElementById('pvpa').value = (parseInt(document.getElementById('pvp10bio').value)+
        (parseInt(document.getElementById('spvpbio').value)*(parseInt(document.getElementById('pdvpa').value)-10)));
    else
        document.getElementById('pvpa').value = (parseInt(document.getElementById('pvp10pp').value)+
        (parseInt(document.getElementById('spvppp').value)*(parseInt(document.getElementById('pdvpa').value)-10)));
}

function getMbnpav(){
    mbnpav = 0;
    if(document.getElementById('dpn').value == 'VTPE'){
        if(document.getElementById('hpav').value == 'Bâtiment neuf')
        {
            mbnpav = parseInt(document.getElementById('cppb').value)*parseInt(document.getElementById('nbps').value)/
                parseInt(document.getElementById('nbcy').value)*_nbtm();
        }
    } else {
        if(document.getElementById('hpav').value == 'Bâtiment neuf') {
            engraissementPartie = 0.5;
            if(document.getElementById('ceb').value != '4 bandes') {
                engraissementPartie = 2/3;
            }
            mbnpav = parseInt(document.getElementById('cppb').value)*parseInt(document.getElementById('nbps').value)/
                parseInt(document.getElementById('nbcy').value)*_nbtm()*engraissementPartie;
        }
    }
    document.getElementById('mbnpav').value = Math.round(mbnpav*100)/100;
}

//Calcul le prix d'aliment de croissance : pac = Si (commercialisation="bio"; pacbio; pacpp) 
function getPac(){
    document.getElementById('pac').value = (document.getElementById('commercialisation').value == 'Filière bio' ? document.getElementById('pacbio').value : document.getElementById('pacpp').value);
}

//Calcul le prix d'aliment de finition : paf = Si (commercialisation="bio"; pafbio; pafpp) 
function getPaf(){
    document.getElementById('paf').value = 
        (document.getElementById('commercialisation').value == 'Filière bio' ? document.getElementById('pafbio').value : document.getElementById('pafpp').value);
}

function getPrixdevente(){
    document.getElementById('prixdevente').value = 
        (document.getElementById('commercialisation').value == 'Filière bio' ? 
        document.getElementById('prixdeventebio').value : document.getElementById('commercialisation').value == 'Filière porc en plein air' ?
        document.getElementById('prixdeventepp').value : document.getElementById('prixdeventeautre').value);
}

//Calcul le nombre de porcs en engraissement : nbpoe=SI(naissage="oui";SI(dpn="vtpe";0;SI(dpn="epcf";nbt*nbps/nbcy*(1-mse);nbpe));nbpe)
function _nbpoe(){
    /*
    ret = 0;
    if(document.getElementById('naissage').value == 'Non')
        return ret;
    else if(document.getElementById('dpn').value == 'VTPE')
        return ret;
    else if(document.getElementById('dpn').value == 'EPCF'){
        ret = parseInt(document.getElementById('nbt').value) * parseInt(document.getElementById('nbps').value) / 
            parseInt(document.getElementById('nbcy').value)*(1-(parseInt(document.getElementById('mse').value)/100));
    }
    else
        ret = document.getElementById('nbpe').value;

    return ret;
    */
    ret = 0;
    
    if (document.getElementById('naissage').value == "Oui") {
            if (document.getElementById('dpn').value == "VTPE") {
                    ret = 0;
            } else if (document.getElementById('dpn').value == "EPCF") {
                    ret =  parseFloat(document.getElementById('nbt').value) * parseFloat(document.getElementById('nbps').value)  / 
                        parseFloat(document.getElementById('nbcy').value) * 
                        (1 - (parseFloat(document.getElementById('mse').value)/100));
            } else {
                    ret =  document.getElementById('nbpe').value;
            }
    } else {
            ret =  document.getElementById('nbpe').value;
    }

    return ret;
}

function _nbtm(){
    ret = 0;
    
    if(document.getElementById('naissage').value == 'Non')
        return ret;
    else if(document.getElementById('ceb').value == '4 bandes')
        ret = parseInt(document.getElementById('nbt').value)/parseInt(document.getElementById('ceb').value);
    else
        ret = parseInt(document.getElementById('nbt').value)/parseInt(document.getElementById('ceb').value)*2;

    return Math.round(ret);
}

function _nbtg(){
    ret = 0;
    if(document.getElementById('naissage').value == 'Non')
        return ret;
    else if(document.getElementById('ceb').value == '4 bandes')
        ret = parseInt(document.getElementById('nbt').value)/parseInt(document.getElementById('ceb').value)*3;
    else
        ret = parseInt(document.getElementById('nbt').value)/parseInt(document.getElementById('ceb').value)*5;
    
    return Math.round(ret);
}

//Calcul le nombre de silos d'engraissement nbse = SI(nbpoe<10;0;SI(nbpoe<50;1;nbae))
function getNbse(){
    nbpoe = _nbpoe();
    
    document.getElementById('nbse').value = nbpoe < 10 ? 0 : nbpoe < 50 ? 1 : document.getElementById('nbae').value;
}

//Calcul montant batiment engraissement mbne=SI(hpe<>2;0;cpeb*nbpoe)
function getMbne(){
    nb = _nbpoe();
    document.getElementById('mbne').value = document.getElementById('hpe').value == 'Bâtiment neuf' ? 
        Math.round((parseFloat(document.getElementById('cpeb').value)*nb)*100)/100 : 0;
}

//Calcul Surface de prairie en engraissement spape=SI(pe=oui;0;nbpoe/nbpc)
function getSpape(){
    nbpoe = _nbpoe();
    
    document.getElementById('spape').value = 
        document.getElementById('pe').value == 'Non' ? 0 : Math.round((nbpoe/parseInt(document.getElementById('nbpc').value))*100)/100;
}

//Calcul longieur des clotures treillis : lt=(RACINE(spatm+spatg+spape)*4*100)+((RACINE(spape)*2))*100
function lt(){
    document.getElementById('lt').value = Math.round((Math.sqrt(parseInt(document.getElementById('spatm').value)+parseInt(document.getElementById('spatg').value)+parseInt(document.getElementById('spape').value))*4*100+
                Math.sqrt(parseInt(document.getElementById('spape').value))*2*100)*10)/10 || 0;
    return document.getElementById('lt').value;
}

//Calcul longueur cloture électrique : Ice=lt*2+SI(naissage="oui";(RACINE(spatm/nbtm)*2*100*nbtm)+(
//RACINE(spatg/SI(ceb=4;nbt/4*3;nbt/7*4))*2*100*SI(ceb=4;nbt/4*3;nbt/7*4));0)+(RACINE(spape/((nbpoe+1)/nbpc))*2*100*(nbpoe/nbpc))
function getLce(){
    ret = 0;
    nb = _nbpoe();
    nb_2 = _nbtm();
    
    if(document.getElementById('naissage').value == 'Oui')
    {
        ret = (Math.sqrt(parseInt(document.getElementById('spatm').value)/nb_2)*2*100*nb_2);
        
        if(document.getElementById('ceb').value == '4 bandes')
            ret += (Math.sqrt(parseInt(document.getElementById('spatg').value))) /  parseInt(document.getElementById('nbt').value)/4*3*2*100;
        else
            ret += (Math.sqrt(parseInt(document.getElementById('spatg').value))) / parseInt(document.getElementById('nbt').value)/7*4*2*100;
            
        if(document.getElementById('ceb').value == '4 bandes')
        {
            ret *= parseInt(document.getElementById('nbt').value)/4*3;
        }
        else
            ret *= parseInt(document.getElementById('nbt').value)/7*4;
    }
    
    ret += Math.sqrt(parseInt(document.getElementById('spape').value)/((nb+1)/parseInt(document.getElementById('nbpc').value)))*2*100*(nb/parseInt(document.getElementById('nbpc').value));

    document.getElementById('lce').value = Math.round((lt()*2+ret)*10)/10 || 0;
}

//Calcul somme total véhicule
function sommeMar(){
    tracteur = 0;
    telescopique = 0;
    quad = 0;
    autre = 0;
    
    if(document.getElementById('tracteur').checked)
        tracteur = parseFloat(document.getElementById('tc').value) * parseFloat(document.getElementById('ttp').value);
    
    if(document.getElementById('telescopique').checked)
        telescopique = parseFloat(document.getElementById('tec').value) * parseFloat(document.getElementById('ttep').value);
    
    if(document.getElementById('quad').checked)
        quad = parseFloat(document.getElementById('qc').value) * parseFloat(document.getElementById('qtp').value);
    
    if(document.getElementById('autre').checked)
        autre = parseFloat(document.getElementById('ac').value) + parseFloat(document.getElementById('atp').value);
    
    document.getElementById('mar').value = (tracteur + telescopique + quad + autre )|| 0;
}

//Calcul somme total batiment
function sommeBatiment(){
    document.getElementById('mab').value = parseFloat(document.getElementById('mab1').value) + parseFloat(document.getElementById('mab2').value) + parseFloat(document.getElementById('mab3').value) +
        parseFloat(document.getElementById('mab5').value) + parseFloat(document.getElementById('mab4').value) || 0;
}

function nbpeTheorique(){
    infoNbpe();
}

function infoNbpe(){
    nb = Math.round((parseFloat(document.getElementById('nbt').value)*parseFloat(document.getElementById('nbps').value)*
        (1-(parseFloat(document.getElementById('mse').value)/100)))/parseFloat(document.getElementById('nbcy').value));
    
    if(document.getElementById('dpn').value != 'EPCF'){
        if(document.getElementById('nbpe').value > nb)
            bascule("info_nbpe", "<h4>Information !</h4>Le nombre de places à l'engraissement calculé en fonction du nombre introduit de truies doit théoriquement être inférieur ou égale à " +
                nb, true);
        else
            bascule("info_nbpe", "<h4>Information !</h4>Le nombre de places à l'engraissement calculé en fonction du nombre introduit de truies doit théoriquement être inférieur ou égale à " +
            nb, false);
    }
    else {
        var nbpeCal =
            Math.round((parseFloat(document.getElementById('nbt').value)*parseFloat(document.getElementById('nbps').value)*
                (1-(parseFloat(document.getElementById('mse').value)/100)))/parseFloat(document.getElementById('nbcy').value));
        if(document.getElementById('nbpe').value < nbpeCal){
            document.getElementById('nbpe').value = nbpeCal;
            bascule("info_nbpe", "<h4>Information !</h4>Le nombre de places à l'engraissement calculé en fonction du nombre introduit de truies doit être supérieur ou égale à " +
                nb, true);
        }
    }
}

// Show etape-4-prairie if at least one answer (YES) is selected in one question about prairie
function isAtLeastOneYesPrairieSelected(){
    var isPrairieEngraissement = document.getElementById('pe').value;
    var isPrairieGestation = document.getElementById('pg').value;
    var isPrairieMaternite = document.getElementById('pm').value;
    if(isPrairieEngraissement == 'Oui' || isPrairieGestation == 'Oui' || isPrairieMaternite == 'Oui'){
        bascule('etape-4-prairie', null, true);
    }
    if(isPrairieEngraissement == 'Non' && isPrairieGestation == 'Non' && isPrairieMaternite == 'Non'){
        bascule('etape-4-prairie', null, false);
    }
}
