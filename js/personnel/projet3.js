/**
 * -----------------------
 * INVENTAIRE
 * -----------------------
 */

 /**
 * Affiche l'élément HTML qui la contenir la liste des articles
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
 * -----------------------
 * PANIER D'ACHAT
 * -----------------------
 */

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
 * Permet de choisir la quantité d'un article avant d'ajouter l'article dans le panier
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
 * Afficher le sommaire du panier
 * @param {function} callback - la fonction à appeler après que le sommaire soit chargé
 */
function afficherSommaire(){

    let requete = new RequeteAjax("php/main.php?q=panier&r=sommaire");
    let modelePanier = new ModeleMagasin("modele-panier");
    requete.getJSON(donnees => {
        modelePanier.appliquerModele(donnees, "milieu-page");
        listerPanier();
    });
   
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
 * -----------------------
 * CLIENT
 * -----------------------
 */

/**
  * Affiche le formulaire d'inscription
  */
 function formulaireInscription() {
    let modeleInscription = new ModeleMagasin("modele-inscription");
    modeleInscription.appliquerModele('', "milieu-page");
 }

 /**
  * Valide les données du formulaire
  */
 function validerFormulaire(){

    //Données du formulaire
    let nom = document.getElementById("lname").value;
    let prenom = document.getElementById("fname").value;
    let adresse1 = document.getElementById("address").value;
    let adresse2 = document.getElementById("address2").value;
    let adresse = adresse1 + (adresse2 !== "" ? " " + adresse2 : "");
    let ville = document.getElementById("towncity").value;
    let province = document.getElementById("province").value;
    let codePostal = document.getElementById("zippostalcode").value;
    let noTel = document.getElementById("phone").value;
    let courriel = document.getElementById("email").value;
    let pseudo = document.getElementById("pseudo").value;
    let motDePasse = document.getElementById("mot-de-passe").value;
    let confMotDePasse = document.getElementById("conf-mot-de-passe").value;

    //Expression régulières
    const LETTRES_SEULEMENT = /[a-zA-ZáàäâéèëêíìïîóòöôúùüûçñÁÀÄÂÉÈËÊÍÌÏÎÓÒÖÔÚÙÜÛÑÇ\'\-]+/;
    const CODE_POSTAL = /^(?!.*[DFIOQU])[A-VXY][0-9][A-Z] ?[0-9][A-Z][0-9]$/;
    const NO_TEL = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    const COURRIEL = /[^@]+@[^\.]+\..+/g;

    //Vérifier si le nom, le prénom et la ville ont seulement des lettres
    if(!nom.match(LETTRES_SEULEMENT) || !prenom.match(LETTRES_SEULEMENT) || 
            !ville.match(LETTRES_SEULEMENT)){
        document.getElementById("message-erreur").innerHTML = "Ce champ ne doit contenir que des lettres";
        return;
    }
   
    //Vérifier si le code postal est valide
    if(!codePostal.match(CODE_POSTAL)) {
        document.getElementById("message-erreur").innerHTML = "Format de code postal invalide";
        return;
    }

    //Vérifier si le numéro de téléphone est valide
    if(!noTel.match(NO_TEL)) {
        document.getElementById("message-erreur").innerHTML = "Format de numéro de téléphone invalide";
        return;
    }

    //Vérifier si le courriel est valide
    if(!courriel.match(COURRIEL)) {
        document.getElementById("message-erreur").innerHTML = "Format de courriel invalide";
        return;
    }

    //Vérifier que les deux mots de passes sont identiques
    if(motDePasse !== confMotDePasse) {
        document.getElementById("message-erreur").innerHTML = "Les deux mots de passe doivent être identiques";
        return;
    }

    let client = {
        "nomClient" : nom,
        "prenomClient" : prenom,
        "adresse" : adresse,
        "ville" : ville,
        "province" : province,
        "codePostal" : codePostal,
        "noTel" : noTel,
        "courriel" : courriel,
        "pseudo" : pseudo,
        "motDePasse" : motDePasse
    }

    let objJSON = {
        "requete" : "client",
        "client" : JSON.stringify(client) 
    };

    let txtJSON = JSON.stringify(objJSON);
    ajouterClient(txtJSON);
 }

 function ajouterClient(txtJSON) {
    let requete = new RequeteAjax("php/main.php");
    requete.envoyerDonnees(txtJSON, (donnees) => {
      console.log(donnees);
    });
 }





/**
 * -----------------------
 * CAISSE
 * -----------------------
 */

 /**
 * Affiche le formulaire de commande et le sommaire de la facture
 * @param {function} callback - la fonction à appelé après avoir affiché la caisse
 */
function afficherCaisse(){
    let requete = new RequeteAjax("php/main.php?q=panier&r=sommaire");
    let modeleCaisse = new ModeleMagasin("modele-caisse");
    requete.getJSON(donnees => {
        modeleCaisse.appliquerModele(donnees, "milieu-page");
        listerFacture();
    });
   
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
/*function placerCommande() {

    
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

    
    let objJSON = {
        "requete" : "commande",
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


function afficherPaypal () {

    //<div id="paypal-button-container"></div>
    paypal.Buttons({
        locale: 'fr_CA',
        style: {
            layout:  'vertical',
            color:   'silver',
            shape:   'pill',
            label:   'paypal'
        },
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: document.getElementById("total-facture").value
              }
            }]
          });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
              alert('Transaction completed by ' + details.payer.name.given_name);
              return fetch('/paypal-transaction-complete', {
                method: 'post',
                headers: {
                  'content-type': 'application/json'
                },
                body: JSON.stringify({
                  orderID: data.orderID
                })
              });
            });
          }
      }).render('#paypal-button-container');
}*/


/**
 * Affiche que la commande est bel et bien complétée
 */
/*function commandeTerminee(){
    let modeleComplete= new ModeleMagasin("modele-commande-complete");
    modeleComplete.appliquerModele('', "milieu-page");
    
}*/

