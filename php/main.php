
<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

// Seulement charger la classe qu'on a besoin
function chargerClasse($classe) {
    require $classe.'.php';
}
spl_autoload_register('chargerClasse');

$gestionBD = new GestionBD('magasin_en_ligne', 'webdev', 'toto99');
$panier = new Panier();

?>


