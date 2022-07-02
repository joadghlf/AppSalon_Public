<?php

use Model\ActiveRecord;

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'funciones.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require_once 'database.php';


$db = conectarDB();
ActiveRecord::setDB($db);

//Conección a la base de datos

