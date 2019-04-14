<?php

/**
 * Représente un objet de type GestionBD
 * Son rôle est de gérer la base de données MySQL
 */
abstract class GestionBD {

    /* ATTRIBUTS */
    protected $_bdd;
    private $_nomBD = 'magasin_en_ligne';
    private $_utilisateur = 'webdev';
    private $_mdp = 'toto99';

    /**
     * CONSTRUCTEUR : instanciation de l'objet
     * @param {string} $nomBD - le nom de la base de données
     * @param {string} $utilisateur - l'utilisateur
     * @param {string} $mdp - le mot de passe
     */
    public function __construct() {
        $this->connexionBD();
    }

    /**
     * Se connecte à la base de données
     * @param {string} $nomBD - le nom de la base de données
     * @param {string} $utilisateur - l'utilisateur
     * @param {string} $mdp - le mot de passe
     */
    public function connexionBD() {

        $nsd = 'mysql:host=localhost;dbname='.$this->_nomBD.';charset=utf8';

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->_bdd = new PDO($nsd, $this->_utilisateur, $this->_mdp, $options);
        } 
        catch (PDOException $e) {
            error_log('Message : ' . $e->getMessage() . "\t Code : " . (int)$e->getCode(). "\n" , 3, 'erreurs.txt');
            exit;
        }

    }

}

?>