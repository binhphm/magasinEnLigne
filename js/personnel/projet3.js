/**
 * Affiche tout les produits en vente
 */
function afficherArticles() {
    let requete = new RequeteAjax("php/main.php");
    let modeleListeArticles = new ModeleMagasin("modele-liste-articles");
    requete.getJSON(donnees => {modeleListeArticles.appliquerModele(donnees, "liste-articles");});
}