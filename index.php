<?php 
session_start();

//---- function to build tokens
function generateFormToken($form) {
   // generate a token from an unique value
  $token = md5(uniqid(microtime(), true));  
  
  // Write the generated token to the session variable to check it against the hidden field when the form is sent
  $_SESSION[$form.'_token'] = $token;
  return $token;
}
$token = generateFormToken('form_lemme');
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Collatinus-web - Lemmatiseur et analyseur morphologique de textes latins | Boîte à outils Biblissima</title>
  <meta name="description" content="Collatinus-web est la version en ligne de Collatinus, un logiciel libre, gratuit et multi-plateforme pour la lemmatisation et l'analyse morphologique de textes latins.">

  <!-- CSS -->
  <link href="https://static.biblissima.fr/vendor/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://static.biblissima.fr/css/common.css" rel="stylesheet">
  <link href="css/outils.css" rel="stylesheet" media="all">
 
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

  <body class="not-front navbar-is-fixed-top biblissima site-outils collatinus-web fr">
    <!--[if lt IE 7]>
    <p class="chromeframe">Vous utilisez un navigateur <strong>obsolète</strong>. Merci <a href="http://browsehappy.com/">de mettre à jour votre navigateur</a> ou <a href="http://www.google.com/chromeframe/?redirect=true">d'activer Google Chrome Frame</a> afin d'améliorer votre confort de navigation.</p>
  <![endif]-->
  
<!-- HEADER -->
<header id="navbar" role="banner" class="header-no-responsive navbar navbar-fixed-top">
    <nav class="top-bar navbar">
    <div class="container">
        <div class="navbar-header">
            <h1>
				<a href="https://biblissima.fr" class="logo">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCQ0UxQzI3REU1MjkxMUU1QkQ5QUYxNjQxNTFFMTk0RCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCQ0UxQzI3RUU1MjkxMUU1QkQ5QUYxNjQxNTFFMTk0RCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkJDRTFDMjdCRTUyOTExRTVCRDlBRjE2NDE1MUUxOTREIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkJDRTFDMjdDRTUyOTExRTVCRDlBRjE2NDE1MUUxOTREIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+fWSW0AAAABBJREFUeNpi+P//PwNAgAEACPwC/tuiTRYAAAAASUVORK5CYII=" alt="Biblissima">
				</a>
			</h1>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-topbar-collapse" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
			</button>
        </div>
        <div class="collapse navbar-collapse" id="navbar-topbar-collapse">
            <ul>
                <li class="projet"><a href="https://biblissima.fr">Portail</a></li>
                <li class="dropdown outils">
                    <a href="#" data-toggle="dropdown" role="button">Outils</a>
                    <div class="menu-wrapper">
                        <ul class="dropdown-menu container">
                            <li>
                                <a href="https://baobab.biblissima.fr">
                                    <span class="link-wrapper">
										<span class="title">Baobab</span>
                                    	<span class="description">Ressources et outils pour travailler sur les documents anciens (en construction)</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="https://outils.biblissima.fr/fr/collatinus/">
                                    <span class="link-wrapper">
										<span class="title">Collatinus</span>
                                    	<span class="description">Lemmatiseur et analyseur morphologique de textes latins</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="https://outils.biblissima.fr/fr/collatinus-web/">
                                    <span class="link-wrapper">
										<span class="title">Collatinus web</span>
                                    	<span class="description">Version web du lemmatiseur Collatinus</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="https://outils.biblissima.fr/fr/eulexis/">
                                    <span class="link-wrapper">
										<span class="title">Eulexis</span>
                                    	<span class="description">Lemmatiseur de grec ancien</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="https://outils.biblissima.fr/fr/eulexis-web/">
                                    <span class="link-wrapper">
                                        <span class="title">Eulexis-web</span>
                                        <span class="description">Version web du lemmatiseur Eulexis</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="https://outils.biblissima.fr/fr/schemas-tei-reliure/">
                                    <span class="link-wrapper">
                                        <span class="title">Schémas TEI reliure</span>
                                        <span class="description">Schémas de description XML-TEI des reliures et leur documentation</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="https://outils.biblissima.fr/fr/outils-edition-xml/">
                                    <span class="link-wrapper">
                                        <span class="title">Outils d'édition XML</span>
                                        <span class="description">Outils et environnements de travail en XML (EAD et TEI)</span>
                                    </span>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="">
                                    <span class="link-wrapper">
										<span class="title">Editeur XML</span>
                                    	<span class="description">Environnement d'édition XML</span>
                                    </span>
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </li>
                <li class="demos"><a href="http://demos.biblissima.fr">Démos</a></li>
                <li class="doc"><a href="https://doc.biblissima.fr">Doc</a></li>
                <li class="projet"><a href="https://projet.biblissima.fr">Projet</a></li>
                <!-- <li class="dropdown data">
                    <a href="#" data-toggle="dropdown" role="button">Data</a>
                    <div class="menu-wrapper">
                        <ul class="dropdown-menu container">
                            <li>
                                <a href="">
                                    <span class="link-wrapper">
										<span class="title">Baobab</span>
                                    	<span class="description">Ressources et outils pour travailler sur les documents anciens</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="link-wrapper">
										<span class="title">Baobab</span>
                                    	<span class="description">Ressources et outils pour travailler sur les documents anciens</span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> -->
            </ul>
        </div>
    </div>
</nav>

    <!-- bloc logo, slogan -->
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="navbar-header">
                    <!-- logo -->
                    <h1>
                        <a class="logo navbar-btn" href="/fr" title="Accueil">
                            <img src="/images/biblissima-logo-outils.svg" alt="Outils Biblissima">
                        </a>
                    </h1>
                    <button type="button" class="navbar-toggle collapsed header__icon" data-toggle="collapse" data-target="#navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- slogan -->
                    <p class="lead">Boîte à outils Biblissima</p>
                </div>
            </div>
            <!-- #bloc logo, slogan -->
            <!-- bloc outils -->
            <div class="col-sm-8 tool-box">
                <!-- bloc outils - top -->
                <div class="tools-top clearfix" role="complementary">
                    <div class="region-tools-top">
                        <!-- bloc de resaux sociaux -->
                        <div class="bloc-social-links tool-box-bloc clearfix">
                            <ul class="nav">
                                <li><a href="https://facebook.com/biblissima" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://twitter.com/biblissima" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="http://www.slideshare.net/biblissima" title="Slideshare"><i class="fa fa-slideshare"></i></a></li>
                                <li><a href="https://github.com/biblissima" title="Github"><i class="fa fa-github"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UCaHWzwUV0xBAQ-sEdE9EtKg" title="Youtube"><i class="fa fa-youtube-play"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tools-bottom clearfix">
                    <div class="region region-tools-bottom">
                        <div id="block-locale-language" class="block block-locale langue-box contextual-links-region clearfix">
                            <ul class="language-switcher-locale-url">
                            <!-- slug_en / slug_fr is used and should be defined in the template when page slugs are different in each language -->
                            
                                
                                <li class="fr first active"><a href="/fr/collatinus-web/index.php" class="language-link active" lang="fr">fr</a></li>
                                <li class="en last"><a href="/en/collatinus-web/index.php" class="language-link" lang="en">en</a></li>
                            
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MENU -->
<nav class="menu-navigation menu-responsive" role="navigation">
    <div class="navbar-collapse collapse" id="navbar-collapse-1">
        <div class="region region-navigation">
            <div class="menu-biblissima clearfix">
                <ul class="menu nav container">
                        <li>
                            <a href="/fr/" class="" title="Boîte à outils Biblissima">Baobab</a>
                        </li>
                        <li>
                            <a href="/fr/collatinus/" class="" title="Lemmatiseur et analyseur morphologique de textes latins">Collatinus</a>
                        </li>
                        <li>
                            <a href="/fr/collatinus-web/" class="active" title="Version web du lemmatiseur et analyseur morphologique de textes latins">Collatinus-web</a>
                        </li>
                        <li>
                            <a href="/fr/praelector/" class="" title="Assistant de lecture du latin">Praelector</a>
                        </li>
                        <li>
                            <a href="/fr/eulexis/" class="" title="Lemmatiseur de textes grecs">Eulexis</a>
                        </li>
                        <li>
                            <a href="/fr/eulexis-web/" class="" title="Version en ligne du lemmatiseur de textes grecs">Eulexis-web</a>
                        </li>
                        <li>
                            <a href="/fr/schemas-tei-reliure/" class="" title="Les schémas de description XML-TEI des reliures et leur documentation, utilisés pour la constitution de la base des reliures numérisées de la BnF">Schémas TEI reliure</a>
                        </li>
                        <li>
                            <a href="/fr/outils-edition-xml/" class="" title="Outils XML pour travailler sur les documents anciens (édition scientifique de sources historiques en TEI, catalogage de manuscrits et imprimés en EAD, publication électronique)">Outils d'édition XML</a>
                        </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- #MENU -->

</header>
  <section class="top-banner">
	<div class="container">
		<div class="banner-content row sm-flex">
			<div class="col-sm-7 col-md-8">
				<h1>Collatinus-web</h1>
				<h2>Version web du lemmatiseur et analyseur <br />morphologique de textes latins</h2>
			</div>
	    <div class="col-sm-5 col-md-4 text-right">
	    	<div class="buttons-container">
	    		<a href="https://github.com/biblissima/collatinus/tree/Daemon" class="btn btn-lg"><span class="fa fa-github"></span>Collatinus-web sur Github</a>
	    		<a href="/fr/collatinus" class="btn btn-lg" data-toggle="tooltip" data-placement="bottom" data-original-title="Mac, Windows, GNU/Linux">Tester la version bureau</a>
	    	</div>
	    </div>
		</div>
	</div>
</section>
<div class="main-container container" role="main">
	<div class="row">
	    <section class="col-sm-12">
			<div class="region region-content">
				<div class="intro">
					<p class="lead">
						Version web du logiciel multi-plateforme <a href="/fr/collatinus" title="Page de téléchargement de Collatinus">Collatinus</a>, un <strong>lemmatiseur</strong> et <strong>analyseur morphologique</strong> de textes latins.
					</p>
					<p>Elle est basée sur la <strong>version 11.2 de Collatinus</strong>. Son lexique a été élargi grâce au dépouillement systématique des dictionnaires numériques (Gaffiot 2016, Jeanneau 2017, Lewis &amp; Short 1879 et Georges 1913). Le lexique contient aujourd'hui plus de 80&nbsp;000 lemmes.</p>
					<p>Faute de place sur une page web, les options de Collatinus 11 ne sont pas toutes accessibles. Pour un usage ponctuel, cette page web convient. Pour une utilisation plus poussée, nous recommandons l'installation de la <a href="/fr/collatinus" title="Page de téléchargement de Collatinus">version résidente de Collatinus</a> qui est disponible pour Windows, Mac OS et Linux/Debian.</p>
					<p>
						Cette application est mise à disposition sans aucune garantie et reste soumise à corrections et améliorations.
					</p>
				</div>
				<form method="post" role="form" class="form-lemme form-inline">
				    <div class="form-group">
				    	<label for="recherche_lemme" class="main-label">Rechercher un lemme</label>
				        <input type="text" name="lemme" id="recherche_lemme" class="form-control" size="40" placeholder="Entrez un mot latin...">
			        </div>
			        <div class="form-group">
				        <label for="dicos">&nbsp;dans le&nbsp;</label>
				        <select name="dicos" id="dicos">
				            <option value="dga ">Gaffiot</option>
				            <option value="dle ">Lewis &amp; Short</option>
				            <option value="dge ">Georges</option>
				            <option value="dje ">Jeanneau</option>
				            <option value="ddu ">du Cange</option>
				            <option value="dca ">Calonghi (mode image)</option>
				            <option value="dfg ">Gaffiot (mode image)</option>
				            <option value="dra ">De Miguel (mode image)</option>
				            <option value="dva ">Valbuena (mode image)</option>
				        </select>
				        <button type="submit" value="Rechercher" class="btn btn-success" aria-controls="results">Rechercher</button>
				    </div>		
			        <input type="hidden" name="opera" value="consult">
			        <input type="hidden" name="token" value="<?php echo $token ?>">
				</form>
				<form method="post" role="form" class="form-lemme form-inline">
				    <div class="form-group">
				    	<label for="flexion_lemme" class="main-label">Fléchir un lemme</label>
				        <input type="text" name="lemme" id="flexion_lemme" class="form-control" size="40" placeholder="Entrez un mot latin...">
			        </div>
			        <div class="form-group">
				        <button type="submit" value="Fléchir" class="btn btn-success" aria-controls="results">Fléchir</button>
				    	</div>
			        <input type="hidden" name="opera" value="flexion">
			        <input type="hidden" name="token" value="<?php echo $token ?>">
				</form>
				<form method="post" role="form" class="form-lemme">
				    <div class="form-group">
				    	<label for="traitement_texte" class="main-label">Traiter un texte latin</label>
				      <textarea name="texte" id="traitement_texte" class="form-control" rows="6" cols="80" placeholder="Entrez un texte latin..."></textarea>
				    </div>
				    <div class="form-group">
				        <label for="langue">Langue cible&nbsp;</label>
				        <select name="langue" id="langue">
				            <option value="fr ">français</option>
				            <option value="en ">anglais</option>
				            <option value="de ">allemand</option>
				            <option value="it ">italien</option>
				            <option value="ca ">catalan</option>
				            <option value="es ">espagnol</option>
				            <option value="gl ">galicien</option>
				        </select>
			      </div>
		        <div class="form-group">
		        	<button type="submit" name="action" value="Lemmatiser" class="btn btn-success" aria-controls="results"> Lemmatiser</button>
			        <button type="submit" name="action" value="Analyser" class="btn btn-success" aria-controls="results">Analyser</button>
			        <button type="submit" name="action" value="Taguer" class="btn btn-success" aria-controls="results">Taguer</button>
			        <button type="submit" name="action" value="Scander" class="btn btn-success" aria-controls="results">Scander</button>
			        <button type="submit" name="action" value="Accentuer" class="btn btn-success" aria-controls="results">Accentuer</button>
			        <button type="reset" name="action" value="Effacer" class="btn btn-default btn-sm" aria-controls="results"><span class="glyphicon glyphicon-remove-circle"></span> Effacer</button>
				    </div>
			        <input type="hidden" name="opera" value="traite_txt">
			        <input type="hidden" name="token" value="<?php echo $token ?>">
				</form>

				<div id="results" aria-live="polite" aria-label="Réponse de Collatinus à votre requête">
				</div>

		    <div class="well">
		    	<h3>Crédits</h3>
		    	<p>Collatinus web est développé par Yves Ouvrard, avec l'aide de Philippe Verkerk et Régis Robineau.</p>
		    </div>
			</div>
		</section>
	</div>
</div>
<section class="content-bottom">  
	<div class="container">
		<div class="row">
		    <div class="col-sm-9">
		        <p>
		            <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/" class="license"><img alt="Creative Commons License" style="border-width:0" src="https://static.biblissima.fr/images/cc-by-nc-4.0-88x31.png">Creative Commons Attribution-NonCommercial 4.0 International License</a>
				</p>
				<p>
		            <small>Yves Ouvrard et Philippe Verkerk, 2019 – Programme mis à votre disposition sans aucune garantie, mais avec l'espoir qu'il vous sera utile.</small>
		        </p>
		    </div>
		    <div class="col-sm-3">
		        <p>Des remarques ou questions ? :<br/>
		        <span class="glyphicon glyphicon-envelope"></span><a href="mailto:collatinus@biblissima-condorcet.fr">Nous contacter</a></p>
		    </div>
		</div>
	</div>
</section>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-error">
	<div class="modal-dialog modal-sm">
	    <div class="modal-content">
	        <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" class="glyphicon glyphicon-remove-sign"></span><span class="sr-only">Fermer</span></button>
	            <h4>Erreur</h4>
	        </div>
	        <div class="modal-body">
	            <div class="alert alert-warning">
	                Veuillez saisir un texte dans un des champs.
	            </div>
	        </div>
	    </div>
	    <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
    
  <footer class="footer" role="contentinfo">
    <div class="container">
        <div class="region region-footer">
            <div class="block block-menu block-footer-col-2 block-footer clearfix">
                <ul class="menu nav">
                    <li class="first last leaf">
                        <a href="https://projet.biblissima.fr/mentions-legales" target="_blank">Mentions légales</a>
                    </li>
                    <li class="leaf">
                        <a href="https://projet.biblissima.fr/contact" target="_blank">Contact</a>
                    </li>                        
                    <li class="leaf">
                        <a href="https://projet.biblissima.fr/logos" target="_blank">Logos</a>
                    </li>
                </ul>
            </div>
            <div class="block block-menu block-footer-col-2 block-footer clearfix find-us">
                <p><strong> Suivez-nous : </strong></p>
                <ul class="nav">
                    <li><a href="https://facebook.com/biblissima" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com/biblissima" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://www.slideshare.net/biblissima" title="Slideshare"><i class="fa fa-slideshare"></i></a></li>
                    <li><a href="https://github.com/biblissima" title="Github"><i class="fa fa-github"></i></a></li>
                    <li><a href="https://www.youtube.com/channel/UCaHWzwUV0xBAQ-sEdE9EtKg" title="Youtube"><i class="fa fa-youtube-play"></i></a></li>
                </ul>
            </div>
            <div class="block block-block block-footer-col-4 block-footer clearfix">
                <div class="logo-ia">
                    <a href="http://www.agence-nationale-recherche.fr/investissements-d-avenir/" target="_blank"></a>
                    <p> Biblissima b&eacute;n&eacute;ficie d&rsquo;une aide de l&#39;Etat g&eacute;r&eacute;e par l&#39;ANR au titre du programme &laquo; Investissements d&#39;avenir &raquo;, portant la r&eacute;f&eacute;rence ANR-&shy;11-&shy;EQPX-&shy;0007. </p>
                </div>
            </div>
            <div class="block block-block block-footer-col-2 block-footer clearfix">
                <p><strong>Equipex Biblissima</strong>
                    <br /> Campus Condorcet
                    <br /> 20 avenue George Sand
                    <br /> 93210
                    <br /> La Plaine Saint-Denis</p>
            </div>
        </div>
    </div>
</footer>
  
  <button id="scrollToTop" class="scrollToTop fb"> Haut de page </button>
  <div class="site-cache" id="site-cache"></div>
  
  <script type="text/javascript" src="https://static.biblissima.fr/vendor/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="https://static.biblissima.fr/vendor/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://static.biblissima.fr/js/common.js"></script>
  <script type="text/javascript" src="/js/outils.js"></script>

  <script type="text/javascript" src="/js/collatinus-web.js"></script>
  </body>
</html>
