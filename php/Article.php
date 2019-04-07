<?php

/**
 * Représente un objet de type Article
 */
class Article {

    /* ATTRIBUTS */
    private $noArticle;
    private $description;
    private $cheminImage;
    private $prixUnitaire;
    private $quantiteEnStock;
    private $quantiteDansPanier;

    /* CONSTANTES (regex) */
   const CHEMIN_IMAGE = '/^images\/(.*)\.(jpg|jpeg|png|gif)$/';

    /**
     * CONSTRUCTEUR : crée un objet de type Article
     * @param {array} $donnees - tableau associatif contenant les attributs et leurs valeurs
     */
    public function __construct(array $donnees){
        $this->hydrate($donnees);
    }


    /* ACCESSEURS */

    public function getNoArticle() {
        return $this->noArticle;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCheminImage() {
        return $this->cheminImage;
    }

    public function getPrixUnitaire() {
        return $this->prixUnitaire;
    }

    public function getQuantiteEnStock() {
        return $this->quantiteEnStock;
    }

    public function getQuantiteDansPanier() {
        return $this->quantiteDansPanier;
    }

    /* MUTATEURS */

    public function setNoArticle($noArticle) {
        $noArticle = (int) $noArticle;
        if(!is_int($noArticle)){
            error_log('Le numéro d\'article doit être un nombre entier.' . PHP_EOL, 3, 'erreurs.txt');
            return;
        }
        $this->noArticle = $noArticle;
    }

    public function setDescription($description) {
        if(!is_string($description)){
            error_log('La description d\'un article doit être une chaîne de caractères.' . PHP_EOL, 3, 'erreurs.txt');
            return;
        }
        $this->description = $description;
    }

    public function setCheminImage($cheminImage) {
        if(!preg_match(self::CHEMIN_IMAGE, $cheminImage)){
            error_log('Le chemin de l\'image d\'un article doit être une chaîne de caractères.' . PHP_EOL, 3, 'erreurs.txt');
            return;
        }
        $this->cheminImage = $cheminImage;
    }

    public function setPrixUnitaire($prixUnitaire) {
        $prixUnitaire = (double) $prixUnitaire;
        
        if(!is_double($prixUnitaire)){
            error_log('Le prix unitaire d\'un article doit être un nombre décimal.' . PHP_EOL, 3, 'erreurs.txt');
            return;
        }
        
        $this->prixUnitaire = $prixUnitaire;
    }

    public function setQuantiteEnStock($quantiteEnStock) {
        $quantiteEnStock = (int) $quantiteEnStock;

        if(!is_int($quantiteEnStock)){
            error_log('La quantité en stock d\'un article doit être un nombre entier.' . PHP_EOL , 3, 'erreurs.txt');
            return;
        }
        $this->quantiteEnStock = $quantiteEnStock;
    }

    public function setQuantiteDansPanier($quantiteDansPanier) {
        $quantiteDansPanier = (int) $quantiteDansPanier;
        
        if(!is_int($quantiteDansPanier)){
            error_log('La quantité dans le panier doit être un nombre entier.' . PHP_EOL , 3, 'erreurs.txt');
            return;
        }
        
        $this->quantiteDansPanier = $quantiteDansPanier;
    }
    

    /* MÉTHODE GÉNÉRALE */

    /**
     * Assigne les bonnes valeurs aux attributs
     * @param {array} $donnes - tableau associatif contenant les attributs et les valeurs
     */
    public function hydrate(array $donnees) {
        foreach ($donnees as $attribut => $valeur) {
            $methode = 'set'.ucfirst($attribut);
            if(method_exists($this, $methode)) {
                $this->$methode($valeur);
            }
        }
    }


    public function getTableau(){
        return get_object_vars($this);
    }


}

?>