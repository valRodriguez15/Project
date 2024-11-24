<?php
 $host = "localhost";
 $db = "tacktime"; 
 $charset = 'utf8mb4';
 $user = "root";
 $pass = "";

 //Se usa el API de PDO para persistir los datos en las bases de datos mas comunes
 //configuracion de comportamiento por defecto para el API PDO
 //visite esta url para ver las opciones disponibles y lo que significan
 //https://www.php.net/manual/de/pdo.setattribute.php

 $options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
    /*echo "Me he conectado a la base de datos";*/
} catch (PDOException $e) {
  throw new PDOException($e->getMessage(), (int)$e->getCode());
}


?>