
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
$gestionBD = new GestionBD('magasin_en_ligne', 'webdev', 'toto99');
$panier = new Panier();

/** APPELER LA BONNE FONCTION EN FONCTION DE LA REQUÊTE */

/* REQUÊTES GET */
if(isset($_GET["q"])){
    if($_GET["q"] == "inventaire"){
        if(isset($_GET["noArticle"])){//afficher un seul article
            $noArticle = (int) $_GET["noArticle"];
            echo json_encode($gestionBD->getArticle($noArticle));
        }
        elseif(isset($_GET["categorie"])){//lister par catégorie
            echo json_encode($gestionBD->listerParCategorie($_GET["categorie"]));
        }
        elseif(isset($_GET["mot"])){//lister par mot
            echo json_encode($gestionBD->listerParMot($_GET["mot"]));
        }
        else {//lister tous les articles
            echo json_encode($gestionBD->getListeArticles());
        }
        
    }
    if($_GET["q"] == "panier"){
        if(isset($_GET["r"])){
            if($_GET["r"] == "total"){//compter le nombre d'articles dans le panier
                echo json_encode($panier->getNbArticlesTotal());
            }
            elseif($_GET["r"] == "sommaire"){
                echo json_encode($panier->getSommaire());
            }
            elseif($_GET["r"] == "liste"){
                echo json_encode($panier->getPanier());
            }

        }
    }
}

/* REQUÊTES POST */
elseif(isset($_POST["x"])){
    $obj = json_decode($_POST["x"], false);
    if($obj->requete == "ajouter"){//ajouter au panier
        $noArticle = $obj->noArticle;
        $description = $obj->description;
        $cheminImage = $obj->cheminImage;
        $quantite = $obj->quantite;
        $prixUnitaire = $obj->prixUnitaire;
        $panier->ajouterArticle($description, $cheminImage, $quantite, $prixUnitaire);
        // réserver l'article dans l'inventaire
        $gestionBD->reserverArticle($noArticle, $quantite);
    }
}


?>


