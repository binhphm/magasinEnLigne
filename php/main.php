
<?php
// Débuter la session
session_start();
header("Content-Type: application/json; charset=UTF-8");

// Seulement charger la classe qu'on a besoin
function chargerClasse($classe) {
    require $classe.'.php';
}
spl_autoload_register('chargerClasse');

/* Instanciation du gestionnaire de la BD et du panier */
$gestionBD = new GestionBD('magasin_en_ligne', 'webdev', 'toto99');
$panier = new Panier();

$reponse = json_encode($gestionBD->getListeArticles());
echo $reponse;

?>


