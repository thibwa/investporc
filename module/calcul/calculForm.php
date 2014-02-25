<?php
    if(isset($_GET["p4"]))
    {
        //Test si la session est dejà dans la base de données alors on charge les réponses
        $list = $controleur->getAllReponseFormCalculByKey($_GET["p4"]);
    }
            
    $listF = $controleur->getAllFixedValue();

    if($list == NULL)
        //Rapatriement de tous les objets de type Reponse
        $list = $controleur->getAllValueFormCalcul();
?>

<div class="container">
    <div class="row">
       <div class="span12">
            <legend>Chiffrez votre projet</legend>
            <blockquote>
                <p style="font-size: 14px;">
                    <Strong>
                        Le module de calcul vous permet de chiffrer votre projet.
                    </strong>
                </p>
            </blockquote>
       </div>

        <div class="span11">
            <div>
                <?php include('module/calcul/buildCalcul.php'); ?>
            </div>
            
            <div class="tabbable tabs-left">
                    <ul class="nav nav-tabs" id="tabMenuCalcul" style="position: fixed;">
                        <?php if(!isset($_GET["p3"]) OR $_GET["p2"] == "error") { ?>
                            <li class="active">
                                <a href="index.php?p=formulaire" data-toggle="tab">Formulaire</a>
                            </li>
                        <?php } else if(isset($_GET["p3"]) AND $_GET["p3"] == "resultat") { ?>
                            <li>
                                <a href="index.php?p=formulaire&p2=success">Formulaire</a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href="index.php?p=formulaire">Formulaire</a>
                            </li>
                        <?php } ?>

                        <?php if(isset($_GET["p3"]) AND $_GET["p3"] == "resultat") { ?>
                            <li class="active">
                                <a href="index.php?p=formulaire&p3=resultat" data-toggle="tab">Résultats</a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href="index.php?p=formulaire&p3=resultat">Résultats</a>
                            </li>
                        <?php } ?>
                    </ul>
            
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabContentCalcul" style="margin-left: 120px;">
                            <?php
                                if(isset($_GET["p3"]) == "resultat")
                                {
                                    echo '<div id="bodyCalcul">';
                                    include 'module/calcul/divisions/resultat.php';
                                    echo "</div>";
                                }
                                else
                                    include 'module/calcul/divisions/formulaire.php';
                            ?>
                        </div>
                    </div>  
                </div>
        </div>
    </div>
</div>
