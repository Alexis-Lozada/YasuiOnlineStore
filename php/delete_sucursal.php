<?php
    include 'connection.php';

    $cod_suc = $_GET['cod_suc'];
    $status_suc = $_GET['status_suc'];

    if ($status_suc == 0) {
        $status_suc = 1;
    } else {
        $status_suc = 0;
    }
    
    $baja_sucursal = "UPDATE sucursal set status_suc='$status_suc' WHERE cod_suc='$cod_suc' ";
    $execute = mysqli_query($connection, $baja_sucursal);

    if ($execute) {
        header("Location: ../crud-sucursales.php");
        exit();
    }

    mysqli_close($connection);
?>