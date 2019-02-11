# Collatinus-web

Ce dépôt contient les fichiers de l'interface web de Collatinus-web (partie cliente et "front-end").

Collatinus-web est la version en ligne de [Collatinus](https://github.com/biblissima/collatinus), un logiciel de lemmatisation et d'analyse morphologique de textes latins. Il permet de :
- rechercher un lemme dans plusieurs dictionnaires de latin (Gaffiot, Calonghi, Lewis & Short, du Cange, Georges, Valbuena, De Miguel)
- fléchir un lemme
- lemmatiser, taguer, scander et accentuer un texte latin (7 langues cibles)
- effectuer son analyse morphologique

Cette version de Collatinus-web est basée sur la version **11.2** de Collatinus. Son lexique a été élargi grâce au dépouillement systématique des dictionnaires numériques (Gaffiot 2016, Jeanneau 2017, Lewis & Short 1879 et Georges 1913). Le lexique contient aujourd'hui plus de 80 000 lemmes.

**Tester Collatinus-web** sur le site de Biblissima : [https://outils.biblissima.fr/fr/collatinus-web](https://outils.biblissima.fr/fr/collatinus-web)

## Instructions

La partie web de Collatinus-web interagit avec un serveur prenant la forme d'un démon écrit en C++. Son code est disponible dans la branche `Daemon` de Collatinus : https://github.com/biblissima/collatinus/tree/Daemon

La partie serveur communique avec le client à travers un socket de connexion (port 5555). Côté client, le script `ajax/collatinus-web/collatinus-web.php` se charge de transmettre les requêtes au démon via `fsockopen()` et de récupèrer les réponses pour l'affichage des données dans la page web.

Pour faire tourner votre propre instance de Collatinus-web, il vous faudra :
- compiler tout d'abord le démon serveur (branche `Daemon` de Collatinus, disponible [ici](https://github.com/biblissima/collatinus/tree/Daemon))
- servir les fichiers de ce dépôt via un serveur Web classique (Apache, Nginx etc.). Les éléments suivants devront être adaptés le cas échéant:
  - les chemins vers les fichiers js et css dans `index.php`
  - le chemin vers le script php dans `js/collatinus-web.js` (requêtes Ajax POST l.65 et l.133)

## Crédits

Collatinus-web est développé par Yves Ouvrard et Philippe Verkerk avec l'aide de Régis Robineau dans le cadre de la "Boîte à Outils" de l'Equipex [Biblissima](https://projet.biblissima.fr).

## Licence

Ce programme est mis à disposition par Yves Ouvrard et Philippe Verkerk sous licence [Creative Commons Attribution-NonCommercial 4.0 International License](http://creativecommons.org/licenses/by-nc/4.0/) (CC BY-NC).
