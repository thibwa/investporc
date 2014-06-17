<?php
require_once('LogiqueApplicative/calcul/formules.php');
// TODO UPDATE LINK !!!
$serv = "http" . (($_SERVER["HTTPS"] == "on") ? 's' : '') . "://" . $_SERVER["SERVER_NAME"] . "/TFE/";;

if (!$controleur->getAllReponseFormCalcul(session_id()))
    header("location: " . $serv . "index.php?p=formulaire&p2=error");

$list = $controleur->getAllReponseFormCalcul(session_id());
?>

<div class="visible-desktop pull-right">
    <img src="img/printer.png" id="printerCalcul" onclick="javascript:printerResultat()"
         title="Impression du business plan"/>
</div>
<br/>

<h3>Investissement de cheptel</h3>
<table class="table">
    <tr>
        <td style="width: 84%;">Achat des truies</td>
        <td style="text-align: right;"><?php echo number_format(ctt($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Achat des verrats</td>
        <td style="text-align: right;"><?php echo number_format(ctv($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Achat des porcs à l'engraissement</td>
        <td style="text-align: right;"><?php echo number_format(cte($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr class="active">
        <td style="width: 84%;"><strong>Coût total d'achat du cheptel (7 ans)</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(ctd($list), 2, ',', '.'); ?> €</strong></td>
    </tr>
</table>

<h3>Investissement hébergement hors bâtiments</h3>
<table class="table">
    <tr class="active">
        <td style="width: 84%;"><strong>Coût total des aménagements dont l'hébergement hors bâtiments (7 ans)</strong>
        </td>
        <td style="text-align: right;"><strong><?php echo number_format(ahb($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
</table>

<h3>Investissement bâtiments neufs</h3>
<table class="table">
    <tr>
        <td style="width: 84%;">Bâtiments de maternité</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mbnm', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Bâtiments de gestation</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mbng', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Bâtiments de post-sevrage</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mbnpav', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Bâtiments d'engraissement</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mbne', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Bâtiments autres</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mab', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr class="active">
        <td style="width: 84%;"><strong>Coût total des bâtiments (15 ans)</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(cb($list), 2, ',', '.'); ?> €</strong></td>
    </tr>
</table>

<h3>Coûts annuels des investissements</h3>
<table class="table">
    <tr class="info">
        <td style="width: 84%;"><strong>Coût annuel des investissements pendant 7 ans</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(caciav7($list, $listF), 2, ',', '.'); ?> €</strong></td>
    </tr>
    <tr class="info">
        <td style="width: 84%;"><strong>Coût annuel des investissements pendant 15 ans</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(caci15($list, $listF), 2, ',', '.'); ?> €</strong></td>
    </tr>
</table>

<h3>Renouvellement du cheptel</h3>
<table class="table">
    <?php
    if (getValue('naissage', $list) == 'Non') {
        ?>
        <tr class="info">
            <td style="width: 84%;"><strong>Coût annuel de cheptel (année 1)</strong></td>
            <td style="text-align: right;"><strong><?php echo number_format(racan1($list), 2, ',', '.'); ?> €</strong></td>
        </tr>
        <tr class="info">
            <td style="width: 84%;"><strong>Coût annuel de cheptel (année 2)</strong></td>
            <td style="text-align: right;"><strong><?php echo number_format(racan2Plus($list), 2, ',', '.'); ?> €</strong></td>
        </tr>
    <?php
    } else {
        ?>
        <tr class="info">
            <td style="width: 84%;"><strong>Coût annuel de cheptel</strong></td>
            <td style="text-align: right;"><strong><?php echo number_format(rac($list), 2, ',', '.'); ?> €</strong></td>
        </tr>
    <?php
    }
    ?>
</table>

<h3>Aliments</h3>
<table class="table">
    <tr>
        <td style="width: 84%;">Aliments de lactation</td>
        <td style="text-align: right;"><?php echo number_format(somlacpx($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Aliments de gestation (truies et verrats)</td>
        <td style="text-align: right;"><?php echo number_format(somgespx($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Aliments pour porcelets</td>
        <td style="text-align: right;"><?php echo number_format(sompclpx($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Aliments d'engraissement</td>
        <td style="text-align: right;"><?php echo number_format(somengpx($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr class="info">
        <td style="width: 84%;"><strong>Coût total des aliments</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(ali($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
</table>

<h3>Divers</h3>
<table class="table">
    <tr>
        <td style="width: 84%;">Paille</td>
        <td style="text-align: right;"><?php echo number_format(pai($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Prairies</td>
        <td style="text-align: right;"><?php echo number_format(pra($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Eau</td>
        <td style="text-align: right;"><?php echo number_format(eau($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Electricité</td>
        <td style="text-align: right;"><?php echo number_format(ele($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Frais de certification</td>
        <td style="text-align: right;"><?php echo number_format(fc($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Frais sanitaires</td>
        <td style="text-align: right;"><?php echo number_format(fsa($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Frais de vétérinaires</td>
        <td style="text-align: right;"><?php echo number_format(fv($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Matériel agricole roulant</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mar', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Assurance</td>
        <td style="text-align: right;"><?php echo number_format(ass($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Divers</td>
        <td style="text-align: right;"><?php echo number_format(div($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr class="info">
        <td style="width: 84%;"><strong>Coût total des divers</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(tot_div($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
</table>

<h3>Ventes</h3>
<table class="table">
    <tr class="warning">
        <td style="width: 84%;"><strong>Vente de porcs d'engraissement</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(vpg($list, $listF), 2, ',', '.'); ?> €</strong></td>
    </tr>
    <tr class="warning">
        <td style="width: 84%;"><strong>Vente de porcelets</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(vp($list), 2, ',', '.'); ?> €</strong></td>
    </tr>
</table>

<h3>Recettes annuelles</h3>
<table class="table">
    <tr <?php if (rt1($list, $listF) == 0) echo 'class=info'; else if (rt1($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Année 1</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rt1($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
    <tr <?php if (rtAp1($list, $listF) == 0) echo 'class=info'; else if (rtAp1($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années > 1 </strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rtAp1($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
</table>

<h3>Charges annuelles</h3>
<table class="table">
    <tr <?php if (ch1($list, $listF) == 0) echo 'class=info'; else if (ch1($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Année 1</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(ch1($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
    <tr <?php if (chav7($list, $listF) == 0) echo 'class=info'; else if (chav7($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années 2 à 7</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(chav7($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
    <tr <?php if (chap7($list, $listF) == 0) echo 'class=info'; else if (chap7($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années 8 à 15</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(chap7($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
    <tr <?php if (chap15($list, $listF) == 0) echo 'class=info'; else if (chap15($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années > 15</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(chap15($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
</table>

<h3>Revenus annuels dégagés</h3>
<table class="table">
    <tr <?php if (rbr1($list, $listF) == 0) echo 'class=info'; else if (rbr1($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Année 1</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rbr1($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
    <tr <?php if (rbrav7($list, $listF) == 0) echo 'class=info'; else if (rbrav7($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années 2 à 7</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rbrav7($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
    <tr <?php if (rbrap7($list, $listF) == 0) echo 'class=info'; else if (rbrap7($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années 8 à 15</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rbrap7($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
    <tr <?php if (rbrap15($list, $listF) == 0) echo 'class=info'; else if (rbrap15($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années > 15</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rbrap15($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
</table>

<div class="hidden-phone">
    <legend>Répartition des investissements</legend>
    <div id="graph1" class="graph" style="width: 480px;height: 250px;"></div>
    <legend>Répartition des charges pour les années 2 à 7</legend>
    <div id="graph2" class="graph" style="width: 480px;height: 250px;"></div>
    <legend>Revenus cumulés sur 10 ans</legend>
    <div id="graph3" class="graph" style="width: 700px;height: 350px;"></div>
</div>

<script type="text/javascript">
    // data
    var data1 = [
        { label: "Cheptel de départ", data: <?php echo round(ctd($list),0);?>},
        { label: "Aménagements hors bâtiment", data: <?php echo round(ahb($list, $listF),0);?>},
        { label: "Bâtiment(s)", data: <?php echo round(cb($list),0);?>}
    ];

    var data2 = [
        { label: "Alimentation", data: <?php echo ali($list, $listF);?>},
        { label: "Annuités pour investissement", data: <?php echo cacitot($list, $listF);?>},
        { label: "Matériels roulant", data: <?php echo getValue('mar', $list);?>},
        { label: "Prairie", data: <?php echo pra($list);?>},
        { label: "Renouvellement du cheptel", data: <?php echo rac($list, $listF) + racan1($list) + racan2Plus($list);?>},
        { label: "Frais de troupeau", data: <?php echo (fv($list, $listF)+fsa($list, $listF)+fc($list, $listF)+div($list, $listF));?>},
        { label: "Frais d'eploitation", data: <?php echo (pai($list, $listF)+ass($list, $listF)+ele($list, $listF)+eau($list, $listF));?>}
    ];

    // GRAPH 1
    $.plot($("#graph1"), data1,
        {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 2 / 4,
                        formatter: function (label, series) {
                            return Math.round(series.percent) + '%';
                        },
                        background: { opacity: 0.5 }
                    }
                }
            },
            legend: {
                show: true
            }
        });

    // GRAPH 2
    $.plot($("#graph2"), data2,
        {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 2 / 4,
                        formatter: function (label, series) {
                            return Math.round(series.percent) + '%';
                        },
                        background: { opacity: 0.5 }
                    }
                }
            },
            legend: {
                show: true
            }
        });

    var d1 = [];
    d1.push([1, <?php echo rbr1($list, $listF);?>]);
    d1.push([2, <?php echo rbr1($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([3, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([4, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([5, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([6, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([7, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([8, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrap7($list, $listF);?>]);
    d1.push([9, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrap7($list, $listF) + rbrap7($list, $listF);?>]);
    d1.push([10, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrap7($list, $listF) + rbrap7($list, $listF) + rbrap7($list, $listF);?>]);

    $.plot("#graph3", [
        {
            data: d1,
            color: "rgb(30, 180, 20)",
            threshold: {
                below: 0,
                color: "rgb(200, 20, 30)"
            },
            lines: {
                steps: true
            }
        }
    ]);
</script>
<?php
require_once('LogiqueApplicative/calcul/formules.php');
// TODO UPDATE LINK !!!
$serv = "http" . (($_SERVER["HTTPS"] == "on") ? 's' : '') . "://" . $_SERVER["SERVER_NAME"] . "/TFE/";;

if (!$controleur->getAllReponseFormCalcul(session_id()))
    header("location: " . $serv . "index.php?p=formulaire&p2=error");

$list = $controleur->getAllReponseFormCalcul(session_id());
?>

<div class="visible-desktop pull-right">
    <img src="img/printer.png" id="printerCalcul" onclick="javascript:printerResultat()"
         title="Impression du business plan"/>
</div>
<br/>

<h3>Investissement de cheptel</h3>
<table class="table">
    <tr>
        <td style="width: 84%;">Achat des truies</td>
        <td style="text-align: right;"><?php echo number_format(ctt($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Achat des verrats</td>
        <td style="text-align: right;"><?php echo number_format(ctv($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Achat des porcs à l'engraissement</td>
        <td style="text-align: right;"><?php echo number_format(cte($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr class="active">
        <td style="width: 84%;"><strong>Coût total d'achat du cheptel (7 ans)</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(ctd($list), 2, ',', '.'); ?> €</strong></td>
    </tr>
</table>

<h3>Investissement hébergement hors bâtiments</h3>
<table class="table">
    <tr class="active">
        <td style="width: 84%;"><strong>Coût total des aménagements dont l'hébergement hors bâtiments (7 ans)</strong>
        </td>
        <td style="text-align: right;"><strong><?php echo number_format(ahb($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
</table>

<h3>Investissement bâtiments neufs</h3>
<table class="table">
    <tr>
        <td style="width: 84%;">Bâtiments de maternité</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mbnm', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Bâtiments de gestation</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mbng', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Bâtiments de post-sevrage</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mbnpav', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Bâtiments d'engraissement</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mbne', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Bâtiments autres</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mab', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr class="active">
        <td style="width: 84%;"><strong>Coût total des bâtiments (15 ans)</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(cb($list), 2, ',', '.'); ?> €</strong></td>
    </tr>
</table>

<h3>Coûts annuels des investissements</h3>
<table class="table">
    <tr class="info">
        <td style="width: 84%;"><strong>Coût annuel des investissements pendant 7 ans</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(caciav7($list, $listF), 2, ',', '.'); ?> €</strong></td>
    </tr>
    <tr class="info">
        <td style="width: 84%;"><strong>Coût annuel des investissements pendant 15 ans</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(caci15($list, $listF), 2, ',', '.'); ?> €</strong></td>
    </tr>
</table>

<h3>Renouvellement du cheptel</h3>
<table class="table">
    <?php
    if (getValue('naissage', $list) == 'Non') {
        ?>
        <tr class="info">
            <td style="width: 84%;"><strong>Coût annuel de cheptel (année 1)</strong></td>
            <td style="text-align: right;"><strong><?php echo number_format(racan1($list), 2, ',', '.'); ?> €</strong></td>
        </tr>
        <tr class="info">
            <td style="width: 84%;"><strong>Coût annuel de cheptel (année 2)</strong></td>
            <td style="text-align: right;"><strong><?php echo number_format(racan2Plus($list), 2, ',', '.'); ?> €</strong></td>
        </tr>
    <?php
    } else {
        ?>
        <tr class="info">
            <td style="width: 84%;"><strong>Coût annuel de cheptel</strong></td>
            <td style="text-align: right;"><strong><?php echo number_format(rac($list), 2, ',', '.'); ?> €</strong></td>
        </tr>
    <?php
    }
    ?>
</table>

<h3>Aliments</h3>
<table class="table">
    <tr>
        <td style="width: 84%;">Aliments de lactation</td>
        <td style="text-align: right;"><?php echo number_format(somlacpx($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Aliments de gestation (truies et verrats)</td>
        <td style="text-align: right;"><?php echo number_format(somgespx($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Aliments pour porcelets</td>
        <td style="text-align: right;"><?php echo number_format(sompclpx($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Aliments d'engraissement</td>
        <td style="text-align: right;"><?php echo number_format(somengpx($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr class="info">
        <td style="width: 84%;"><strong>Coût total des aliments</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(ali($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
</table>

<h3>Divers</h3>
<table class="table">
    <tr>
        <td style="width: 84%;">Paille</td>
        <td style="text-align: right;"><?php echo number_format(pai($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Prairies</td>
        <td style="text-align: right;"><?php echo number_format(pra($list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Eau</td>
        <td style="text-align: right;"><?php echo number_format(eau($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Electricité</td>
        <td style="text-align: right;"><?php echo number_format(ele($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Frais de certification</td>
        <td style="text-align: right;"><?php echo number_format(fc($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Frais sanitaires</td>
        <td style="text-align: right;"><?php echo number_format(fsa($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Frais de vétérinaires</td>
        <td style="text-align: right;"><?php echo number_format(fv($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Matériel agricole roulant</td>
        <td style="text-align: right;"><?php echo number_format(getValue('mar', $list), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Assurance</td>
        <td style="text-align: right;"><?php echo number_format(ass($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr>
        <td style="width: 84%;">Divers</td>
        <td style="text-align: right;"><?php echo number_format(div($list, $listF), 2, ',', '.'); ?> €</td>
    </tr>
    <tr class="info">
        <td style="width: 84%;"><strong>Coût total des divers</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(tot_div($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
</table>

<h3>Ventes</h3>
<table class="table">
    <tr class="warning">
        <td style="width: 84%;"><strong>Vente de porcs d'engraissement</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(vpg($list, $listF), 2, ',', '.'); ?> €</strong></td>
    </tr>
    <tr class="warning">
        <td style="width: 84%;"><strong>Vente de porcelets</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(vp($list), 2, ',', '.'); ?> €</strong></td>
    </tr>
</table>

<h3>Recettes annuelles</h3>
<table class="table">
    <tr <?php if (rt1($list, $listF) == 0) echo 'class=info'; else if (rt1($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Année 1</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rt1($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
    <tr <?php if (rtAp1($list, $listF) == 0) echo 'class=info'; else if (rtAp1($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années > 1 </strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rtAp1($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
</table>

<h3>Charges annuelles</h3>
<table class="table">
    <tr <?php if (ch1($list, $listF) == 0) echo 'class=info'; else if (ch1($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Année 1</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(ch1($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
    <tr <?php if (chav7($list, $listF) == 0) echo 'class=info'; else if (chav7($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années 2 à 7</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(chav7($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
    <tr <?php if (chap7($list, $listF) == 0) echo 'class=info'; else if (chap7($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années 8 à 15</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(chap7($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
    <tr <?php if (chap15($list, $listF) == 0) echo 'class=info'; else if (chap15($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années > 15</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(chap15($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
</table>

<h3>Revenus annuels dégagés</h3>
<table class="table">
    <tr <?php if (rbr1($list, $listF) == 0) echo 'class=info'; else if (rbr1($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Année 1</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rbr1($list, $listF), 2, ',', '.'); ?> €</strong>
        </td>
    </tr>
    <tr <?php if (rbrav7($list, $listF) == 0) echo 'class=info'; else if (rbrav7($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années 2 à 7</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rbrav7($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
    <tr <?php if (rbrap7($list, $listF) == 0) echo 'class=info'; else if (rbrap7($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années 8 à 15</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rbrap7($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
    <tr <?php if (rbrap15($list, $listF) == 0) echo 'class=info'; else if (rbrap15($list, $listF) > 0) echo 'class=success'; else echo 'class=error'; ?>>
        <td style="width: 84%;"><strong>Années > 15</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format(rbrap15($list, $listF), 2, ',', '.'); ?>
                €</strong></td>
    </tr>
</table>

<div class="hidden-phone">
    <legend>Répartition des investissements</legend>
    <div id="graph1" class="graph" style="width: 480px;height: 250px;"></div>
    <legend>Répartition des charges pour les années 2 à 7</legend>
    <div id="graph2" class="graph" style="width: 480px;height: 250px;"></div>
    <legend>Revenus cumulés sur 10 ans</legend>
    <div id="graph3" class="graph" style="width: 700px;height: 350px;"></div>
</div>

<script type="text/javascript">
    // data
    var data1 = [
        { label: "Cheptel de départ", data: <?php echo round(ctd($list),0);?>},
        { label: "Aménagements hors bâtiment", data: <?php echo round(ahb($list, $listF),0);?>},
        { label: "Bâtiment(s)", data: <?php echo round(cb($list),0);?>}
    ];

    var data2 = [
        { label: "Alimentation", data: <?php echo ali($list, $listF);?>},
        { label: "Annuités pour investissement", data: <?php echo cacitot($list, $listF);?>},
        { label: "Matériels roulant", data: <?php echo getValue('mar', $list);?>},
        { label: "Prairie", data: <?php echo pra($list);?>},
        { label: "Renouvellement du cheptel", data: <?php echo rac($list, $listF) + racan1($list) + racan2Plus($list);?>},
        { label: "Frais de troupeau", data: <?php echo (fv($list, $listF)+fsa($list, $listF)+fc($list, $listF)+div($list, $listF));?>},
        { label: "Frais d'eploitation", data: <?php echo (pai($list, $listF)+ass($list, $listF)+ele($list, $listF)+eau($list, $listF));?>}
    ];

    // GRAPH 1
    $.plot($("#graph1"), data1,
        {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 2 / 4,
                        formatter: function (label, series) {
                            return Math.round(series.percent) + '%';
                        },
                        background: { opacity: 0.5 }
                    }
                }
            },
            legend: {
                show: true
            }
        });

    // GRAPH 2
    $.plot($("#graph2"), data2,
        {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 2 / 4,
                        formatter: function (label, series) {
                            return Math.round(series.percent) + '%';
                        },
                        background: { opacity: 0.5 }
                    }
                }
            },
            legend: {
                show: true
            }
        });

    var d1 = [];
    d1.push([1, <?php echo rbr1($list, $listF);?>]);
    d1.push([2, <?php echo rbr1($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([3, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([4, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([5, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([6, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([7, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF);?>]);
    d1.push([8, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrap7($list, $listF);?>]);
    d1.push([9, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrap7($list, $listF) + rbrap7($list, $listF);?>]);
    d1.push([10, <?php echo rbr1($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrav7($list, $listF) + rbrap7($list, $listF) + rbrap7($list, $listF) + rbrap7($list, $listF);?>]);

    $.plot("#graph3", [
        {
            data: d1,
            color: "rgb(30, 180, 20)",
            threshold: {
                below: 0,
                color: "rgb(200, 20, 30)"
            },
            lines: {
                steps: true
            }
        }
    ]);
</script>
