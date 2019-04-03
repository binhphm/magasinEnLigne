<?php

$hote = 'localhost';
$nomBD = 'magasin_en_ligne';
$utilisateur = 'root';
$mdp = '';
$charset = 'utf8';

$nsd = "mysql:host=$hote;dbname=$nomBD;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $bdd = new PDO($nsd, $utilisateur, $mdp, $options);
} 
catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

?>