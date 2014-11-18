<?php
session_start();

/****************************************************************
 **                 fonctions                                  **
 ****************************************************************/

//---- Transmet la requete au demon sur le serveur
function interroge($requete) {
  $sk = fsockopen("localhost", 5555, $errnum, $errstr, 30);
  if (!$sk) {
    return "erreur $errnum $errstr";
  }
  fwrite($sk, $requete);
  $dati = "";
  while (!feof($sk)) {
    $dati .= fgets($sk, 1024);
  }
  fclose($sk);
  return $dati;
}
 
//---- Verifie les valeurs des tokens
function verifyFormToken($form) {
    
  // check if a session is started and a token is transmitted, if not return an error
  if(!isset($_SESSION[$form.'_token'])) {
    return false;
  }
  
  // check if the form is sent with token in it
  if(!isset($_POST['token'])) {
    return false;
  }
  
  // compare the tokens against each other if they are still the same
  if ($_SESSION[$form.'_token'] !== $_POST['token']) {
    return false;
  }

  return true;
}

/**********************************************************
 **                       Initialisation                 **
 * 
 * Prefixes des operations du demon :
 * - d = dictionnaires (dva, dge, dle, dga, dca, ddu)
 * - l = lemmatisation
 * - a = analyse
 * - m = scansion
 * - f = flexion
 * 
 * Voir main.cpp -> Serveur::exec
 * 
 **********************************************************/

if (isset($_POST['opera'])) {
  $opera = $_POST['opera'];
  switch ($opera) {
    case 'consult' :
      /*$_SESSION['dicos'] = strip_tags($_POST['dicos']);
      $_SESSION['lemme'] = strip_tags($_POST['lemme']);
      $requete = $_SESSION['dicos'] . $_SESSION['lemme'];*/
      $dicos = strip_tags($_POST['dicos']);
      $lemme = strip_tags($_POST['lemme']);
      $requete = $dicos . $lemme;
      break;
    case 'flexion' :
      /*$_SESSION['lemme'] = strip_tags($_POST['lemme']);
      $requete = "f:" . $_SESSION['lemme'];*/
      $lemme = strip_tags($_POST['lemme']);
      $requete = "f:" . $lemme;
      break;
    case 'traite_txt' :
      /*$_SESSION['langue'] = $_POST['langue'];
      $_SESSION['texte'] = strip_tags($_POST['texte']);*/
      $langue = $_POST['langue'];
      $texte = strip_tags($_POST['texte']);
      switch($_POST['action']) {
        case 'Lemmatiser' :
          //$requete = "l" . $_SESSION['langue'] . $_SESSION['texte'];
          $requete = "l" . $langue . $texte;
          break;
        case 'Analyser' :
          //$requete = "a" . $_SESSION['langue'] . $_SESSION['texte'];
          $requete = "a" . $langue . $texte;
          break;
        case 'Scander' :
          $requete = "m:" . $texte;
          break;
      }
      break;
  }
} elseif (isset($_POST["r"])) {
  $requete = $_POST["r"];
} else {
  // La première fois
  /*$_SESSION['texte'] = "Arma uirumque cano, Troiae qui primus ab oris Italiam, fato profugus, Lauiniaque uenit litora, multum ille et terris iactatus et alto ui superum saeuae memorem Iunonis ob iram";
  $requete = '';
  $_SESSION['lemme'] = '';
  $_SESSION['dicos'] = 'dga:';
  $_SESSION['langue'] = 'fr:';
  
  $lemme = $_SESSION['lemme'];
  $dico = $_SESSION['dicos'];
  $langue = $_SESSION['langue'];
  $texte = $_SESSION['texte'];*/
  $lemme = "";
  $dico = "dga:";
  $langue = "fr:";
  $texte = "";
}


/*********************************************
 **               Traitement                 **
 *********************************************/

if ($requete != '') {
    
  // Controle du token
  if (verifyFormToken('form_lemme')) {
    $requete = trim($requete);
    $sol = interroge($requete);
  
  // sauf pour les requetes de type "page prec/suiv"
  } elseif (isset($_POST["r"])) {
    $sol = interroge($requete);
    
  } else {
    echo "<p class='text-danger'>Une erreur s'est produite.</p> <button type='button' class='btn btn-default' onclick='javascript:window.location.reload()'><span class='glyphicon glyphicon-refresh'></span> Recharger la page</button>";
  }

  // Si Lemmatiser
  if ($requete[0] == 'l') {
    
    // retours a la ligne de $requete
    $r = trim($texte); // reprise du texte

    $lignesr = preg_split("/\n+\s*/", $r); // découpage en lignes
    
    $clr = count($lignesr) - 1; // nombre de lignes
    $ilr = 0; // numéro de la ligne courante
    $motsr = preg_split("/\s+/", $lignesr[$ilr]); // découpage en mots de la ligne courante
    $cmr = count($motsr) - 1; // nombre de mots de la ligne courante
    
    // affichage des bulles
    $items = explode("//", $sol); // éclater en items la réponse du démon
    $imr = 0; // numéro du mot
    
    // lister les mots avec infobulles
    echo "<p>";
    foreach ($items as $item) {
      
      if (trim($item) == "")
        continue;
      $eclats = explode("%", $item); // éclater chaque item pour séparer le lemme de son analyse
      
      unset ($eclats[0]); // on supprime le lemme du tableau pour ne garder que l'analyse
      
      // Infobulles avec injection de html dans le title (affichage géré par Bootsrap tooltip.js)
      echo "<span class=\"info-lemme\" data-toggle=\"tooltip\" title=\"";
      echo "<ul>";
      foreach ($eclats as $e)
      {
          $traits = explode ("|", $e); // séparer la définition et la déclinaison
          echo "<li>";
          echo trim(implode ("<br />", $traits));
          echo "</li>";
      }
      echo "</ul>";
      echo "\">". $motsr[$imr] ."</span> ";

      $imr++;
      
      if ($imr > $cmr && $ilr < $clr) {
        echo "<br/>\n";
        $ilr++;
        $motsr = preg_split("/\s+/", $lignesr[$ilr]);
        $cmr = count($motsr) - 1;
        $imr = 0;
      }
      echo "";
    }
    echo "</p>";

    // affichage des lemmes
    //echo "<ul>\n";
    foreach ($items as $item) {
      $eclats = explode("%", $item);
      $i = 0;
      
      echo "<p><strong>" . $eclats[0] . "</strong><ul>\n"; // Sauf erreur, c'est la forme qui a été analysée
      foreach ($eclats as $e) {
        if ($i > 0) {
          $traits = explode("|", $e);
          echo "<li>" . $traits[0] . "</li>"; // que le lemme, pas l'analyse morpho.
        }
        $i++;
      }
      echo "</ul></p>\n";  // Fin de l'analyse du mot
    }
    //echo "</ul>\n";
  } else {
    echo $sol;
  }
}
