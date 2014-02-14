<?php
    if($controleur->allowMaster())
        $controleur->forbidden();
    
    if(isset($_GET["p2"]))
    {
        if($_GET["p2"] != "")
        {
            if ($controleur->suppressionUser($_GET["p2"]))
                header('Location: index.php?p=allUser');
        }
            
    }
?>

<div class="container">
    <div class="row">
        <div class="span12">
            <legend>Gèrer les comptes des utilisateurs d'InvestPorc</legend>
            <blockquote>
                <p style="font-size: 14px;">
                    <Strong>
                        Le module de gestion des comptes des utilisateurs vous permet de modérer les comptes.
                    </strong>
                </p>
            </blockquote>
        </div>
        
        <div class="span12">
            <?php
                //Voir businessplan
                if(isset($_GET["p3"]))
                {
                    if($_GET["p3"] != "")
                    {
                        ?>
                            <table class="table table-striped" id="tableAllUser">
                                <thead>
                                  <tr>
                                    <th scope='col' width="50px">#</th>
                                    <th scope='col'>Date</th>
                                    <th width="5%">Detail</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        //Rapatriement de tous les objets de type Membre
                                        $list = $controleur->getAllBusinessPlan($_GET["p3"]);

                                        for($i = 0; $i < Count($list); $i++)
                                            echo $list[$i];
                                    ?>
                                </tbody>
                              </table>
                        <?php
                    }

                }
                else
                {
            ?>
                <table class="table table-striped" id="tableAllUser">
                  <thead>
                    <tr>
                      <th scope='col' width="50px">#</th>
                      <th scope='col'>Nom, Prénom</th>
                      <th scope='col'>Adresse email</th>
                      <th width="12%">Business plan</th>
                      <th width="10%">Suppression</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                          //Rapatriement de tous les objets de type Membre
                          $list = $controleur->getAllUser();

                          for($i = 0; $i < Count($list); $i++)
                              echo $list[$i];
                      ?>
                  </tbody>
                </table>
            <?php } ?>
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