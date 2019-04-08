<?php

/**
 * Représente un objet de type Panier
 * Son rôle est de gérer un panier d'achats
 */
class Panier {

    const TPS = 0.05;
    const TVQ = 0.095;
    const FRAIS_LIVRAISON = 10;

    /**
     * CONSTRUCTEUR : crée un objet de type Panier
     * Créé un tableau associatif avec des variables de session
     */
    public function __construct() {
        $this->creerPanier();
    }

    /**
     * Verifie si le panier existe, le créé sinon
     * @return boolean
     */
    public function creerPanier(){
        if (!isset($_SESSION['panier'])){
            $_SESSION['panier']=array();
            $_SESSION['panier']['description'] = array();
            $_SESSION['panier']['cheminImage'] = array();
            $_SESSION['panier']['quantiteDansPanier'] = array();
            $_SESSION['panier']['prixUnitaire'] = array();
            $_SESSION['panier']['estVerouille'] = false;
        }
        return true;
    }

    /**
     * Retourne le panier (réarrange les variables de session)
     * @return array - un tableau associatif pour chaque élément du panier
     */
    public function getPanier() {
        $listePanier = array();
        if ($this->creerPanier()) {       
            for($i = 0; $i < count($_SESSION['panier']['description']); $i++){
                // Convertir le nombre décimal en format monétaire
                $prixTotal = $_SESSION['panier']['quantiteDansPanier'][$i] * $_SESSION['panier']['prixUnitaire'][$i];
                $prixTotal = number_format($prixTotal, 2, ',', ' ') . ' $';
                $ligne = array(
                    "description" => $_SESSION['panier']['description'][$i],
                    "cheminImage" => $_SESSION['panier']['cheminImage'][$i],
                    "quantiteDansPanier" => $_SESSION['panier']['quantiteDansPanier'][$i],
                    "prixUnitaire" => number_format($_SESSION['panier']['prixUnitaire'][$i], 2, ',', '') . ' $',
                    "prixTotal" => $prixTotal
                );
                array_push($listePanier, $ligne);
            }
            
        }
        return $listePanier;
    }

    /**
     * Retourne le montant total
     * @return double
     */
    public function getMontantTotal(){
        $somme = 0;

        for($i = 0; $i < count($_SESSION['panier']['description']); $i++) {
           $somme += $_SESSION['panier']['quantiteDansPanier'][$i] * $_SESSION['panier']['prixUnitaire'][$i];
        }
        return $somme;
    }

    /**
     * Retourne le sommaire du panier
     * @return array - un tableau associatif
     */
    public function getSommaire(){
        $tabSommaire = array();
        $sousTotal = $this->getMontantTotal();
        $tps = self::TPS * $sousTotal;
        $tvq = self::TVQ * $sousTotal;
        $fraisLivraison = self::FRAIS_LIVRAISON;
        $rabais = 0;
        $total = $sousTotal + $tps + $tvq + $fraisLivraison - $rabais;
        $sommaire = array(
            "sousTotal" => number_format($sousTotal, 2, ',', '') . ' $',
            "tps" => number_format($tps, 2, ',', '') . ' $',
            "tvq" => number_format($tvq, 2, ',', '') . ' $',
            "fraisLivraison" => number_format($fraisLivraison, 2, ',', '') . ' $',
            "rabais" => '-' . number_format($rabais, 2, ',', '') . ' $',
            "total" => number_format($total, 2, ',', '') . ' $',
        );
        array_push($tabSommaire, $sommaire);
        return $tabSommaire;
    }

     /**
     * Retourne le nombre total d'articles
     * @return int
     */
    public function getNbArticlesTotal() {
        $compteur = 0;
        if ($this->creerPanier()){
            for($i = 0; $i < count($_SESSION['panier']['description']); $i++){
                $compteur += $_SESSION['panier']['quantiteDansPanier'][$i];
            }
        }
        return $compteur;
    }

     /**
     * Ajoute un article dans le tableau de session
     * @param {string} $description - la description de l'article
     * @param {int} $quantiteDansPanier - la quantité par article
     * @param {double} $prixUnitaire - le prix à l'unité
     */
    public function ajouterArticle($description, $cheminImage, $quantite, $prixUnitaire){
        if ($this->creerPanier() && !$this->estVerrouille()) {
     
            //Si le produit existe déjà on ajoute seulement la quantité
            $indexArticle = array_search($description, $_SESSION['panier']['description']);

            //Convertir le prix en numéro décimal
            $prixUnitaire = substr($prixUnitaire, 0, -2);
            $prixUnitaire = preg_replace('/,/', '.', $prixUnitaire);
            $prixUnitaire = number_format($prixUnitaire, 2);
    
            if ($indexArticle !== false) {
                $_SESSION['panier']['quantiteDansPanier'][$indexArticle] += $quantite ;
            }
            else {
                array_push( $_SESSION['panier']['description'],$description);
                array_push( $_SESSION['panier']['cheminImage'],$cheminImage);
                array_push( $_SESSION['panier']['quantiteDansPanier'],$quantite);
                array_push( $_SESSION['panier']['prixUnitaire'],$prixUnitaire);
            }
        }
        else {
            echo "Un problème est survenu, contactez l'administrateur du site.";
        }   
    }







   

    
   

   

    /**
     * Modifie un article dans le tableau de session
     * @param {string} $description - la description de l'article
     * @param {int} $quantiteDansPanier - la quantité par article
     */
    public function modifierQteArticle($description, $quantiteDansPanier){
        //Si le panier éxiste
        if ($this->creerPanier() && !$this->estVerrouille()) {
            if ($quantiteDansPanier > 0) {
                //Recharche du produit dans le panier
                $indexArticle = array_search($description, $_SESSION['panier']['description']);
                if ($indexArticle !== false) {
                    $_SESSION['panier']['quantiteDansPanier'][$indexArticle] = $quantiteDansPanier ;
                }
            }
            else
                supprimerArticle($description);
        }
        else
            echo "Un problème est survenu, contactez l'administrateur du site.";
    }
    
    /**
     * Supprime un article dans le tableau de session
     * @param {string} $description - la description de l'article
     */
    public function supprimerArticle($description) {
        if ($this->creerPanier() && !$this->estVerrouille()) {
            $tmp=array();
            $tmp['description'] = array();
            $tmp['cheminImage'] = array();
            $tmp['quantiteDansPanier'] = array();
            $tmp['prixUnitaire'] = array();
            $tmp['verrou'] = $_SESSION['panier']['verrou'];
     
            for($i = 0; $i < count($_SESSION['panier']['description']); $i++) {
                if ($_SESSION['panier']['description'][$i] !==$description) {
                    array_push($tmp['description'],$_SESSION['panier']['description'][$i]);
                    array_push($tmp['cheminImage'],$_SESSION['panier']['cheminImage'][$i]);
                    array_push( $tmp['quantiteDansPanier'],$_SESSION['panier']['quantiteDansPanier'][$i]);
                    array_push( $tmp['prixUnitaire'],$_SESSION['panier']['prixUnitaire'][$i]);
                }
     
            }
            $_SESSION['panier'] = $tmp;
            unset($tmp);
        }
        else
            echo "Un problème est survenu, contactez l'administrateur du site.";
    }
    
   
    

    /**
     * Retourne le montant total par article
     * @param {string} $description - la description de l'article
     * @return double
     */
    public function getMontantArticle($description) {
        $resultat = 0.00;
        if($this->creerPanier()) {
            $indexArticle = array_search($description, $_SESSION['panier']['description']);
            $resultat = $_SESSION['panier']['quantiteDansPanier'][$indexArticle] * 
                        $_SESSION['panier']['prixUnitaire'][$indexArticle];
            return number_format($resultat,2,".",",");
        }
        return $resultat;
    }

    

    /**
     * Retourne le nombre d'un article choisi
     * @param $description - la description de l'article
     * @return int
     */
    public function getNbArticles($description){
        if ($this->creerPanier()){
            $indexArticle = array_search($description, $_SESSION['panier']['description']);
            return $_SESSION['panier']['quantiteDansPanier'][$indexArticle] = $quantiteDansPanier ;
        } 
        else
            return 0;
    }

    /**
     * Vérifie si le panier est vérouillé ou pas
     * @return boolean
     */
    public function estVerrouille(){
        return ($this->creerPanier() && $_SESSION['panier']['estVerouille'] == true);
    }

    /**
     * Verouille le panier
     */
    public function verrouillerPanier() {
        if ($this->creerPanier()) {
            $_SESSION['panier']['estVerrouille'] == true;
        }
    }

    /**
     * Supprime le panier
     */
    public function supprimerPanier() {
        if($this->creerPanier()){
            unset($_SESSION['panier']);
        }
       
    }

    
       
}



?>