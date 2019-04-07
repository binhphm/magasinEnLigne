<?php

/**
 * Représente un objet de type GestionBD
 * Son rôle est de gérer la base de données MySQL
 */
class GestionBD {

    /* ATTRIBUT */
    private $_bdd;

    /**
     * CONSTRUCTEUR : instanciation de l'objet
     * @param {string} $nomBD - le nom de la base de données
     * @param {string} $utilisateur - l'utilisateur
     * @param {string} $mdp - le mot de passe
     */
    public function __construct($nomBD, $utilisateur, $mdp) {
        $this->connexionBD($nomBD, $utilisateur, $mdp);
    }

    /**
     * Se connecte à la base de données
     * @param {string} $nomBD - le nom de la base de données
     * @param {string} $utilisateur - l'utilisateur
     * @param {string} $mdp - le mot de passe
     */
    public function connexionBD($nomBD, $utilisateur, $mdp) {

        $nsd = "mysql:host=localhost;dbname=$nomBD;charset=utf8";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->_bdd = new PDO($nsd, $utilisateur, $mdp, $options);
        } 
        catch (PDOException $e) {
            error_log('Message : ' . $e->getMessage() . "\t Code : " . (int)$e->getCode(). "\n" , 3, "erreurs.txt");
            exit;
        }

    }

    /**
     * Retourne la liste de l'inventaire
     * @return {array} un tableau associatif contenant les articles
     */
    public function getListeArticles() {
        $listeArticles = array();

        $requete = $this->_bdd->query('SELECT * FROM article ORDER BY description');
       
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($donnees);
            array_push($listeArticles, $article->getTableau());
        }

        $requete->closeCursor();

        return $listeArticles;
    }

    /**
     * Retourne une liste d'articles ayant la même catégorie
     * @param {string} $categorie - la catégorie de l'article
     * @return array - un tableau associatif contenant les articles
     */
    public function listerParCategorie($categorie){
        $listeArticles = array();

        $requete = $this->_bdd->prepare('SELECT * FROM article WHERE categorie = ? ORDER BY description');
        $requete->bindValue(1, $categorie, PDO::PARAM_STR);
        $requete->execute();

        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($donnees);
            array_push($listeArticles, $article->getTableau());
        }

        $requete->closeCursor();

        return $listeArticles;
    }

    /**
     * Retourne une liste d'article contant le même mot dans leur description
     * @param {string} $mot - le mot cherché
     * @return array - un tableau associatif contenant des articles
     */
    public function listerParMot($mot){
        $mot = strtolower($mot);
        $listeArticles = array();

        $requete = $this->_bdd->query("SELECT * FROM article WHERE LOWER(description) LIKE '%$mot%' ORDER BY description");
        
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($donnees);
            array_push($listeArticles, $article->getTableau());
        }

        $requete->closeCursor();

        return $listeArticles;

    }

    /**
     * Retourne un seul article
     * @param {int} $id - l'identifiant de l'article
     * @return array - un tableau associatif de l'instance d'un objet Article
     */
    public function getArticle($noArticle) {
        $listeArticles = array();
       
        $noArticle = (int) $noArticle;
        if(!is_int($noArticle)){
            trigger_error('Le numéro d\'un article doit être un nombre entier');
            return;
        }

        $requete = $this->_bdd->prepare('SELECT * FROM article WHERE noArticle = ?');
        $requete->bindValue(1, $noArticle, PDO::PARAM_INT);
        $requete->execute();
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        $requete->closeCursor();

        $article = new Article($donnees);
        array_push($listeArticles, $article->getTableau());
        return $listeArticles;
    }

    
}

?>