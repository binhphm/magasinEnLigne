class ModeleMagasin {

    constructor(idModele) {
        this.modele = document.getElementById(idModele).innerHTML;
    }

    appliquerModele(txtJSON, idElement) {
        let objJSON = JSON.parse(txtJSON);
        let codeHTML = "";

        for(let i = 0; i < objJSON.length; i++) {
            let modeleTemp = this.modele;
            //Si on affiche la liste d'articles, on ajoute un "retour à la ligne" après 4 articles
            if((idElement == "liste-articles") && (i % 4 == 0)){
                codeHTML += "<div class='w-100'></div>";
            }
            for(let a in objJSON[i]) {
                modeleTemp = modeleTemp.replace(new RegExp("\{" + a + "\}", "g"), objJSON[i][a]);
            }
            codeHTML += modeleTemp;
        }

        document.getElementById(idElement).innerHTML = codeHTML;
    }
}