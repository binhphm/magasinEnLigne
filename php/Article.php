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
            trigger_error('Le numéro d\'article doit être un nombre entier.', E_USER_WARNING);
            return;
        }
        $this->noArticle = $noArticle;
    }

    public function setDescription($description) {
        if(!is_string($description)){
            trigger_error('La description d\'un article doit être une chaîne de caractères.', E_USER_WARNING);
            return;
        }
        $this->description = $description;
    }

    public function setCheminImage($cheminImage) {
        if(!preg_match(self::CHEMIN_IMAGE, $cheminImage)){
            trigger_error('Le chemin de l\'image d\'un article doit être une chaîne de caractères.', E_USER_WARNING);
            return;
        }
        $this->cheminImage = $cheminImage;
    }

    public function setPrixUnitaire($prixUnitaire) {
        $prixUnitaire = (double) $prixUnitaire;
        
        if(!is_double($prixUnitaire)){
            trigger_error('Le prix unitaire d\'un article doit être un nombre décimal.', E_USER_WARNING);
            return;
        }
        
        $this->prixUnitaire = $prixUnitaire;
    }

    public function setQuantiteEnStock($quantiteEnStock) {
        $quantiteEnStock = (int) $quantiteEnStock;

        if(!is_int($quantiteEnStock)){
            trigger_error('La quantité en stock d\'un article doit être un nombre entier.', E_USER_WARNING);
            return;
        }
        $this->quantiteEnStock = $quantiteEnStock;
    }

    public function setQuantiteDansPanier($quantiteDansPanier) {
        $quantiteDansPanier = (int) $quantiteDansPanier;
        
        if(!is_int($quantiteDansPanier)){
            trigger_error('La quantité dans le panier doit être un nombre entier.', E_USER_WARNING);
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