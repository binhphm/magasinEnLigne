<?php

/**
 * Représente un objet de type Client
 */
class Client {

    /* ATTRIBUTS */
    private $_noClient;
    private $_nomClient;
    private $_prenomClient;
    private $_adresse
    private $_ville;
    private $_province;
    private $_pays;
    private $_codePostal
    private $_noTel;
    private $_pseudo;
    private $_motDePasse;
    private $_courriel;

    /* CONSTANTES (regex) */
    const LETTRES_SEULEMENT = '/[a-zA-Z]+/';
    const CODE_POSTAL = '/^(?!.*[DFIOQU])[A-VXY][0-9][A-Z] ?[0-9][A-Z][0-9]$/';
    const NO_TEL = '/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/';
    const COURRIEL = '/^[A-Z0-9+_.-]+@[A-Z0-9.-]+$/';

    
    /**
     * CONSTRUCTEUR : crée un objet de type Client
     * @param $donnees - tableau associatif contenant les attributs et leurs valeurs
     */
    public function __construct(array $donnees){
        $this->hydrate($donnees);
    }


    /* ACCESSEURS */
    
    public function getNoClient() {
        return $this->_noClient;
    }

    public function getNomClient() {
        return $this->_nomClient;
    }

    public function getPrenomClient() {
        return $this->_prenomClient;
    }

    public function getAdresse() {
        return $this->_adresse;
    }

    public function getVille() {
        return $this->_ville;
    }

    public function getProvince() {
        return $this->_province;
    }

    public function getPays() {
        return $this->_pays;
    }

    public function getCodePostal() {
        return $this->_codePostal;
    }

    public function getNoTel() {
        return $this->_noTel;
    }

    public function getPseudo() {
        return $this->_pseudo;
    }

    public function getMotDePasse() {
        return $this->_motDePasse;
    }

    public function getCourriel() {
        return $this->_courriel;
    }


    /* MUTATEURS */

    public function setNoClient($noClient) {
        if(!is_int($noClient)){
            trigger_error('Le numéro d\'un client doit être un nombre entier.', E_USER_WARNING);
            return;
        }
        $this->_noClient = $noClient;
    }

    public function setNomClient($nomClient) {
        if(!preg_match(self::LETTRES_SEULEMENT, $nomClient)){
            trigger_error('Le nom du client ne doit contenir que des lettres', E_USER_WARNING);
            return;
        }
        $this->_nomClient = $nomClient;
    }

    public function setPrenomClient($prenomClient) {
        if(!preg_match(self::LETTRES_SEULEMENT, $prenomClient)){
            trigger_error('Le prénom ne doit contenir que des lettrees.', E_USER_WARNING);
            return;
        }
        $this->_prenomClient = $prenomClient;
    }

    public function setAdresse($adresse) {
        if(!is_string($adresse)){
            trigger_error('L\'adresse d\'un client doit être une chaîne de caractères.', E_USER_WARNING);
            return;
        }
        $this->_adresse = $adresse;
    }

    public function setVille($ville) {
        if(!preg_match(self::LETTRES_SEULEMENT, $ville)){
            trigger_error('La ville ne doit contenir que des lettres.', E_USER_WARNING);
            return;
        }
        $this->_ville = $ville;
    }

    public function setProvince($province) {
        if(!preg_match(self::LETTRES_SEULEMENT, $province)){
            trigger_error('La province ne doit contenir que des lettres.', E_USER_WARNING);
            return;
        }
        $this->_province = $province;
    }

    public function setPays($pays) {
        if(!preg_match(self::LETTRES_SEULEMENT, $pays)){
            trigger_error('Le pays ne doit contenir que des lettres.', E_USER_WARNING);
            return;
        }
        $this->_pays = $pays;
    }

    public function setCodePostal($codePostal) {
        if(!preg_match(self::CODE_POSTAL, $codePostal)){
            trigger_error('Format de code postal invalide.', E_USER_WARNING);
            return;
        }
        $this->_codePostal = $codePostal;
    }

    public function setNoTel($noTel) {
        if(!preg_match(self::NO_TEL, $noTel)){
            trigger_error('Format de numéro de téléphone invalide.', E_USER_WARNING);
            return;
        }
        $this->_codePostal = $codePostal;
    }

    public function setPseudo($pseudo) {
        if(!is_string($pseudo)){
            trigger_error('Le pseudonyme d\'un client doit être une chaîne de caractères.', E_USER_WARNING);
            return;
        }
        $this->_pseudo = $pseudo;
    }

    public function setMotDePasse($motDePasse) {
        if(!is_string($motDePasse)){
            trigger_error('Le mot de passe d\'un client doit être une chaîne de caractères.', E_USER_WARNING);
            return;
        }
        $this->_motDePasse = $motDePasse;
    }

    public function setCourriel($courriel) {
        if(!preg_match(self::COURRIEL, $courriel)){
            trigger_error('Format de courriel invalide.', E_USER_WARNING);
            return;
        }
        $this->_courriel = $courriel;
    }


    /* MÉTHODE GÉNÉRALE */

    /**
     * Assigne les bonnes valeurs aux attributs
     * @param $donnes - tableau associatif contenant les attributs et les valeurs
     */
    public function hydrate(array $donnees) {
        foreach ($donnees as $attribut => $valeur) {
            $methode = 'set'.ucfirst($attribut);
            if(method_exists($this, $methode)) {
                $this->$methode($valeur);
            }
        }
    }

}

?>