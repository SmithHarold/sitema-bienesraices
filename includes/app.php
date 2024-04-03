<?php
//incluir la funciones
require 'funciones.php';

//incluir la BD
require 'config/database.php';

//incluir el autoload
require __DIR__ . '/../vendor/autoload.php';

$db = conectarDB();
            
use Model\ActiveRecord;

ActiveRecord::setDB($db);


// var_dump($propiedad);    