class RequeteAjax {

    constructor(url){
        this.url = url;
    }

    getJSON(callback) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                callback(this.responseText);
            }
        };
        xhttp.open("GET", this.url, true);
        xhttp.send();
    }

    envoyerDonnees(txtJSON, callback) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                callback(this.responseText);
            }
        };
        xhttp.open("POST", this.url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("x=" + txtJSON);
    }
}