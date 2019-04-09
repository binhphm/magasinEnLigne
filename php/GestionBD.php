<?php

/**
 * Représente un objet de type GestionBD
 * Son rôle est de gérer la base de données MySQL
 */
abstract class GestionBD {

    /* ATTRIBUT */
    protected $_bdd;

    /**
     * CONSTRUCTEUR : instanciation de l'objet
     * @param {string} $nomBD - le nom de la base de données
     * @param {string} $utilisateur - l'utilisateur
     * @param {string} $mdp - le mot de passe
     */
    public function __construct($nomBD, $utilisateur, $mdp) {
        $this->connexionBD($nomBD, $utilisateur, $mdp);
    }

    /**
     * Se connecte à la base de données
     * @param {string} $nomBD - le nom de la base de données
     * @param {string} $utilisateur - l'utilisateur
     * @param {string} $mdp - le mot de passe
     */
    public function connexionBD($nomBD, $utilisateur, $mdp) {

        $nsd = "mysql:host=localhost;dbname=$nomBD;charset=utf8";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->_bdd = new PDO($nsd, $utilisateur, $mdp, $options);
        } 
        catch (PDOException $e) {
            error_log('Message : ' . $e->getMessage() . "\t Code : " . (int)$e->getCode(). "\n" , 3, "erreurs.txt");
            exit;
        }

    }

}

?>