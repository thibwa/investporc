<!-- Menu
================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top" id="headMenu">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar pull-right" id="btnMenuHiddenDesktop" style="margin-top: 30px;" data-toggle="collapse" data-target=".nav-collapse">
                Menu
            </a>
            <a class="brand" id="iconIndex" href="index.php">
                <img src="img/investporc-logo-beta.png" class="img-rounded" alt="InvestPorc" style="width:120px; height:70px; border:none;" />
            </a>
            <div class="nav-collapse">
                <ul class="menu nav nav-pills" id="filtre" style="margin-top: 18px;">
                    <li <?php if(!isset($_GET["p"])) echo "class=active"; ?>>
                        <a href="index.php"><h5><i class="icon-home"></i> Accueil</h5></a>
                    </li>
                    <li <?php if(isset($_GET["p"]) AND $_GET["p"] == "calcul") echo "class=active"; ?>>
                        <a href="index.php?p=calcul"><h5><i class="icon-wrench"></i> Calcul</h5></a>
                    </li>
                    <li <?php if(isset($_GET["p"]) AND $_GET["p"] == "methode") echo "class=active"; ?>>
                        <a href="index.php?p=methode"><h5><i class="icon-book"></i> Méthode</h5></a>
                    </li>
                    <li <?php if(isset($_GET["p"]) AND $_GET["p"] == "contact") echo "class=active"; ?>>
                        <a href="index.php?p=contact"><h5><i class="icon-user"></i> Contact</h5></a>
                    </li>
                </ul>

                <div class="navbar-form pull-right" id="panelConnexion">
                    <?php 
                        $b = $controleur->user("email");
                        
                        if($b)
                             include ('module/index/divisions/formConnect.php');
                        else
                            include ('module/index/divisions/formConnexion.php');
                    ?>
                </div>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- /Menu -->

<?php
    if(isset($_POST['Connect_email']) && isset($_POST['Connect_motDePasse2']))
    {
    
        $email = $_POST['Connect_email']; 
        $mdp = $_POST['Connect_motDePasseHid'];

        if($controleur->connexionMembre($email, $mdp))
        {
            header('Location:index.php');
        }
        else
        {
            ?>
                <script>
                    var msgErr = "Echec lors de la connexion<br/>" +
                          "Cette erreur peut être due à un échec de connexion à la base de données<br /> ou que votre adresse " +
                          "email n'existe pas.";
                      
                    try
                    {                      
                        bascule("controlErrorChamps", null, true);
                        $('#Connect_erreurEmail').html(msgErr);
                        $('#Connect_erreurEmail').css("color","#b94a48");
                    }
                    catch(err){}
                </script>
            <?php
        }
    }
?>
