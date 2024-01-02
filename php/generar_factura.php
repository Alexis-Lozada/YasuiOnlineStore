<?php
    session_start();
    include('connection.php');

    // Insert en la tabla FACTURA
    $query_factura = "INSERT INTO factura (no_vta, fec_fac) VALUES ('" . $_SESSION['no_vta'] . "', NOW())";
    $resultado_factura = mysqli_query($connection, $query_factura);

    // Obtener el ID de la factura insertada
    $folio_fac = mysqli_insert_id($connection);
    $_SESSION['folio_fac'] = $folio_fac;

    Header("Location: ../factura.php");
?>