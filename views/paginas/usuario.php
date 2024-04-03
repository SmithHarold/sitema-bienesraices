<?php
// importar la conexion 
require 'includes/app.php';
$db = conectarDB();


// crear un email y password_algos
$email = "correo@correo.com";
$password = "123456";

//dos opciones para hashear
// $passwordHash = password_hash($password, PASSWORD_DEFAULT);
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// query para crear el usuario
$query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$passwordHash');";

// echo $query;

// agregarlo a la BD

// $resultado = 
mysqli_query($db, $query);
