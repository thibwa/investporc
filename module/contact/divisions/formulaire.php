<?php
    if(isset($_POST['Co_contactname']) && isset($_POST['Co_email']) && isset($_POST['Co_message']))
    {
        $name = $_POST['Co_contactname'];
        $from = $_POST['Co_email'];
        $message = str_replace("\\", "", $_POST['Co_message']);

        if($controleur->contactMail($name, $from, $message))
            header("Location: index.php?p=contact&p3=success");
        else
            header("Location: index.php?p=contact&p3=error");
    }  
    
    $email = "";
    $nom = "";
    
    if($controleur->user("email"))
    {
        $email = $controleur->user("email");
        $nom = $controleur->user("nomprenom");
    }
?>

<form method="post" action="index.php?p=contact" id="contactform">
    <fieldset>
        <legend>Contactez-nous grâce à notre formulaire</legend>
        <div>
            <?php
                if(isset($_GET["p3"]))
                {
                    switch ($_GET["p3"])
                    {
                        case "error":
                            include 'module/contact/divisions/alert/alert-errorMailing.php';
                            break;
                        case "success":
                            include 'module/contact/divisions/alert/alert-successMailing.php';
                            break;
                        default:
                            header ('index.php?p=erreur404');
                            break;
                    }
                }
                
                include 'module/contact/divisions/alert/alert-errorForm.php';
            ?>        
        </div>
        <label class="control-label">
            <b>* </b>Nom
        </label>
        <div class="controls">
            <input id="Co_contactname" value="<?php echo $nom; ?>" name="Co_contactname" style="width: 280px;" role="input" placeholder="Votre nom" type="text">
            <i><span id="Co_erreurName" class="help-inline"></span></i>
        </div>
        <label class="control-label">
            <b>* </b>Email
        </label>
        <div class="controls">
            <input id="Co_email" name="Co_email" value="<?php echo $email; ?>"placeholder="Votre email" style="width: 280px;" role="input" aria-required="true" type="text">
            <i><span id="Co_erreurEmail" class="help-inline"></span></i>
        </div>
        <label class="control-label">
            <b>* </b>Message
        </label>
        <div class="controls">
            <textarea rows="8" name="Co_message" id="Co_message" style="width: 280px; max-width: 500px; min-height: 150px; min-width: 100px; max-height: 500px;" placeholder="Votre message" role="textbox" aria-required="true" maxlength="1500"></textarea>
            <i><span id="Co_erreurMessage" class="help-inline"></span></i>
        </div>
        <table border=0>
            <tr>
                <td>
                    <label class="control-label">
                        <b>* </b><i>Calculez</i>
                    </label>
                    <!-- Captcha -->
                    <div id="captcha" class="controls">
                        <?php echo $controleur->captcha()." = "; ?>
                        <input style="width: 35px; margin-top: 5px;" type="text" id="Co_response" name="Co_response" role="input" aria-required="true"  maxlength="2"/>
                        <i><span id="Co_erreurResponse" class="help-inline"></span></i>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <input value="Envoyer" type="submit" name="Co_submit" id="Co_submitButton" class="btn btn-primary" title="Cliquez ici pour envoyer votre message" /> 
                </td>
            </tr>
        </table>
    </fieldset>
</form>