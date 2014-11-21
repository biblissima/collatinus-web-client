<?php
session_start();

require_once('common.php');

//---- Init variables
$dico = "";
$langue = "";

//---- Function to print option tags
function linOpt($choix, $val, $option) {
  if ($val == $choix)
    $sel = " selected";
  else
    $sel = "";
  return "<option value=\"$val\"$sel>$option</option>\n";
}

//---- function to build tokens
function generateFormToken($form) {
   // generate a token from an unique value
  $token = md5(uniqid(microtime(), true));  
  
  // Write the generated token to the session variable to check it against the hidden field when the form is sent
  $_SESSION[$form.'_token'] = $token;
  
  return $token;
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Collatinus-web - lemmatiseur de textes latins | Boîte à outils Biblissima</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- metas -->
    <meta name="description" content="Collatinus-web est la version en ligne de Collatinus, un logiciel libre, gratuit et multi-plateforme pour la lemmatisation et l'analyse morphologique de textes latins.">
    <meta name="author" content="Yves Ouvrard">
    <meta name="author" content="Philippe Verkerk">
    <meta name="author" content="Régis Robineau">    
    <meta property="twitter:url" content="http://outils.biblissima.fr/collatinus-web">
    <meta property="twitter:title" content="Collatinus-web : lemmatiseur et analyseur morphologique de textes latins">
    <meta property="twitter:card" content="summary">
    <meta property="twitter:description" content="Collatinus-web est la version en ligne de Collatinus, un logiciel libre, gratuit et multi-plateforme pour la lemmatisation et l'analyse morphologique de textes latins.">
    <meta property="og:site_name" content="Collatinus-web | Boîte à outils Biblissima">
    <meta property="og:url" content="http://outils.biblissima.fr/collatinus-web">
    <meta property="og:title" content="Collatinus-web : lemmatiseur et analyseur morphologique de textes latins">
    <meta property="og:type" content="website">
    <meta property="og:description" content="Collatinus-web est la version en ligne de Collatinus, un logiciel libre, gratuit et multi-plateforme pour la lemmatisation et l'analyse morphologique de textes latins.">
    
    <script type="application/ld+json">
    {
      "@context" : "http://schema.org",
      "@type" : "WebApplication",
      "license": "http://creativecommons.org/licenses/by-nc/4.0/",
      "name" : "Collatinus web",
      "image" : "http://outils.biblissima.fr/collatinus-web/img/pseudo-sappho.png",
      "url" : "http://outils.biblissima.fr/collatinus-web",
      "description" : "Collatinus web est la version en ligne de Collatinus, un logiciel libre, gratuit et multi-plateforme pour la lemmatisation et l'analyse morphologique de textes latins.",
      "provider" : {
        "@type" : "Organization",
        "name" : "Equipex Biblissima"
      },
      "creator" : [{
        "@type" : "Person",
        "name" : "Yves Ouvrard"
      },
      {
        "@type" : "Person",
        "name" : "Philippe Verkerk"
      }],
      "contributor" : [
      {
        "@type" : "Person",
        "name" : "Régis Robineau"
      },
      {
        "@type" : "Person",
        "name" : "Eduard Frunzeanu"
      }]
    }
    </script>
    
    <!-- css -->
    <link href="<?php echo $staticBaseUrl; ?>libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $staticBaseUrl; ?>css/style.css" rel="stylesheet">
    <link href="http://outils.biblissima.fr/collatinus/css/style.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" type="image/png" href="favicon.png">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class="navbar navbar-default navbar-static-top">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand logo-biblissima pfm" href="http://www.biblissima-condorcet.fr" title="Site web de Biblissima"><span>biblissima</span></a>
        <p class="navbar-text">
          <a href="http://outils.biblissima.fr" title="Accueil Boîte à outils Biblissima">Boîte à outils</a>
        </p>
      </div>
    </div>
    
    <!-- jumbotron -->
    <div class="jumbotron">
      <div class="container">
        <div class="pull-left hidden-xs logo"></div>
        <h1>Collatinus-web <small class="text-danger">[bêta]</small></h1>
        <p>Version web du lemmatiseur et analyseur morphologique de textes latins</p>
        <a class="btn btn-primary" data-placement="bottom" data-toggle="tooltip" data-original-title="Page de téléchargement de Collatinus" href="http://outils.biblissima.fr/collatinus">Tester la version pour bureau <small>(Mac, Windows, GNU/Linux)</small></a>
      </div>
    </div><!-- /.jumbotron -->
    
    <div class="container">
      
      <div class="well">
        <p>Ceci est la version web du logiciel multi-plateforme <a href="http://outils.biblissima.fr/collatinus" title="Page de téléchargement de Collatinus">Collatinus</a>, un <strong>lemmatiseur</strong> et <strong>analyseur morphologique</strong> de textes latins.</p>
        <p><strong class="text-danger">Cette application est actuellement en version bêta</strong>. Elle est mise à disposition sans aucune garantie et reste soumise à corrections et améliorations.</p>
      </div>
      
      <?php
        // generate tokens for the $_SESSION superglobal and put them in a hidden field
        $token = generateFormToken('form_lemme');
      ?>
      
      <!-- Recherche -->
      <form method="post" role="form" class="form-lemme">
        <label for="recherche_lemme" class="main-label">Rechercher un lemme</label>
        <div class="form-group form-inline">
          <input type="text" name="lemme" id="recherche_lemme" value="" class="form-control" size="40" placeholder="Entrez un mot latin...">
          
          <label for="dicos">&nbsp;dans le&nbsp;</label>
          <select name="dicos" id="dicos">
            <?php
              echo linOpt($dico, "dga:", "Gaffiot");
              echo linOpt($dico, "dca:", "Calonghi");
              echo linOpt($dico, "dle:", "Lewis & Short");
              echo linOpt($dico, "ddu:", "du Cange");
              echo linOpt($dico, "dge:", "Georges");
              echo linOpt($dico, "dva:", "Valbuena");
              echo linOpt($dico, "dje:", "Jeanneau");
            ?>
          </select>
          
          <input type="submit" value="Rechercher" class="btn btn-success">
          
          <input type="hidden" name="opera" value="consult">
          <input type="hidden" name="token" value="<?php echo $token; ?>">
        </div>
      </form>
      
      <!-- Flexion -->
      <form method="post" role="form" class="form-lemme">
        <label for="flexion_lemme" class="main-label">Fléchir un lemme</label>
        <div class="form-group form-inline">
          <input type="text" name="lemme" id="flexion_lemme" value="" class="form-control" size="40" placeholder="Entrez un mot latin...">
          
          <input type="submit" value="Fléchir" class="btn btn-success">
          
          <input type="hidden" name="opera" value="flexion">
          <input type="hidden" name="token" value="<?php echo $token; ?>">
        </div>
      </form>
      
      <!-- Traitement texte -->
      <form method="post" role="form" class="form-lemme">
        <label for="traitement_texte" class="main-label">Traiter un texte latin</label>
        <div class="form-group">
          <textarea name="texte" id="traitement_texte" value="" class="form-control" rows="6" cols="80" placeholder="Entrez un texte latin..."></textarea>
        </div>
        
        <div class="form-group form-inline">        
          <label for="langue">Langue cible&nbsp;</label>
          <select name="langue" id="langue">
            <?php
              echo linOpt($langue, "fr:", "français");
              echo linOpt($langue, "it:", "italien");
              echo linOpt($langue, "ca:", "catalan");
              echo linOpt($langue, "de:", "allemand");
              echo linOpt($langue, "uk:", "anglais");
              echo linOpt($langue, "es:", "espagnol");
              echo linOpt($langue, "gl:", "galicien");
              //echo linOpt($langue, "ro:", "roumain");
            ?>
          </select>
          
          <input type="submit" name="action" value="Lemmatiser" class="btn btn-success">
          <input type="submit" name="action" value="Analyser" class="btn btn-success">
          <input type="submit" name="action" value="Scander" class="btn btn-success">
          <button type="reset" name="action" value="Effacer" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove-circle"></span> Effacer</button>
          
          <input type="hidden" name="opera" value="traite_txt">
          <input type="hidden" name="token" value="<?php echo $token; ?>">
        </div>
        
      </form>
      
      <div id="results"></div>
  
      <div class="well">
        <h3>Crédits</h3>
        <p>Collatinus-web est développé par Yves Ouvrard, avec l'aide de Philippe Verkerk et Régis Robineau.</p>
        <!--<p>Merci à Eduard Frunzeanu pour sa contribution à l'intégration du roumain.</p>-->
      </div>
      
      <!-- Bouton scrollTop -->
      <div id="scrollToTop"><a href="#"><span class="glyphicon glyphicon-circle-arrow-up"></span></a></div>

    </div><!-- /.container -->
    
    <!-- Fenetre modale pour alertes -->
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-error">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
          </div>
          <div class="modal-body">
            <div class="alert alert-warning">
              Veuillez saisir un texte dans un des champs.
            </div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <footer class="site-footer" role="contentinfo">
      <div class="container">
        
        <div class="col-sm-10">
          <p class="navbar-text">
            <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"><img alt="Creative Commons License" style="border-width:0" src="<?php echo $staticBaseUrl; ?>img/cc-by-nc-4.0-88x31.png" /></a>&nbsp; <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a><br />
            <small>Yves Ouvrard et Philippe Verkerk, 2014 &ndash; Programme mis à votre disposition sans aucune garantie, mais avec l'espoir qu'il vous sera utile.</small></p>
        </div>
        
        <div class="col-sm-2">
          <p class="navbar-text text-muted"><span class="glyphicon glyphicon-envelope"></span>&nbsp;<a href="mailto:&#99;&#111;&#108;&#108;&#97;&#116;&#105;&#110;&#117;&#115;&#64;&#98;&#105;&#98;&#108;&#105;&#115;&#115;&#105;&#109;&#97;&#45;&#99;&#111;&#110;&#100;&#111;&#114;&#99;&#101;&#116;&#46;&#102;&#114;">Feedback</a></p>
        </div>
      </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo $staticBaseUrl; ?>libs/jquery-1.10.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo $staticBaseUrl; ?>libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    
    <!-- Piwik -->
    <script type="text/javascript">
       var _paq = _paq || [];
       _paq.push(['trackPageView']);
       _paq.push(['enableLinkTracking']);
       (function() {
       var u=(("https:" == document.location.protocol) ? "https" : "http") + "://piwik.biblissima-condorcet.fr/";
       _paq.push(['setTrackerUrl', u+'piwik.php']);
       _paq.push(['setSiteId', 4]);
       var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
       g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
       })();
    </script>
    <noscript><img src="http://piwik.biblissima-condorcet.fr/piwik.php?idsite=4" style="border:0" alt="" /></noscript>
  </body>
</html>
