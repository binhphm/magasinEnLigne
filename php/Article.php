<?php

/**
 * Représente un objet de type Article
 */
class Article {

    /* ATTRIBUTS */
    private $_noArticle;
    private $_description;
    private $_cheminImage;
    private $_prixUnitaire;
    private $_quantiteEnStock;
    private $_quantiteDansPanier;

    /* CONSTANTES (regex) */
    const CHEMIN_IMAGE = '/^images\/*.(jpg|jpeg|png|gif)$/';
    

    /**
     * CONSTRUCTEUR : crée un objet de type Article
     * @param {array} $donnees - tableau associatif contenant les attributs et leurs valeurs
     */
    public function __construct(array $donnees){
        $this->hydrate($donnees);
    }


    /* ACCESSEURS */

    public function getNoArticle() {
        return $this->_noArticle;
    }

    public function getDescription() {
        return $this->_description;
    }

    public function getCheminImage() {
        return $this->_cheminImage;
    }

    public function getPrixUnitaire() {
        return $this->_prixUnitaire;
    }

    public function getQuantiteEnStock() {
        return $this->_quantiteEnStock;
    }

    public function getQuantiteDansPanier() {
        return $this->_quantiteDansPanier;
    }

    /* MUTATEURS */

    public function setNoArticle($noArticle) {
        if(!is_int($noArticle)){
            trigger_error('Le numéro d\'article doit être un nombre entier.', E_USER_WARNING);
            return;
        }
        $this->_noArticle = $noArticle;
    }

    public function setDescription($description) {
        if(!is_string($description)){
            trigger_error('La description d\'un article doit être une chaîne de caractères.', E_USER_WARNING);
            return;
        }
        $this->_description = $description;
    }

    public function setCheminImagw($cheminImage) {
        if(!preg_match(self::CHEMIN_IMAGE, $cheminImage)){
            trigger_error('Le chemin de l\'image d\'un article doit être une chaîne de caractères.', E_USER_WARNING);
            return;
        }
        $this->_cheminImage = $cheminImage;
    }

    public function setPrixUnitaire($prixUnitaire) {
        if(!is_double($prixUnitaire)){
            trigger_error('Le prix unitaire d\'un article doit être un nombre décimal.', E_USER_WARNING);
            return;
        }
        $this->_prixUnitaire = $prixUnitaire;
    }

    public function setQuantiteEnStock($quantiteEnStock) {
        if(!is_int($quantiteEnStock)){
            trigger_error('La quantité en stock d\'un article doit être un nombre entier.', E_USER_WARNING);
            return;
        }
        $this->_quantiteEnStock = $quantiteEnStock;
    }

    public function setQuantiteDansPanier($quantiteDansPanier) {
        if(!is_int($quantiteDansPanier)){
            trigger_error('La quantité dans le panier doit être un nombre entier.', E_USER_WARNING);
            return;
        }
        $this->_quantiteDansPanier = $quantiteDansPanier;
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
}

?>