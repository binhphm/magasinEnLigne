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
 */
function ajouterAuPanier() {
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
    requete.envoyerDonnees(txtJSON, getTotalPanier);
}


/**
 * Supprime un élément du panier
 */
function supprimerDuPanier(){
   
    let idBouton = event.target.getAttribute("id");
    let noArticle = document.getElementById(idBouton).dataset.value;

    let objJSON = {
        "requete" : "supprimer",
        "noArticle" : noArticle
    };

    let txtJSON = JSON.stringify(objJSON);
    let requete = new RequeteAjax("php/main.php");
    requete.envoyerDonnees(txtJSON, getTotalPanier);
    afficherSommaire(listerPanier);
}

/**
 * Modifier les quantités du panier
 */
function modifierPanier() {
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
    requete.envoyerDonnees(txtJSON, getTotalPanier);
    afficherSommaire(listerPanier);
}



/**
 * Affiche le formulaire de commande et le sommaire de la facture
 * @param {function} callback - la fonction à appelé après avoir affiché la caisse
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
    let requete = new RequeteAjax("php/main.php?q=panier&r=liste");
    let modeleFacture = new ModeleMagasin("modele-details-facture");
    requete.getJSON(donnees => {
        modeleFacture.appliquerModele(donnees, "details-facture");
    });
}

/**
 * Créé une commande avec les articles
 */
function placerCommande() {

    /* DONNÉES DU CLIENT */
    let nom = document.getElementById("lname").value;
    let prenom = document.getElementById("fname").value;
    let adresse1 = document.getElementById("address").value;
    let adresse2 = document.getElementById("address2").value;
    let adresse = adresse1 + (adresse2 !== "" ? adresse2 : "");
    let ville = document.getElementById("towncity").value;
    let province = document.getElementById("province").value;
    let codePostal = document.getElementById("zippostalcode").value;
    let noTel = document.getElementById("phone").value;
    let courriel = document.getElementById("email").value;

    let client = {
        "nomClient" : nom,
        "prenomClient" : prenom,
        "adresse" : adresse,
        "ville" : ville,
        "province" : province,
        "codePostal" : codePostal,
        "noTel" : noTel,
        "courriel" : courriel
    };

    /* DONNÉES DES ARTICLES */
    
    //Tableau des numéros d'article
    let numeros = document.getElementsByClassName("numeros");
    let tabNoArticle = new Array();
    for(let i = 0; i < numeros.length; i++){
        tabNoArticle.push(numeros[i].value);
    }
    //Tableau des quantités
    let quantites = document.getElementsByClassName("quantites");
    let tabQuantite = new Array();
    for(let i = 0; i < quantites.length; i++){
        tabQuantite.push(quantites[i].value);
    }

    /* JSON à envoyer */
    let objJSON = {
        "requete" : "commande",
        "client" : JSON.stringify(client),
        "tabNoArticle" : JSON.stringify(tabNoArticle),
        "tabQuantite" : JSON.stringify(tabQuantite)
    };

    let txtJSON = JSON.stringify(objJSON);
    let requete = new RequeteAjax("php/main.php");
    requete.envoyerDonnees(txtJSON, (donnees) => {
        getTotalPanier();
        alert("La commande a été effectuée avec succès.\nLe numéro de confirmation est :" + JSON.parse(donnees));
        afficherConfirmation();
    });
   
}

function afficherConfirmation(){
    

}

