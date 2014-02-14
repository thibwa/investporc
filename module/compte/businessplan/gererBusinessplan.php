<?php
    if(!$controleur->allow())
        $controleur->forbidden();
    
    if(isset($_GET["p2"]))
    {
        if($_GET["p2"] != "")
        {
            if ($controleur->suppressionBusinessplan($_GET["p2"], $_GET["p3"]))
                header('Location: index.php?p=mesbusinessplan');
        }
            
    }
?>

<div class="container">
    <div class="row">
        <div class="span12">
            <legend>Gèrer mes business plan</legend>
            <blockquote>
                <p style="font-size: 14px;">
                    <Strong>
                        Le module de gestion des business plan vous permet d'accéder à d'anciens business plan sauvegardés. En cliquant sue l'icone bleu d'un crayon,
                        vous pouvez consulter le formulaire chargé de vos réponses et calculer de nouveau le résultat économique.
                    </strong>
                </p>
            </blockquote>
            
            <div class="span8">
            <table class="table table-striped" id="tableAllUser">
              <thead>
                <tr>
                  <th scope='col' width="50px">#</th>
                  <th scope='col'>Date</th>
                  <th width="5%">Detail</th>
                  <th width="10%">Suppression</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                      //Rapatriement de tous les objets de type Membre
                      $list = $controleur->getAllBusinessPlan($controleur->user('email'));

                      for($i = 0; $i < Count($list); $i++)
                          echo $list[$i];
                  ?>
              </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script language="javascript" type="text/javascript">
//<![CDATA[
        setProtocole(1);
        var table1Filters = {
                col_0: "select"
        }
        setFilterGrid("tableAllUser",table1Filters);
//]]>
</script>