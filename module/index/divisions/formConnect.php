<?php
    if(isset($_GET["p2"]))
    {    
        if($_GET["p2"] == "deconnect")
        {
            if($controleur->deconnexionMembre())
                header ('Location: index.php');
        }   
    }

    if(!$controleur->allowMaster())
    {
       ?>
            <div class="btn-group">
                <a class="btn btn-primary" href="index.php?p=moncompte"><i class="icon-user icon-white"></i> <?php echo $b; ?></a>
                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="index.php?p=defaultValue"><i class="icon-wrench"></i> Gèrer valeurs par défaut</a></li>
                    <li><a href="index.php?p=defaultQuestion"><i class="icon-wrench"></i> Gèrer valeurs par question</a></li>
                    <li><a href="index.php?p=allUser"><i class="icon-wrench"></i> Gèrer les comptes utilisateurs</a></li>
                    <li><a href="index.php?p=statistique"><i class="icon-wrench"></i> Statistiques</a></li>
                    <li class="divider"></li>
                    <li><a href="index.php?p=moncompte"><i class="icon-wrench"></i> Mon compte</a></li>
                    <li class="divider"></li>
                    <li><a href="index.php?p2=deconnect"><i class="icon-remove"></i> Déconnexion</a></li>
                </ul>
            </div>
       <?php
    }
    else
    {
        ?>
            <div class="btn-group">
                <a class="btn btn-primary" href="index.php?p=moncompte"><i class="icon-user icon-white"></i> <?php echo $b; ?></a>
                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="index.php?p=mesbusinessplan"><i class="icon-list-alt"></i> Mes businness plan</a></li>
                    <li><a href="index.php?p=moncompte"><i class="icon-wrench"></i> Mon compte</a></li>
                    <li class="divider"></li>
                    <li><a href="index.php?p2=deconnect"><i class="icon-remove"></i> Déconnexion</a></li>
                </ul>
            </div>
        <?php
    }
?>