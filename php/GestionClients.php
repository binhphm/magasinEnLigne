<?php
/**
 * Représente un objet de type GestionClients
 * Son rôle est de gérer les clients dans la base de données MySQL
 */
 class GestionClients extends GestionBD {

    /**
     * Vérifie si le client existe déjà
     * @param {string} $courriel - le courriel du client
     * @return boolean
     */
    public function existeDeja($courriel) {
        $requete = $this->_bdd->prepare(
            'SELECT * FROM client WHERE courriel = ?'
        );
        $requete->bindValue(1, $courriel, PDO::PARAM_STR);
        $requete->execute();
        $donnees = $requete->fetch();
        $requete->closeCursor();

        return $donnees != false;
    }

    /**
     * Ajoute un nouveau client
     * @param {Client} $client - un client déjà instancié
     * @return boolean
     */
    public function ajouterClient(Client $client) {

        if(!$this->existeDeja($client->getCourriel())) {
            $requete = $this->_bdd->prepare(
                'INSERT INTO client (nomClient, prenomClient, adresse, ville, province,
                    codePostal, noTel, courriel, pseudo, motDePasse)
                VALUES (:nomClient, :prenomClient, :adresse, :ville, :province,
                    :codePostal, :noTel, :courriel, :pseudo, :motDePasse)'
            );
    
            $requete->bindValue(':nomClient', $client->getNomClient(), PDO::PARAM_STR);
            $requete->bindValue(':prenomClient', $client->getPrenomClient(), PDO::PARAM_STR);
            $requete->bindValue(':adresse', $client->getAdresse(), PDO::PARAM_STR);
            $requete->bindValue(':ville', $client->getVille(), PDO::PARAM_STR);
            $requete->bindValue(':province', $client->getProvince(), PDO::PARAM_STR);
            $requete->bindValue(':codePostal', $client->getCodePostal(), PDO::PARAM_STR);
            $requete->bindValue(':noTel', $client->getNoTel(), PDO::PARAM_STR);
            $requete->bindValue(':courriel', $client->getCourriel(), PDO::PARAM_STR);
            $requete->bindValue(':pseudo', $client->getPseudo(), PDO::PARAM_STR);
            $requete->bindValue(':motDePasse', $client->getMotDePasse(), PDO::PARAM_STR);
    
            $requete->execute();
            $requete->closeCursor();

            return true;
        }

        return false;
        
    }

    /**
     * Modifie un client existant
     * @param {Client} une instance de l'objet Client 
     */
    public function modifierClient(Client $client) {

        $requete = $this->_bdd->prepare(
            'UPDATE client
            SET 
                nomClient = :nomClient,
                prenomClient = :prenomClient,
                adresse = :adresse,
                ville = :ville,
                province = :province,
                codePostal = :codePostal,
                noTel = :noTel,
                pseudo = :pseudo,
                motDePasse = :motDePasse,
                courriel = :courriel,
                pseudo = :pseudo,
                motDePasse = :motDePasse
            WHERE noClient = :noClient'
        );

        $requete->bindValue(':nomClient', $client->getNomClient(), PDO::PARAM_STR);
        $requete->bindValue(':prenomClient', $client->getPrenomClient(), PDO::PARAM_STR);
        $requete->bindValue(':adresse', $client->getAdresse(), PDO::PARAM_STR);
        $requete->bindValue(':ville', $client->getVille(), PDO::PARAM_STR);
        $requete->bindValue(':province', $client->getProvince(), PDO::PARAM_STR);
        $requete->bindValue(':codePostal', $client->getCodePostal(), PDO::PARAM_STR);
        $requete->bindValue(':noTel', $client->getNoTel(), PDO::PARAM_STR);
        $requete->bindValue(':pseudo', $client->getPseudo());
        $requete->bindValue(':motDePasse', $client->getMotDePasse());
        $requete->bindValue(':courriel', $client->getCourriel(), PDO::PARAM_STR);
        $requete->bindValue(':pseudo', $client->getPseudo(), PDO::PARAM_STR);
        $requete->bindValue(':motDePasse', $client->getMotDePasse(), PDO::PARAM_STR);

        $requete->execute();
        $requete->closeCursor();

    }


    /**
     * Retourne les informations du client
     * @param {int} noClient - l'identifiant du client
     * @return array - un tableau associatif
     */
    public function getClient($info) {
        $tabClient = array();

        if(is_int($info)){//Il s'agit d'un numéro de client
            $info = (int) $info;
            $requete = $this->_bdd->prepare('SELECT * FROM client WHERE noClient = ?');
            $requete->bindValue(1, $info, PDO::PARAM_INT);
        }
        else {//Sinon, c'est un courriel
            $requete = $this->_bdd->prepare('SELECT * FROM client WHERE courriel = ?');
            $requete->bindValue(1, $info, PDO::PARAM_STR);
        }

        $requete->execute();
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        $requete->closeCursor();
        $client = new Client($donnees);
        array_push($tabClient, $client->getTableau());

        return $tabClient;
    }

    public function getMembre($pseudo, $motDePasse) {
        $tabMembre = array();
        $requete = $this->_bdd->prepare(
            'SELECT * FROM client WHERE pseudo = :pseudo AND motDePasse = :motDePasse'
        );
        $requete->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $requete->bindValue(':motDePasse', $motDePasse, PDO::PARAM_STR);
        $requete->execute();
        
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        $requete->closeCursor();
        $membre = new Client($donnees);
        array_push($tabMembre, $membre->getTableau());

        return $tabMembre;
    }

     /**
     * Récupère les information du dernier client ajouté
     * @return array - un tableau associatif
     */
    public function getDernierClient() {
        $tabClient = array();

        $requete = $this->_bdd->query('SELECT * FROM client ORDER BY noClient DESC LIMIT 1');
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        $requete->closeCursor();
        $client = new Client($donnees);
        array_push($tabClient, $client->getTableau());

        return $tabClient;
    }

}

?>