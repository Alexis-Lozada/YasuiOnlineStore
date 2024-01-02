<?php
    include 'connection.php';

    $id_pren = $_GET['id_pren'];
    $status_pren = $_GET['status_pren'];

    if ($status_pren == 0) {
        $status_pren = 1;
    } else {
        $status_pren = 0;
    }
    
    $baja_prenda = "UPDATE prenda set status_pren='$status_pren' WHERE id_pren='$id_pren' ";
    $execute = mysqli_query($connection, $baja_prenda);

    if ($execute) {
        header("Location: ../crud-productos.php");
        exit();
    }

    mysqli_close($connection);
?>