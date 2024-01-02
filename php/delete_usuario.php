<?php
    include 'connection.php';

    $nom_us = $_GET['nom_us'];
    $status_us = $_GET['status_us'];

    if ($status_us == 0) {
        $status_us = 1;
    } else {
        $status_us = 0;
    }
    
    $baja_usuario = "UPDATE usuario SET status_us='$status_us' WHERE nom_us='$nom_us' ";
    $execute = mysqli_query($connection, $baja_usuario);

    if ($execute) {
        header("Location: ../crud-usuarios.php");
        exit();
    }

    mysqli_close($connection);
?>