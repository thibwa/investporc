<?php
    if($controleur->allowMaster())
        $controleur->forbidden();
        
?>

<div class="container">
    <div class="row">
        <div class="span12">
            <legend>Statistique</legend>
            <blockquote>
                <p style="font-size: 14px;">
                    <Strong>
                        Le module de statistique vous permet de consulter le nombre de visites, etc.
                    </strong>
                </p>
            </blockquote>
        </div>
        
        <div class="span5">
            <iframe marginwidth="0"   frameborder="0"  marginheight="0" width="500" height="350" src="http://www.embeddedanalytics.com/reports/displayreport?reportcode=wZHuTeASNJ&chckcode=gaaTCeSqfcYO6PNa5Znf6v" type="text/html"  scrolling="no" title="EmbeddedAnalytics - Embed Realtime Google Analytics Charts into your Website!"></iframe>
        </div>
        
        <div class="span7">
            <iframe marginwidth="0"   frameborder="0"  marginheight="0" width="600" height="350" src="http://www.embeddedanalytics.com/reports/displayreport?reportcode=hqoqcvOZli&chckcode=gaaTCeSqfcYO6PNa5Znf6v" type="text/html"  scrolling="no" title="EmbeddedAnalytics - Embed Realtime Google Analytics Charts into your Website!"></iframe>
        </div>
    </div>
</div>