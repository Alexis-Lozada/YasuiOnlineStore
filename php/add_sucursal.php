<?php
    include 'connection.php';

    $nom_suc = $_GET['nom_suc'];
    $cve_mun = $_GET['cve_mun'];
    $col_suc = $_GET['col_suc'];
    $call_suc = $_GET['call_suc'];
    $ne_suc = $_GET['ne_suc'];
    $ni_suc = $_GET['ni_suc'];
    $cp_suc = $_GET['cp_suc'];

    $query_sucursal = "INSERT INTO sucursal(nom_suc, cve_mun, col_suc, call_suc, ne_suc, ni_suc, cp_suc, status_suc)
                       VALUES('$nom_suc', '$cve_mun', '$col_suc', '$call_suc', '$ne_suc', '$ni_suc', '$cp_suc', 1)";

    $execute = mysqli_query($connection, $query_sucursal);

    if ($execute) {
        header("Location: ../crud-sucursales.php");
    } else {
        echo '
            <script>
                alert("Registro Fallido");
                window.location = "../crud-sucursal.php";
            </script>
        ';
    }
?>