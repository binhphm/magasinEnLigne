<?php

/**
 * Représente un objet de type Panier
 * Son rôle est de gérer un panier d'achats
 */
class Panier {

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
            $_SESSION['panier']['descArticle'] = array();
            $_SESSION['panier']['qteArticle'] = array();
            $_SESSION['panier']['prixArticle'] = array();
            $_SESSION['panier']['estVerouille'] = false;
        }
        return true;
    }

    /**
     * Retourne le panier
     * @return array
     */
    public function getPanier() {
        if ($this->creerPanier()) {
            return $_SESSION['panier'];
        }
    }

    /**
     * Retourne les descriptions
     * @return array
     */
    public function getTabDescriptions() {
        if($this->creerPanier()) {
            return $_SESSION['panier']['descArticle'];
        }
    }

    /**
     * Retourne les quantités
     * @return array
     */
    public function getTabQuantites() {
        if($this->creerPanier()) {
            return $_SESSION['panier']['qteArticle'];
        }
    }

    /**
     * Retourne les prix
     * @return array
     */
    public function getTabPrix(){
        if($this->creerPanier()) {
            return $_SESSION['panier']['prixArticle'];
        }
    }

    /**
     * Ajoute un article dans le tableau de session
     * @param {string} $descArticle - la description de l'article
     * @param {int} $qteArticle - la quantité par article
     * @param {double} $prixArticle - le prix à l'unité
     */
    public function ajouterArticle($descArticle, $qteArticle, $prixArticle){
        if ($this->creerPanier() && !$this->estVerrouille()) {
     
            //Si le produit existe déjà on ajoute seulement la quantité
            $indexArticle = array_search($descArticle, $_SESSION['panier']['descArticle']);
    
            if ($indexArticle !== false) {
                $_SESSION['panier']['qteArticle'][$indexArticle] += $qteArticle ;
            }
            else {
                array_push( $_SESSION['panier']['descArticle'],$descArticle);
                array_push( $_SESSION['panier']['qteArticle'],$qteArticle);
                array_push( $_SESSION['panier']['prixArticle'],$prixArticle);
            }
        }
        else {
            echo "Un problème est survenu, contactez l'administrateur du site.";
        }   
    }

    /**
     * Modifie un article dans le tableau de session
     * @param {string} $descArticle - la description de l'article
     * @param {int} $qteArticle - la quantité par article
     */
    public function modifierQteArticle($descArticle, $qteArticle){
        //Si le panier éxiste
        if ($this->creerPanier() && !$this->estVerrouille()) {
            if ($qteArticle > 0) {
                //Recharche du produit dans le panier
                $indexArticle = array_search($descArticle, $_SESSION['panier']['descArticle']);
                if ($indexArticle !== false) {
                    $_SESSION['panier']['qteArticle'][$indexArticle] = $qteArticle ;
                }
            }
            else
                supprimerArticle($descArticle);
        }
        else
            echo "Un problème est survenu, contactez l'administrateur du site.";
    }
    
    /**
     * Supprime un article dans le tableau de session
     * @param {string} $descArticle - la description de l'article
     */
    public function supprimerArticle($descArticle) {
        if ($this->creerPanier() && !$this->estVerrouille()) {
            $tmp=array();
            $tmp['descArticle'] = array();
            $tmp['qteArticle'] = array();
            $tmp['prixArticle'] = array();
            $tmp['verrou'] = $_SESSION['panier']['verrou'];
     
            for($i = 0; $i < count($_SESSION['panier']['descArticle']); $i++) {
                if ($_SESSION['panier']['descArticle'][$i] !==$descArticle) {
                    array_push($tmp['descArticle'],$_SESSION['panier']['descArticle'][$i]);
                    array_push( $tmp['qteArticle'],$_SESSION['panier']['qteArticle'][$i]);
                    array_push( $tmp['prixArticle'],$_SESSION['panier']['prixArticle'][$i]);
                }
     
            }
            $_SESSION['panier'] = $tmp;
            unset($tmp);
        }
        else
            echo "Un problème est survenu, contactez l'administrateur du site.";
    }
    
   
    /**
     * Retourne le montant total
     * @return double
     */
    public function getMontantTotal(){
        $somme = 0;

        for($i = 0; $i < count($_SESSION['panier']['descArticle']); $i++) {
           $somme += $_SESSION['panier']['qteArticle'][$i] * $_SESSION['panier']['prixArticle'][$i];
        }
        return $somme;
    }

    /**
     * Retourne le montant total par article
     * @param {string} $descArticle - la description de l'article
     * @return double
     */
    public function getMontantArticle($descArticle) {
        $resultat = 0.00;
        if($this->creerPanier()) {
            $indexArticle = array_search($descArticle, $_SESSION['panier']['descArticle']);
            $resultat = $_SESSION['panier']['qteArticle'][$indexArticle] * 
                        $_SESSION['panier']['prixArticle'][$indexArticle];
            return number_format($resultat,2,".",",");
        }
        return $resultat;
    }

     /**
     * Retourne le nombre total d'articles
     * @return int
     */
    public function getNbArticlesTotal() {
        if ($this->creerPanier())
            return count($_SESSION['panier']['descArticle']);
        else
            return 0;

    }

    /**
     * Retourne le nombre d'un article choisi
     * @param $descArticle - la description de l'article
     * @return int
     */
    public function getNbArticles($descArticle){
        if ($this->creerPanier()){
            $indexArticle = array_search($descArticle, $_SESSION['panier']['descArticle']);
            return $_SESSION['panier']['qteArticle'][$indexArticle] = $qteArticle ;
        } 
        else
            return 0;
    }

    /**
     * Vérifie si le panier est vérouillé ou pas
     * @return boolean
     */
    public function estVerrouille(){
        if ($this->creerPanier() && $_SESSION['panier']['estVerrouille'])
            return true;
        else
            return false;
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