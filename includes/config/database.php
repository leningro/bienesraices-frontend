<?php 

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost','root','root', 'bienesraices-git');

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;
}