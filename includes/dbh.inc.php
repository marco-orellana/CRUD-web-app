<?php

function access_from_db($sql)
{
    $dbServerName = 'localhost';
    $dbUserName = 'root';
    $dbPassword = '';
    $dbName = 'programmation-web-3';

    $collection = array();

    $mysqli = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);
    if (mysqli_connect_errno()) {
        echo 'Erreur de connection au serveur MySQL: ('.$mysqli->connect_errno.') '.$mysqli->connect_error;
        exit;
    }

    // Spécifier l'encodage par défaut pour tous les accès à la base de données
    mysqli_set_charset($mysqli, 'utf8');

    $result = mysqli_query($mysqli, $sql);
    if (!$result) {
        $error = mysqli_error($mysqli);
        exit($error);
    }
    if ($result instanceof mysqli_result) {
        while ($associativeArray = mysqli_fetch_assoc($result)) {
            array_push($collection, $associativeArray);
        }

        // Libère le résultat de la mémoire
        mysqli_free_result($result);

        // Libère la connection
        mysqli_close($mysqli);
    } else {
        array_push($collection, $result);
    }

    return $collection;
}
