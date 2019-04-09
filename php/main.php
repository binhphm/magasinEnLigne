
<?php
header("Content-Type: application/json; charset=UTF-8");
// Débuter la session
session_start();

// Seulement charger la classe qu'on a besoin
function chargerClasse($classe) {
    require $classe.'.php';
}
spl_autoload_register('chargerClasse');


/* Instanciation du gestionnaire de la BD et du panier */
$gestionArticles = new GestionArticles('magasin_en_ligne', 'webdev', 'toto99');
$panier = new Panier();

/** APPELER LA BONNE FONCTION EN FONCTION DE LA REQUÊTE */

/* REQUÊTES GET */
if(isset($_GET["q"])){
    if($_GET["q"] == "inventaire"){
        if(isset($_GET["noArticle"])){//afficher un seul article
            $noArticle = (int) $_GET["noArticle"];
            echo json_encode($gestionArticles->getArticle($noArticle));
        }
        elseif(isset($_GET["categorie"])){//lister par catégorie
            echo json_encode($gestionArticles->listerParCategorie($_GET["categorie"]));
        }
        elseif(isset($_GET["mot"])){//lister par mot
            echo json_encode($gestionArticles->listerParMot($_GET["mot"]));
        }
        else {//lister tous les articles
            echo json_encode($gestionArticles->getListeArticles());
        }
        
    }
    if($_GET["q"] == "panier"){
        if(isset($_GET["r"])){
            switch($_GET["r"]) {
                case "total": //compter le nombre d'articles dans le panier
                    echo json_encode($panier->getNbArticlesTotal());
                    break;
                case "sommaire": //afficher le sommaire du panier
                    echo json_encode($panier->getSommaire());
                    break;
                case "liste": //afficher chaque article du panier
                    echo json_encode($panier->getPanier());
                    break;
                case "supprimer"://TEMPORAIRE : supprimer du panier
                    $panier->supprimerPanier();
                    $gestionArticles->detruirePanier();
                    break;
            }
        }
    }
}

/* REQUÊTES POST */
elseif(isset($_POST["x"])){
    $obj = json_decode($_POST["x"], false);
    switch($obj->requete) {
        case "ajouter" :
            $noArticle = $obj->noArticle;
            $description = $obj->description;
            $cheminImage = $obj->cheminImage;
            $quantite = $obj->quantite;
            $prixUnitaire = $obj->prixUnitaire;
            $panier->ajouterArticle($noArticle, $description, $cheminImage, $quantite, $prixUnitaire);
            $gestionArticles->reserverArticle($noArticle, $quantite);
            break;
        case "supprimer" :
            $noArticle = $obj->noArticle;
            $description = $obj->description;
            $panier->supprimerArticle($description);
            $gestionArticles->supprimerDuPanier($noArticle);
            break;
    }
   
}

?>


