
<?php
// Débuter la session
session_start();

// Seulement charger la classe qu'on a besoin
function chargerClasse($classe) {
    require $classe.'.php';
}
spl_autoload_register('chargerClasse');


/* Instanciation du gestionnaire de la BD et du panier */
$gestionBD = new GestionBD('magasin_en_ligne', 'webdev', 'toto99');
$panier = new Panier();


/** APPELER LA BONNE FONCTION EN FONCTION DE LA REQUÊTE */
if(isset($_GET["q"])){
    if($_GET["q"] == "afficher"){
        if(isset($_GET["noArticle"])){
            $noArticle = (int) $_GET["noArticle"];
            echo json_encode($gestionBD->getArticle($noArticle));
        }
        elseif(isset($_GET["categorie"])){
            echo json_encode($gestionBD->listerParCategorie($_GET["categorie"]));
        }
        elseif(isset($_GET["mot"])){
            echo json_encode($gestionBD->listerParMot($_GET["mot"]));
        }
        else {
            echo json_encode($gestionBD->getListeArticles());
        }
        
    }
    if($_GET["q"] == "panier"){
        if(isset($_GET["r"])){
            if($_GET["r"] == "total"){
                $total = $panier->getNbArticlesTotal();
                echo json_encode($total);
            }

        }
    }
}


?>


