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
    let requete = new RequeteAjax("php/main.php?q=inventaire" + 
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
    let requete = new RequeteAjax("php/main.php?q=inventaire&noArticle=" + noArticle);
    let modeleArticle = new ModeleMagasin("modele-article");
    requete.getJSON(donnees => {modeleArticle.appliquerModele(donnees, "milieu-page");});
}

/**
 * Affiche le nombre total d'éléments dans le panier
 */
function getTotalPanier(){
    let requete = new RequeteAjax("php/main.php?q=panier&r=total");
    requete.getJSON(donnees => {
        document.getElementById("nombre-total").innerHTML = 
            "Panier [" + JSON.parse(donnees) + "]";
    });
}



/**
 * Affiche le sommaire du panier
 */
function afficherSommaire(callback){
    viderMilieuPage();
    let requete = new RequeteAjax("php/main.php?q=panier&r=sommaire");
    let modelePanier = new ModeleMagasin("modele-panier");
    requete.getJSON(donnees => {
        modelePanier.appliquerModele(donnees, "milieu-page");
    });
    callback();
}

/**
 * Affiche tous les éléments du panier
 */
function listerPanier(){
    let requete = new RequeteAjax("php/main.php?q=panier&r=liste");
    let modeleListePanier = new ModeleMagasin("modele-liste-panier");
    requete.getJSON(donnees => {
        modeleListePanier.appliquerModele(donnees, "liste-panier");
    });
}

/**
 * Ajoute un article au panier d'achat
 */
function ajouterAuPanier(callback) {
    let objJSON = {
        "requete" : "ajouter",
        "noArticle" : document.getElementById("identifiant").value,
        "description": document.getElementById("description").value, 
        "cheminImage" : document.getElementById("cheminImage").value,
        "prixUnitaire": document.getElementById("prix").value,
        "quantite" : document.getElementById("quantity").value
    };

    let txtJSON = JSON.stringify(objJSON);
    let requete = new RequeteAjax("php/main.php");
    requete.envoyerDonnees(txtJSON, reponse => {console.log(reponse);});
    callback();
}


/**
 * Supprime un article du panier d'achat
 */
function supprimerDuPanier(callback){
    let objJSON = {
        "requete" : "supprimer",
        "noArticle" : document.getElementById("identifiant").value,
        "description" : document.getElementById("description").value
    };

    let txtJSON = JSON.stringify(objJSON);
    let requete = new RequeteAjax("php/main.php");
    requete.envoyerDonnees(txtJSON, reponse => {console.log(reponse);});
    callback();
    afficherSommaire(listerPanier);
}




