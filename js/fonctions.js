$(document).ready(function () {
    $('#coin-slider').coinslider(
        {
            width: 190, // width of slider panel
            height: 500, // height of slider panel
            spw: 5, // squares per width
            sph: 4, // squares per height
            delay: 4000, // delay between images in ms
            sDelay: 35, // delay beetwen squares in ms
            opacity: 0.7, // opacity of title and navigation
            titleSpeed: 550, // speed of title appereance in ms
            effect: 'random', // random, swirl, rain, straight
            navigation: true, // prev next and buttons
            links : false, // show images as links
            hoverPause: true // pause on hover
        }
    );
        
    checkForm("contactform");
    checkForm("connectionForm");
    checkForm("creationCompteForm");
    checkForm("recovEForm");
    checkForm("recovMForm");
    checkForm("modifEmailForm");
    //checkForm("modifMotDePasseForm");
    checkForm("modifNomForm"); 
   
    formSubmit("#creationCompteForm");
    formSubmit("#recovEForm");
    formSubmit("#recovMForm");
    formSubmit("#modifEmailForm");
    formSubmit("#modifMotDePasseForm");
    formSubmit("#modifNomForm");
    formSubmit("#contactform");
    formSubmit("#connectionForm");
});

function formSubmit(idForm)
{
    $(idForm).submit(function() {
        switch(idForm.substr(1, idForm.length)){
            case "contactform": return verifFormContact(); break;
            case "connectionForm": return verifFormConnexion(); break;
            case "creationCompteForm": return verifFormCreation(); break;
            case "recovEForm": return verifFormRecuparation(); break;
            case "recovMForm": return verifFormRecuparationMdp(); break;
            case "modifEmailForm": return verifFormGererEmail(); break;
            case "modifNomForm": return verifFormGererNom(); break;
            case "modifMotDePasseForm": return verifFormGererMdp(); break;
        }
    });
}

function printDataProject(){
    //Cache les champs inutiles
    document.getElementById("printerForm").style.display='none';
    document.getElementById("headMenu").style.display='none';
    document.getElementById("tabMenuCalcul").style.display='none';
    document.getElementById("tabContentCalcul").style.marginLeft = 100;
    document.getElementById('body').style.marginTop = 0;

    window.print();

    document.getElementById("printerForm").style.display='block';
    document.getElementById("headMenu").style.display='block';
    document.getElementById("tabMenuCalcul").style.display='block';
    document.getElementById("tabContentCalcul").style.marginLeft = 120;
    document.getElementById('body').style.marginTop = 120;
}

function printerResultat(){
   //Cache les champs inutiles
   document.getElementById("printerCalcul").style.display='none';
   document.getElementById("headMenu").style.display='none';
   document.getElementById("tabMenuCalcul").style.display='none';
   document.getElementById("tabContentCalcul").style.marginLeft = 100;
   document.getElementById('body').style.marginTop = 0;
   
   window.print();
   
   document.getElementById("printerCalcul").style.display='block';
   document.getElementById("headMenu").style.display='block';
   document.getElementById("tabMenuCalcul").style.display='block';
   document.getElementById("tabContentCalcul").style.marginLeft = 120;
   document.getElementById('body').style.marginTop = 120;
}

/*
 * Vérification sur le champs dont l'id est égale au paramètre passé
 * à la fonction return false si vide return true si non vide
 */
function verifChampsForm(id){
    if($(id).val().trim() == "")
        return false;
    else
        return true;
}

//Erreur au niveau du formulaire contact car j'ai un textarea et pas un 'input'
function checkForm(idForm)
{
    //Test si le formulaire existe
    //Sinon arrêt de la fonction
    if(document.getElementById(idForm) == null)
        return ;

    //Récupération du formulaire par son ID
    myForm = document.getElementById(idForm);
    
    //Choix de la couleur du texte d'erreur
    var errorColor = "#b94a48";
    
    //Déclaration d'un tableau
    var listeSpan = new Array();
    
    //Récupération de toutes les balises 'span' du formulaire
    listeSpan = myForm.getElementsByTagName("span");
    
    //Variable de sauvegarde du compteur i
    var tmp = 0;
    
    //Boucle de récupération de tous les champs du formulaire identifié par son id
    for(i = 0; i < myForm.elements.length; i++)
    {
        if(myForm.elements[i].type == "submit" || myForm.elements[i].type == "hidden")
            return ;
        
        var champsName = "";
        
        //Il se peut que dans la liste des éléments des formulaires
        //qu'il y ait un élément vide donc qui n'a pas d'id
        if(myForm.elements[i].id != "")
            champsName = myForm.elements[i].id;
        else if(i < myForm.elements.length - 2)
            champsName = myForm.elements[++i].id;
        else
            break ;
        
        //Récupération des bons champs 'span'
        do
        {            
            //Si pas de champs 'span' alors on a plus besoin de tester 
            //peut être champs 'hidden' ou autre
            if(tmp > listeSpan.length - 1)
                break ;
            
            var errorName = listeSpan[tmp].id;
            
            tmp += 1;
        }
        while(errorName == "");
        
        //Création du name de l'input
        var nameID = "#" + champsName;
        
        //Création du name du span
        var nameSpan = "#" + errorName;
        
        //Récupération des 5 dernières lettres du name
        //email = champs émail
        //Passe = champs mot de passe avec confirmation
        //ponse = champs captcha
        //asse2 = champs mot de passe simple
        //'autre' = champs simple
        var typeOfInput = champsName.substr(champsName.length - 5, champsName.length);
        
        switch(typeOfInput)
        {
            case 'email':
                //Appel de la fonction avec le protocole 1
                checkInputFromForm(nameID, "", nameSpan, "", errorColor, 1);
                break;
            case 'Passe':
                var idBis;
                var nameSpanBis;
                
                if(myForm.elements[i + 1 ].type == "password")
                {
                    idBis = myForm.elements[i + 1].id;
                    nameSpanBis = "#" + listeSpan[tmp].id;                
                    var nameIDBis = "#" + idBis;
                }
                else
                {
                    nameIDBis = "#" + myForm.elements[i - 1].id;
                    var tempSpan = nameSpan;
                    nameSpan = "#" + listeSpan[tmp - 2].id;
                    nameSpanBis = tempSpan;
                }
                
                //Appel de la fonction avec le protocole 2
                checkInputFromForm(nameID, nameIDBis, nameSpan, nameSpanBis, errorColor, 2);
                break;
            case 'asse2':
                //Appel de la fonction avec le protocole 4
                checkInputFromForm(nameID, "", nameSpan, "", errorColor, 4);
                break;
            case 'ponse':
                //Appel de la fonction avec le protocole 3
                checkInputFromForm(nameID, "", nameSpan, "", errorColor, 3);
                break;
            default:
                //Appel de la fonction avec le protocole 0
                checkInputFromForm(nameID, "", nameSpan, "", errorColor, 0);
                break;
        }
    }
}

function checkInputFromForm(valueInput, valueInputBis, errorInput, errorInputBis, errorColor, protocole)
{
     $(valueInput).blur(function(){
            switch(protocole)
            {
                //Champs simples
                case 0:
                    //Si champs vide
                    if(!verifChampsForm(valueInput))
                    {
                        $(valueInput).removeClass("success");
                        $(valueInput).addClass("error");

                        $(errorInput).text("Veuillez remplir ce champ");
                        $(errorInput).css("color", errorColor);
                    }   
                    else
                    {
                        $(valueInput).removeClass("error");
                        $(valueInput).addClass("success");

                        $(errorInput).text("");
                    }
                    break;
                
                //Champs email
                case 1:
                    //Si champs vide
                    if(!verifChampsForm(valueInput))
                    {
                        $(valueInput).removeClass("success");
                        $(valueInput).addClass("error");

                        $(errorInput).text("Veuillez remplir ce champ");
                        $(errorInput).css("color", errorColor);
                    }   
                    else
                    {
                        if(!validateEmail($(valueInput).val().trim()))
                        {
                            $(valueInput).removeClass("success");
                            $(valueInput).addClass("error");

                            $(errorInput).text("Format de l'adresse email non valide");
                            $(errorInput).css("color",errorColor);
                        }
                        else
                        {
                            $(valueInput).removeClass("error");
                            $(valueInput).addClass("success");

                            $(errorInput).text("");
                        }
                    }
                    break;
                    
                //Champs mot de passe avec confirmation
                case 2:
                    if($(valueInputBis).val().trim() == $(valueInput).val().trim())
                    {
                        if(!verifChampsForm(valueInput) && !verifChampsForm(valueInputBis))
                        {
                            $(valueInput).removeClass("success");
                            $(valueInput).addClass("error");

                            $(errorInput).text("Veuillez remplir ce champ");
                            $(errorInput).css("color", errorColor);
                            
                            $(valueInputBis).removeClass("success");
                            $(valueInputBis).addClass("error");

                            $(errorInputBis).text("Veuillez remplir ce champ");
                            $(errorInputBis).css("color", errorColor);
                        }
                        else
                        {
                            $(valueInputBis).removeClass("error");
                            $(valueInput).removeClass("error");
                            $(valueInput).addClass("success");
                            $(valueInputBis).addClass("success");

                            $(errorInputBis).text("");
                            $(errorInput).text("");
                        }
                    }
                    else
                    {
                        $(valueInput).removeClass("success");
                        $(valueInput).addClass("error");
                        $(valueInputBis).removeClass("success");
                        $(valueInputBis).addClass("error");
                        
                        $(errorInput).text("");
                        $(errorInputBis).text("Les deux mots de passe ne correspondent pas");
                        $(errorInputBis).css("color", errorColor);
                    }
                    break;
                    
                //Champs mot de passe simple
                case 4:
                    //Si champs vide
                    if(!verifChampsForm(valueInput))
                    {
                        $(valueInput).removeClass("success");
                        $(valueInput).addClass("error");

                        $(errorInput).text("Veuillez remplir ce champ");
                        $(errorInput).css("color", errorColor);
                    }   
                    else
                    {
                        $(valueInput).removeClass("error");
                        $(valueInput).addClass("success");

                        $(errorInput).text("");
                    }
                    break;
                //Champs captcha (calcul)
                case 3:
                    //Si champs vide
                    if(!verifChampsForm(valueInput))
                    {
                        $(valueInput).removeClass("success");
                        $(valueInput).addClass("error");

                        $(errorInput).text("Veuillez remplir ce champ");
                        $(errorInput).css("color", errorColor);
                    }   
                    else
                    {
                        //Addition du calcul mathématique
                        var reponseCaptcha = parseInt(($("#captcha").html().trim()).substring(0, 1)) + parseInt( ($("#captcha").html().trim()).substring(4, 6));

                        if(parseInt($(valueInput).val()) != reponseCaptcha)
                        {
                            $(valueInput).removeClass("success");
                            $(valueInput).addClass("error");

                            $(errorInput).text("Le résultat du calcul \"Captcha\" est éronné.");
                            $(errorInput).css("color",errorColor);
                        }
                        else
                        {
                            $(valueInput).removeClass("error");
                            $(valueInput).addClass("success");

                            $(errorInput).text("");
                        }
                    }
                    break;
            }
     });          
}

/*
 * Regex d'email
 */
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

/*
 * Affichage de la div et du text passé en paramètre
 */
function bascule(elem, text, val)
{
    if(val)
    {
        try{
            $('#textError').html(text);
        }catch(err){}
        document.getElementById(elem).style.display="block";
    }
    else
        document.getElementById(elem).style.display="none";
}

function checkValue(val, min, max) {
    if (val < min || val > max) 
        alert('Ce chiffre est en dehors des moyennes observées');
}

function grise (checked,id, idb)
{
    document.getElementById(id).disabled=!checked;
    document.getElementById(idb).disabled=!checked;
}

function afficher_cacher(id)
{
    if(document.getElementById(id).style.display == "none")
        document.getElementById(id).style.display = "block";
    else if(document.getElementById(id).style.visibility == "hidden")
        document.getElementById(id).style.visibility = "visible";
    else if(document.getElementById(id).style.visibility == "visible")
        document.getElementById(id).style.visibility = "none";
    else
        document.getElementById(id).style.display = "none";
    return true;
}

function verifFormContact()
{
    var msgErr = "";
    var nameError = "Le champ \"Nom\" est obligatoire. <br>";
    var emailError = "Le champ \"Email\" est obligatoire. <br> ";
    var emailFormatError = "Le format de l'adresse email est incorrect. <br /> ";
    var messageError = "Le champ \"Message\" est obligatoire. <br />";
    var responseError = "Le résultat du calcul \"Captcha\" est incomplet. <br />";
    var resultatError = "Le résultat du calcul \"Captcha\" est éronné.";
    
    if(!verifChampsForm("#Co_contactname"))
        msgErr += nameError;
    if(!verifChampsForm("#Co_email"))
        msgErr += emailError;
    if(!validateEmail($("#Co_email").val().trim()))
        msgErr += emailFormatError;
    if(!verifChampsForm("#Co_message"))
        msgErr += messageError;
    if(!verifChampsForm("#Co_response"))
        msgErr += responseError;
    
    var reponseCaptcha = parseInt(($("#captcha").html().trim()).substring(0, 1)) + parseInt( ($("#captcha").html().trim()).substring(4, 6));
    
    if(parseInt($("#Co_response").val()) != reponseCaptcha)
        msgErr += resultatError;
    
    if(msgErr != "")
    {
        bascule("Co_msgErrorChamps", msgErr, true);
        
        return false;
    }
    
    return true;
}

function verifFormCreation(){
    var msgErr = "";
    var nameError = "Le champ \"Nom/Prénom\" est obligatoire. <br>";
    var emailError = "Le champ \"Email\" est obligatoire. <br> ";
    var emailFormatError = "Le format de l'adresse email est incorrect. <br /> ";
    var mdpError = "Le champ \"Mot de passe\" est obligatoire. <br />";
    var mdp2Error = "Le champ de confirmation est obligatoire. <br />";
    var mdpMdp2Error = "Les deux mots de passe sont éronnés.";
    
    if(!verifChampsForm("#Re_name"))
        msgErr += nameError;
    if(!verifChampsForm("#Re_email"))
        msgErr += emailError;
    if(!validateEmail($("#Re_email").val().trim()))
        msgErr += emailFormatError;
    if(!verifChampsForm("#Re_motDePasse"))
        msgErr += mdpError;
    if(!verifChampsForm("#Re_2motDePasse"))
        msgErr += mdp2Error;
    if($("#Re_2motDePasse").val().trim() != $("#Re_motDePasse").val().trim())
        msgErr += mdpMdp2Error;
    
    if(msgErr != "")
    {
        bascule("Re_msgErrorChamps", msgErr, true);
        return false;
    }
    
    //Hashage du mot de passe en md5
    $("#Re_motDePasseHid").val(hex_md5($("#Re_2motDePasse").val()));
    
    return true;
}

function verifFormConnexion(){
    var msgErr = "";
    var emailError = "Le champ \"Email\" est obligatoire. <br /> ";
    var emailFormatError = "Le format de l'adresse email est incorrect. <br /> ";
    var mdpError = "Le champ \"Mot de passe\" est obligatoire. <br />";

    if(!verifChampsForm("#Connect_email"))
        msgErr += emailError;
    if(!validateEmail($("#Connect_email").val().trim()))
        msgErr += emailFormatError;
    if(!verifChampsForm("#Connect_motDePasse2"))
        msgErr += mdpError;
    
    if(msgErr != "")
    {
        try
        {
            bascule("controlErrorChamps", null, true);
            $('#Connect_erreurEmail').html(msgErr);
                $('#Connect_erreurEmail').css("color","#b94a48");
        }
        catch(err){}
        return false;
    }
    
    //Hashage du mot de passe en md5
    $("#Connect_motDePasseHid").val(hex_md5($("#Connect_motDePasse2").val()));
    
    return true;
}

function verifFormRecuparation(){
    var msgErr = "";
    var emailError = "Le champ \"Email\" est obligatoire. <br /> ";
    var emailFormatError = "Le format de l'adresse email est incorrect. <br /> ";

    if(!verifChampsForm("#Recover_email"))
        msgErr += emailError;
    if(!validateEmail($("#Recover_email").val().trim()))
        msgErr += emailFormatError;
    
    if(msgErr != "")
    {
        bascule("Recover_msgErrorChamps", msgErr, true);
        return false;
    }
    
    return true;
}

function verifFormRecuparationMdp(){
    var msgErr = "";
    var mdpError = "Le champ \"Mot de passe\" est obligatoire. <br />";
    var mdp2Error = "Le champ de confirmation est obligatoire. <br />";
    var mdpMdp2Error = "Les deux mots de passe sont éronnés.";

    if(!verifChampsForm("#Recover_motDePasse"))
        msgErr += mdpError;
    if(!verifChampsForm("#Recover_motDePasse2"))
        msgErr += mdp2Error;
    if($("#Recover_motDePasse2").val().trim() != $("#Recover_motDePasse").val().trim())
        msgErr += mdpMdp2Error;
    
    if(msgErr != "")
    {
        bascule("Re_msgErrorChamps", msgErr, true);
        return false;
    }
    
    //Hashage du mot de passe en md5
    $("#Recover_motDePasseHid").val(hex_md5($("#Recover_motDePasse2").val()));
    
    return true;
}

function verifFormGererNom(){
    var msgErr = "";
    var mdpError = "Le champ \"Nom, prénom\" est obligatoire. <br />";

    if(!verifChampsForm("#Modif_nom"))
        msgErr += mdpError;
    
    if(msgErr != "")
    {
        bascule("Modif_msgErrorChamps", msgErr, true);
        return false;
    }
    
    return true;
}

function verifFormGererEmail(){
    var msgErr = "";
    var emailError = "Le champ \"Email\" est obligatoire. <br /> ";
    var emailFormatError = "Le format de l'adresse email est incorrect. <br /> ";

    if(!verifChampsForm("#Modif_email"))
        msgErr += emailError;
    if(!validateEmail($("#Modif_email").val().trim()))
        msgErr += emailFormatError;
    
    if(msgErr != "")
    {
        bascule("Modif_msgErrorChamps", msgErr, true);
        return false;
    }
    
    return true;
}

function verifFormGererMdp(){
    var msgErr = "";
    var mdpAncienError = "Le champs \"Ancien mot de passe\" est obligatoire. <br />";
    var mdpError2ancien = "Votre ancien mot de passe est incorrect. <br />";
    var mdpError = "Le champ \"Mot de passe\" est obligatoire. <br />";
    var mdp2Error = "Le champ de confirmation est obligatoire. <br />";
    var mdpMdp2Error = "Les deux mots de passe sont éronnés.";

    if(!verifChampsForm("#Modif_ancienMotDePasse"))
        msgErr += mdpAncienError;
    if(hex_md5($("#Modif_ancienMotDePasse").val().trim()) != $("#Modif_ancienMotDePasseHid").val().trim())
        msgErr += mdpError2ancien;
    if(!verifChampsForm("#Modif_motDePasse"))
        msgErr += mdpError;
    if(!verifChampsForm("#Modif_motDePasse2"))
        msgErr += mdp2Error;
    if($("#Modif_motDePasse2").val().trim() != $("#Modif_motDePasse").val().trim())
        msgErr += mdpMdp2Error;
    
    if(msgErr != "")
    {
        bascule("Modif_msgErrorChamps", msgErr, true);
        return false;
    }
    
    //Hashage du mot de passe en md5
    $("#Modif_motDePasseHid").val(hex_md5($("#Modif_motDePasse2").val()));
    
    return true;
}




