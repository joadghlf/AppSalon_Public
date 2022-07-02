<?php

function conectarDB(): mysqli {
    
    $db = new mysqli($_ENV['DB_HOST'],$_ENV['DB_USER'],$_ENV['DB_PASSWORD'],$_ENV['DB_BD']);
    if(!$db){
        echo "Error al tratar de conectar a la base de datos";
        exit;
    }
    $db-> set_charset("utf8");
    return $db;
}