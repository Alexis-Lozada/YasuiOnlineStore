<?php
    include 'connection.php';

    $cve_inv = $_GET['cve_inv'];
    $status_inv = $_GET['status_inv'];

    if ($status_inv == 0) {
        $status_inv = 1;
    } else {
        $status_inv = 0;
    }
    
    $baja_inventario = "UPDATE inventario set status_inv='$status_inv' WHERE cve_inv='$cve_inv' ";
    $execute = mysqli_query($connection, $baja_inventario);

    if ($execute) {
        header("Location: ../crud-inventarios.php");
        exit();
    }

    mysqli_close($connection);
?>