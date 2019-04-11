/**
 * Change la quantité d'un article
 * @param {HTMLElement} bouton 
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
 * 
 * @param {function} callback - la fonction à appeler après avoir affiché le HTML
 * @param {string} filtre - le critère de sélection
 * @param {string} valeur - la valeur du critère de sélection
 */
function afficherInventaire(callback, filtre, valeur) {
    let modeleInventaire = new ModeleMagasin("affichage-articles");
    modeleInventaire.appliquerModele("", "milieu-page");
    callback(filtre, valeur);
}

/**
 * Liste chaque élément de l'inventaire
 * @param {string} filtre - le critère de sélection
 * @param {string} valeur - la valeur du critère de sélection
 */
function listerArticles(filtre, valeur){

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
            "PANIER[" + JSON.parse(donnees) + "]";
    });
}


/**
 * Afficher le sommaire du panier
 * @param {function} callback - la fonction à appeler après que le sommaire soit chargé
 */
function afficherSommaire(callback){

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
 * @param {function} callback - la fonction après avoir ajouté au panier
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
 * Supprime un élément du panier
 * @param {function} callback - la fonction après avoir supprimé
 * @param {function} callback2 - la fonction après avoir calculé le nb d'items
 * @param {function} callback3 - la fonction après avoir affiché le sommaire
 */
function supprimerDuPanier(callback, callback2, callback3){
   
    let idBouton = event.target.getAttribute("id");
    let noArticle = document.getElementById(idBouton).dataset.value;

    let objJSON = {
        "requete" : "supprimer",
        "noArticle" : noArticle
    };

    let txtJSON = JSON.stringify(objJSON);
    let requete = new RequeteAjax("php/main.php");
    requete.envoyerDonnees(txtJSON, reponse => {console.log(reponse);});
    callback(callback2(callback3));
    
}

/**
 * Modifier les quantités du panier
 * @param {function} callback - la fonction après avoir modifié
 * @param {function} callback2 - la fonction après avoir calculé le nb d'items
 * @param {function} callback3 - la fonction après avoir affiché le sommaire
 */
function modifierPanier(callback, callback2, callback3) {
    //Tableau des numéros d'article
    let liensNoArticle = document.getElementsByClassName("closed");
    let tabNoArticle = new Array();
    for(let i = 0; i < liensNoArticle.length; i++){
        tabNoArticle.push(liensNoArticle[i].dataset.value);
    }
    //Tableau des quantités
    let champsQuantite = document.getElementsByClassName("quantite");
    let tabQuantite = new Array();
    for(let i = 0; i < champsQuantite.length; i++){
        tabQuantite.push(champsQuantite[i].value);
    }

    let objJSON = {
        "requete" : "modifier",
        "tabNoArticle" : JSON.stringify(tabNoArticle),
        "tabQuantite" : JSON.stringify(tabQuantite)
    };

    let txtJSON = JSON.stringify(objJSON);
    let requete = new RequeteAjax("php/main.php");
    requete.envoyerDonnees(txtJSON, reponse => {console.log(reponse);});
    callback(callback2(callback3));
}

/**
 * Applique le rabais de 20%
 * @param {function} callback - la fonction après avoir appliqué le rabais
 * @param {function} callback2 - la fonction après avoir affiché le sommaire
 */
function appliquerCoupon(callback, callback2) {
    event.preventDefault();
    
    let coupon = document.getElementById("coupon").value;
    
    if(coupon === "RAB20"){
        let objJSON = {"requete" : "rabais"};
        let txtJSON = JSON.stringify(objJSON);
        let requete = new RequeteAjax("php/main.php");
        requete.envoyerDonnees(txtJSON, reponse => {console.log(reponse);});
        callback(callback2);
    }

    else {
        alert("Vous n'avez pas saisi le bon code.");
    }
      
}

/**
 * Affiche le formulaire de commande et le sommaire de la facture
 */
function afficherCaisse(callback){
    let requete = new RequeteAjax("php/main.php?q=panier&r=sommaire");
    let modeleCaisse = new ModeleMagasin("modele-caisse");
    requete.getJSON(donnees => {
        modeleCaisse.appliquerModele(donnees, "milieu-page");
    });
    callback();
}


/**
 * Liste chaque élément de la facture
 */
function listerFacture() {
    let requete = new RequeteAjax("php/main.php?q=panier&r=facture");
    let modeleFacture = new ModeleMagasin("modele-details-facture");
    requete.getJSON(donnees => {
        modeleFacture.appliquerModele(donnees, "details-facture");
    });
}

/**
 * Ajoute un client s'il n'est pas membre et
 * Créé une commande avec les articles
 */
function placerCommande() {
    
}

