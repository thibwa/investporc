<div class="container">
    <div class="visible-desktop">    
        <?php include 'module/contact/formDesktop.php' ?>
    </div>

    <div class="hidden-desktop">
        <ul class="nav nav-tabs">
            <li <?php if(!isset($_GET["p2"])) echo "class=active"; ?>>
                <a href="index.php?p=contact">Carte</a>
            </li>
            <li <?php if(isset($_GET["p2"]) AND $_GET["p2"] == "informations") echo "class=active"; ?>>
                <a href="index.php?p=contact&p2=informations">Informations</a>
            </li>
            <li <?php if(isset($_GET["p2"]) AND $_GET["p2"] == "formulaire") echo "class=active"; ?>>
                <a href="index.php?p=contact&p2=formulaire">Formulaire</a>
            </li>
        </ul>

        <?php include 'module/contact/formPhone.php' ?>
    </div>

</div>