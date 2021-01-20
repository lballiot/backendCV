<?php

    $parametres = parse_ini_file("param/param.ini");

    // connexion à la bdd avec fichier de paramètres
    $pdo = new PDO(
        $parametres['dsn'],
        $parametres['user'], 
        $parametres['psw']
    );
    // Adresse serveur de l'application 
    $host = $parametres['host'];
?>