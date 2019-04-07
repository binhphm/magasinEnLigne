/**
 * Affiche ou cache un élément
 * @param {string} idElement - l'identifiant de l'élément HTML
 * @param {boolean} estAffiche - si l'élément doit être visible ou pas
 */
function afficherElement(idElement, estAffiche) {
    document.getElementById(idElement).style.display = (estAffiche? "block" : "none");
}


/**
 * Affiche tout les produits en vente
 */
function listerArticles(){

    //Afficher le HTML qui "entoure" la liste d'articles
    afficherElement("affichage-articles", true);

    //Afficher tous les articles
    let requete = new RequeteAjax("php/main.php?q=afficher");
    let modeleListeArticles = new ModeleMagasin("modele-liste-articles");
    requete.getJSON(donnees => {modeleListeArticles.appliquerModele(donnees, "liste-articles");});
}

/**
 * Affiche un seul article
 */
function afficherArticle(noArticle){

    //Cacher l'affichage de plusieurs articles
    afficherElement("affichage-articles", false);

    let requete = new RequeteAjax("php/main.php?q=afficher&noArticle=" + noArticle);
    let modeleListeArticles = new ModeleMagasin("modele-liste-articles");
    requete.getJSON(donnees => {modeleListeArticles.appliquerModele(donnees, "liste-articles");});
}

