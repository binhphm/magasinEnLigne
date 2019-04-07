<?php

/**
 * Représente un objet de type Article
 */
class Article {

    /* ATTRIBUTS */
    private $_noArticle;
    private $_categorie;
    private $_description;
    private $_cheminImage;
    private $_prixUnitaire;
    private $_quantiteEnStock;
    private $_quantiteDansPanier;

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
        return $this->_noArticle;
    }

    public function getCategorie() {
        return $this->_categorie;
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
        $noArticle = (int) $noArticle;
        if(!is_int($noArticle)){
            error_log('Le numéro d\'article doit être un nombre entier.' . PHP_EOL, 3, 'erreurs.txt');
            return;
        }
        $this->_noArticle = $noArticle;
    }

    public function setCategorie($categorie) {
        if(!is_string($categorie)){
            error_log('La catégorie d\'un article doit être une chaîne de caractères.' . PHP_EOL, 3, 'erreurs.txt');
            return;
        }
        $this->_categorie = $categorie;
    }

    public function setDescription($description) {
        if(!is_string($description)){
            error_log('La description d\'un article doit être une chaîne de caractères.' . PHP_EOL, 3, 'erreurs.txt');
            return;
        }
        $this->_description = $description;
    }

    public function setCheminImage($cheminImage) {
        if(!preg_match(self::CHEMIN_IMAGE, $cheminImage)){
            error_log('Le chemin de l\'image d\'un article doit être une chaîne de caractères.' . PHP_EOL, 3, 'erreurs.txt');
            return;
        }
        $this->_cheminImage = $cheminImage;
    }

    public function setPrixUnitaire($prixUnitaire) {
        $prixUnitaire = (double) $prixUnitaire;
        
        if(!is_double($prixUnitaire)){
            error_log('Le prix unitaire d\'un article doit être un nombre décimal.' . PHP_EOL, 3, 'erreurs.txt');
            return;
        }
        
        $this->_prixUnitaire = $prixUnitaire;
    }

    public function setQuantiteEnStock($quantiteEnStock) {
        $quantiteEnStock = (int) $quantiteEnStock;

        if(!is_int($quantiteEnStock)){
            error_log('La quantité en stock d\'un article doit être un nombre entier.' . PHP_EOL , 3, 'erreurs.txt');
            return;
        }
        $this->_quantiteEnStock = $quantiteEnStock;
    }

    public function setQuantiteDansPanier($quantiteDansPanier) {
        $quantiteDansPanier = (int) $quantiteDansPanier;
        
        if(!is_int($quantiteDansPanier)){
            error_log('La quantité dans le panier doit être un nombre entier.' . PHP_EOL , 3, 'erreurs.txt');
            return;
        }
        
        $this->_quantiteDansPanier = $quantiteDansPanier;
    }
    

    /* MÉTHODES GÉNÉRALES */

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


    /**
     * Retourne les attributs et les valeurs de l'article
     * @return array - un tableau associatif (retire les "_" des attributs)
     */
    public function getTableau(){
        return array (
            "noArticle" => $this->getNoArticle(),
            "categorie" => $this->getCategorie(),
            "description" => $this->getDescription(),
            "cheminImage" => $this->getCheminImage(),
            "prixUnitaire" => number_format($this->getPrixUnitaire(), 2, ',', ' ') . ' $',
            "quantiteEnStock" => $this->getQuantiteEnStock(),
            "quantiteDansPanier" => $this->getQuantiteDansPanier()
        );
    }


}

?>