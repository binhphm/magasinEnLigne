<?php

/**
 * Représente un objet de type GestionArticles
 * Son rôle est de gérer les articles dans la base de données MySQL
 * Hérite de la classe GestionBD
 */
class GestionArticles extends GestionBD {

    /**
     * Retourne la liste de l'inventaire
     * @return {array} un tableau associatif contenant les articles
     */
    public function getListeArticles() {
        $listeArticles = array();

        $requete = $this->_bdd->query('SELECT * FROM article ORDER BY `description`');
       
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

        $requete = $this->_bdd->prepare('SELECT * FROM article WHERE categorie = ? ORDER BY `description`');
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

        $requete = $this->_bdd->query("SELECT * FROM article WHERE LOWER(description) LIKE '%$mot%' ORDER BY `description`");
        
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
            error_log('Le numéro d\'un article doit être un nombre entier', 3, 'erreurs.txt');
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

    /**
     * Augmente la quantité dans le panier
     * @param {int} $noArticle - l'identifiant de l'article
     * @param {int} $quantite - la quantité demandée
     */
    private function augmenterQtePanier($noArticle, $quantite){
        $noArticle = (int) $noArticle;
        $quantite = (int) $quantite;
        if(!is_int($noArticle) || !is_int($quantite)){
            error_log('Le numéro ou la quantité d\'un article doit être un nombre entier', 3, 'erreurs.txt');
            return;
        }

        $requete = $this->_bdd->prepare(
            'UPDATE article 
            SET quantiteDansPanier = quantiteDansPanier + :quantite
            WHERE noArticle = :noArticle 
            AND quantiteDansPanier < quantiteEnStock'
        );

        $requete->bindValue(':noArticle', $noArticle, PDO::PARAM_INT);
        $requete->bindValue(':quantite', $quantite, PDO::PARAM_INT);
        $requete->execute();
        $requete->closeCursor();

    }

    /**
     * Diminue la quantité en stock
     * @param {int} $noArticle - l'identifiant de l'article
     * @param {int} $quantite - la quantité demandée
     */
    private function diminuerQteStock($noArticle, $quantite) {
        $noArticle = (int) $noArticle;
        $quantite = (int) $quantite;
        if(!is_int($noArticle) || !is_int($quantite)){
            error_log('Le numéro ou la quantité d\'un article doit être un nombre entier', 3, 'erreurs.txt');
            return;
        }

        $requete = $this->_bdd->prepare(
            'UPDATE article 
            SET quantiteEnStock = quantiteEnStock - :quantite 
            WHERE noArticle = :noArticle 
            AND quantiteDansPanier < quantiteEnStock'
        );

        $requete->bindValue(':noArticle', $noArticle, PDO::PARAM_INT);
        $requete->bindValue(':quantite', $quantite, PDO::PARAM_INT);
        $requete->execute();
        $requete->closeCursor();
    }

    /**
     * Réserve un article dans l'inventaire
     * @param {int} $noArticle - l'identifiant de l'article
     * @param {int} $quantite - la quantité demandée
     */
    public function reserverArticle($noArticle, $quantite) {
        $this->augmenterQtePanier($noArticle, $quantite);
        $this->diminuerQteStock($noArticle, $quantite);
    }


    /**
     * Rétablit le nombre d'article en stock pour un seul article
     */
    private function remettreStock($noArticle){
        $noArticle = (int) $noArticle;
        if(!is_int($noArticle)){
            error_log('Le numéro d\'un article doit être un nombre entier', 3, 'erreurs.txt');
            return;
        }

        $requete = $this->_bdd->prepare(
            'UPDATE article
            SET quantiteEnStock = quantiteEnStock + quantiteDansPanier
            WHERE noArticle = ?'
        );
        $requete->bindValue(1, $noArticle, PDO::PARAM_INT);
        $requete->execute();
        $requete->closeCursor();
    }
    

    /**
     * Efface la quantité d'article dans le panier pour un seul article
     */
    private function effacerQtePanier($noArticle) {
        $noArticle = (int) $noArticle;
        if(!is_int($noArticle)){
            error_log('Le numéro d\'un article doit être un nombre entier', 3, 'erreurs.txt');
            return;
        }

        $requete = $this->_bdd->prepare('UPDATE article SET quantiteDansPanier = 0 WHERE noArticle = ?');
        $requete->bindValue(1, $noArticle, PDO::PARAM_INT);
        $requete->execute();
        $requete->closeCursor();
    }

    /**
     * Supprime un élément du panier
     * @param {string} $description - la description de l'article
     */
    public function supprimerDuPanier($noArticle){
        $this->remettreStock($noArticle);
        $this->effacerQtePanier($noArticle);
    }

    /**
     * Calcule la quantité en stock d'un article
     * @param $noArticle - l'identifiant de l'article
     * @return int
     */
    private function getQteStock($noArticle){
        $noArticle = (int) $noArticle;
        if(!is_int($noArticle)){
            error_log('Le numéro d\'un article doit être un nombre entier', 3, 'erreurs.txt');
            return;
        }
        $requete = $this->_bdd->prepare('SELECT quantiteEnStock FROM article WHERE noArticle = ?');
        $requete->bindValue(1, $noArticle, PDO::PARAM_INT);
        $requete->execute();
        $donnees = $requete->fetch(PDO::FETCH_NUM);
        $requete->closeCursor();
        
        return (int) $donnees[0];
    }

    /**
     * Calcule la quantité dans le panier d'un article
     * @param $noArticle - l'identifiant de l'article
     * @return int
     */
    private function getQteDansPanier($noArticle){
        $noArticle = (int) $noArticle;
        if(!is_int($noArticle)){
            error_log('Le numéro d\'un article doit être un nombre entier', 3, 'erreurs.txt');
            return;
        }
        $requete = $this->_bdd->prepare('SELECT quantiteDansPanier FROM article WHERE noArticle = ?');
        $requete->bindValue(1, $noArticle, PDO::PARAM_INT);
        $requete->execute();
        $donnees = $requete->fetch(PDO::FETCH_NUM);
        $requete->closeCursor();
        
        return (int) $donnees[0];
    }


    /**
     * Modifie la quantité en stock
     * @param {array} $tabNoArticle - tous les numéros d'article
     * @param {array} $tabQteDansPanier - toutes les quantités
     */
    private function modifierQteStock($tabNoArticle, $tabQuantite) {
        for($i = 0; $i < count($tabNoArticle); $i++) {
            //Calculer la somme des quantités (stock + panier)
            $somme = $this->getQteStock((int) $tabNoArticle[$i]) + $this->getQteDansPanier((int)$tabNoArticle[$i]);
        
            $requete = $this->_bdd->prepare(
                'UPDATE article
                SET quantiteEnStock = :somme - :quantite 
                WHERE noArticle = :noArticle
                AND quantiteDansPanier <= quantiteEnStock'
            );
            
            $requete->bindValue(':somme', (int) $somme, PDO::PARAM_INT);
            $requete->bindValue(':quantite', (int) $tabQuantite[$i], PDO::PARAM_INT);
            $requete->bindValue(':noArticle', (int) $tabNoArticle[$i], PDO::PARAM_INT);
            $requete->execute();
            $requete->closeCursor();

        }
    }

    /**
     * Modifie la quantité dans le panier
     * @param {array} $tabNoArticle - tous les numéros d'article
     * @param {array} $tabQteDansPanier - toutes les quantités
     */
    private function modifierQtePanier($tabNoArticle, $tabQuantite) {
        
        for($i = 0; $i < count($tabNoArticle); $i++) {
            $requete = $this->_bdd->prepare(
                'UPDATE article
                SET quantiteDansPanier = :quantite
                WHERE noArticle = :noArticle
                AND quantiteDansPanier <= quantiteEnStock'
            );
        
            $requete->bindValue(':quantite', (int) $tabQuantite[$i], PDO::PARAM_INT);
            $requete->bindValue(':noArticle', (int) $tabNoArticle[$i], PDO::PARAM_INT);
            $requete->execute();
            $requete->closeCursor();

        }
    }

    /**
     * Modifie la quantité dans le panier
     * @param {array} $tabNoArticle - tous les numéros d'article
     * @param {array} $tabQteDansPanier - toutes les quantités
     */
    public function modifierPanier($tabNoArticle, $tabQuantite){
        $this->modifierQteStock($tabNoArticle, $tabQuantite);
        $this->modifierQtePanier($tabNoArticle, $tabQuantite);   
    }


    /**
     * Efface le nombre d'articles dans le panier pour tous
     */
    public function effacerQtePanierTous() {
        $requete = $this->_bdd->query('UPDATE article SET quantiteDansPanier = 0');
        $requete->closeCursor();
    }

}

?>