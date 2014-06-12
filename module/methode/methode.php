<cms:template title='Methode' />
<div class="container">
    <legend>Méthode</legend>
        <blockquote>
            <p style="font-size: 14px;">
                <Strong>
                    <cms:editable name='methodeheader' type='richtext'>
                        Le contenu a été développé par l’Unité Mode d’élevage, bien-être et qualité du Département Productions et
                        Filières du CRA-W. Il a été conçu pour réaliser les estimations de manière simple et complète pour la
                        plupart des situations.
                    </cms:editable>
                </strong>
            </p>
        </blockquote>
        
        <ul class="nav nav-tabs" id="menuMethode">
            <li <?php if(!isset($_GET["p2"])) echo "class=active"; ?>>
                <a href="index.php?p=methode">Présentation</a>
            </li>
            <li <?php if(isset($_GET["p2"]) AND $_GET["p2"] == "resultat") echo "class=active"; ?>>
                <a href="index.php?p=methode&p2=resultat">Résultats</a>
            </li>
            <li <?php if(isset($_GET["p2"]) AND $_GET["p2"] == "precision") echo "class=active"; ?>>
                <a href="index.php?p=methode&p2=precision">Tuyau</a>
            </li>
        </ul>
    
        <?php include 'module/methode/formMethode.php'; ?>
</div>
