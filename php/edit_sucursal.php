<?php
    include 'connection.php';

    $cod_suc =  $_GET['cod_suc'];
    $nom_suc = $_GET['nom_suc'];
    $cve_mun = $_GET['cve_mun'];
    $col_suc = $_GET['col_suc'];
    $call_suc = $_GET['call_suc'];
    $ne_suc = $_GET['ne_suc'];
    $ni_suc = $_GET['ni_suc'];
    $cp_suc = $_GET['cp_suc'];

    $actualizar_sucursal = "UPDATE sucursal 
            SET nom_suc = '$nom_suc', cve_mun = '$cve_mun', col_suc = '$col_suc', call_suc = '$call_suc', ne_suc = '$ne_suc', ni_suc = '$ni_suc', cp_suc = '$cp_suc'
            WHERE cod_suc = $cod_suc";

    if (mysqli_query($connection, $actualizar_sucursal)) {
        header("Location: ../crud-sucursales.php");
    }
    
    mysqli_close($connection);
?>