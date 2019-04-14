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
$gestionArticles = new GestionArticles();
$gestionClients = new GestionClients();
$gestionCommandes = new GestionCommandes();
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
            }
        }
    }
}

/* REQUÊTES POST */
elseif(isset($_POST["x"])){
    $obj = json_decode($_POST["x"], false);
    switch($obj->requete) {
        case "ajouter" :
            $noArticle = (int) $obj->noArticle;
            $description = $obj->description;
            $cheminImage = $obj->cheminImage;
            $quantite = (int) $obj->quantite;
            $prixUnitaire = $obj->prixUnitaire;
            $panier->ajouterArticle($noArticle, $description, $cheminImage, $quantite, $prixUnitaire);
            $gestionArticles->reserverArticle($noArticle, $quantite);
            break;
        case "supprimer" :
            $noArticle = (int) $obj->noArticle;
            $panier->supprimerArticle($noArticle);
            $gestionArticles->supprimerDuPanier($noArticle);
            break;
        case "modifier" :
            $tabNoArticle = json_decode($obj->tabNoArticle);
            $tabQuantite = json_decode($obj->tabQuantite);
            $panier->modifierQteArticles($tabNoArticle, $tabQuantite);
            $gestionArticles->modifierPanier($tabNoArticle, $tabQuantite);
            break;
        case "rabais" :
            $panier->appliquerRabais();
            break;
        case "inscription" :
            $donneesClient = json_decode($obj->client, true);
            $client = new Client($donneesClient);
            $gestionClients->ajouterClient($client);
            echo json_encode($gestionClients->getDernierClient());
            break;
        case "connexion" :
            $pseudo = $obj->pseudo;
            $motDePasse = $obj->motDePasse;
            echo json_encode($gestionClients->getMembre($pseudo, $motDePasse));
            break;
        case "commande" :
            //Récupérer les données
            $paypalOrderId = $obj->paypalOrderId;
            $tabNoArticle = json_decode($obj->tabNoArticle);
            $tabQuantite = json_decode($obj->tabQuantite);
            $noClient = $obj->noClient;
            
            //Ajouter la commande
            $gestionCommandes->ajouterCommande($noClient, $paypalOrderId, $tabNoArticle, $tabQuantite);

            //Détruire le panier d'achat
            $gestionArticles->effacerQtePanierTous();
            $panier->verrouillerPanier();
            $panier->supprimerPanier();
            
            break;
    }
   
}

?>