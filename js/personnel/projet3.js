/**
 * Efface le HTML du milieu de la page
 */
function viderMilieuPage() {
    document.getElementById("milieu-page").innerHTML = "";
}

/**
 * Change la quantité d'un article
 */
function changerQuantite(bouton){
    let valeur = parseInt(document.getElementById("quantity").value);
    if(bouton.dataset.type == "minus" && valeur > 0){
        valeur--;
    }
    else if(bouton.dataset.type == "plus" && valeur < 100){
        valeur++;
    }
    document.getElementById("quantity").value = valeur;
}

/**
 * Affiche tout les produits en vente
 */
function listerArticles(filtre, valeur){

    viderMilieuPage();

    //Afficher le HTML qui "entoure" la liste d'articles
    let temp = document.getElementById("affichage-articles");
    let clone = temp.content.cloneNode(true);
    document.getElementById("milieu-page").appendChild(clone);
    
    //Afficher tous les articles
    let requete = new RequeteAjax("php/main.php?q=afficher" + 
                    ((filtre != "" && valeur != "") ? "&" + filtre + "=" + valeur : ""));
    let modeleListeArticles = new ModeleMagasin("modele-liste-articles");
    requete.getJSON(donnees => {modeleListeArticles.appliquerModele(donnees, "liste-articles");});

}

/**
 * Affiche un seul article
 * @param {string} noArticle - l'identifiant de l'article
 */
function afficherArticle(noArticle){
    viderMilieuPage();
    let requete = new RequeteAjax("php/main.php?q=afficher&noArticle=" + noArticle);
    let modeleArticle = new ModeleMagasin("modele-article");
    requete.getJSON(donnees => {modeleArticle.appliquerModele(donnees, "milieu-page");});
}

/**
 * Affiche le nombre total d'éléments dans le panier
 */
function getTotalPanier(){
    let requete = new RequeteAjax("php/main.php?q=panier&r=total");
    let textePanier = new TexteMagasin();
    requete.getJSON(donnees => {textePanier.remplacerNombre(donnees, "nombre-total");});
}

function afficherPanier(){
    viderMilieuPage();

    //Afficher le HTML qui "entoure" les éléments du panier
    let temp = document.getElementById("affichage-panier");
    let clone = temp.content.cloneNode(true);
    document.getElementById("milieu-page").appendChild(clone);
}


