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
  $avant = array('æ','Æ','œ','Œ','̀','́','à','á','è','é','ì','í','ò','ó','ù','ú','À','Á','È','É','Ì','Í','Ò','Ó','Ù','Ú');
  $apres = array('ae','Ae','oe','Oe','','','a','a','e','e','i','i','o','o','u','u','A','A','E','E','I','I','O','O','U','U');
  $requete = str_replace($avant, $apres, $requete);
  $avant = array('̄','̆','ā','ă','ē','ĕ','ī','ĭ','ō','ŏ','ū','ŭ','Ā','Ă','Ē','Ĕ','Ī','Ĭ','Ō','Ŏ','Ū','Ŭ');
  $apres = array('','','a','a','e','e','i','i','o','o','u','u','A','A','E','E','I','I','O','O','U','U');
  $requete = str_replace($avant, $apres, $requete);
  // Remplacement de caractères exotiques par leur équivalent ASCII
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
      $dicos = strip_tags($_POST['dicos']);
      $lemme = strip_tags($_POST['lemme']);
      $requete = $dicos . $lemme;
      break;
    case 'flexion' :
      $lemme = strip_tags($_POST['lemme']);
      $requete = "f:" . $lemme;
      break;
    case 'traite_txt' :
      $langue = $_POST['langue'];
      $texte = strip_tags($_POST['texte']);
      switch($_POST['action']) {
        case 'Lemmatiser' :
          $requete = "l" . $langue . $texte;
          break;
        case 'Analyser' :
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
    $motsr = str_word_count($lignesr[$ilr], 1); // découpage en mots de la ligne courante
    // Essai de patch pour régler le problème des ponctuations isolées, Philippe Nov. 2015
    $iii = count($motsr) - 1;
    while ($iii > 0) {
      if (strspn($motsr[$iii],"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ") == 0) {
        $motsr[$iii-1]+=" "+$motsr[$iii];
        array_splice($motsr, $iii, 1);
      }
      $iii--;
    }
    if (strspn($motsr[0],"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ") == 0) {
      $motsr[1]=$motsr[0]+" "+$motsr[1];
      array_splice($motsr, 0, 1);
    }
    // fin du patch
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
  } else {
    echo $sol;
  }
}
