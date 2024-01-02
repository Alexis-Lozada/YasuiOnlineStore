<?php
    // Evita HTTP ERROR 500
    ini_set('display_errors', 'on');
    error_reporting(E_ALL); //Todos los errores

    // Datos de conexión a la DB
    $servername = "localhost:3308";
    $username = "admin";
    $password = "Jackerpro11.";
    $database = "yasui";

    $connection = mysqli_connect($servername, $username, $password, $database);
?>