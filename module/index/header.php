<!-- Header
================================================== --> 
<meta charset="utf-8">
<title>CRAW - Module de calcul porc bio et plein air</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />

<meta name="description" content="">
<meta name="author" content="Wavreille Thibaut">

<!-- Le styles -->
<link href="plugins/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" >
<link href="plugins/bootstrap/css/bootstrap-responsive.css" type="text/css" rel="stylesheet" >
<link href="css/index.css" type="text/css" rel="stylesheet">
<link href="css/fade.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="css/jquery.aristo.css" />

<!-- Le javascript -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script type="text/javascript" src="js/jstat/jquery.flot.js" ></script>
<script type="text/javascript" src="js/jstat/jquery.flot.pie.js" ></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/jstat/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="js/jstat/jquery.flot.threshold.js"></script>
<script language="javascript" type="text/javascript" src="js/external/jquery.cookie.js" ></script>
<script language="javascript" type="text/javascript" src="js/coin-slider.min.js"></script>
<script language="javascript" type="text/javascript" src="js/fonctions.js"></script>
<script language="javascript" type="text/javascript" src="js/calcul.js"></script>
<script language="javascript" type="text/javascript" src="plugins/bootstrap/js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/md5.js"></script>
<script language="javascript" type="text/javascript" src="js/filter.js"></script>
<script language="javascript" type="text/javascript" src="js/jqueryEasing.js"></script>



<!--[if IE]>
    <script src="js/html5shiv.js"></script>

    <style type="text/css">
        html,body
        {
            top: auto;
            height: 100%;
            margin-top: 60px;
        }
    </style>
<![endif]-->

<!--TODO update !!! -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41394598-1', 'alpinistesarboricoles.be');
  ga('send', 'pageview');

</script>

<?php
    include 'LogiqueApplicative/Controleur.php';
    $controleur = new Controleur();
?>

<!-- /Header -->    