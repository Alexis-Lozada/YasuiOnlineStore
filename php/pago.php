<?php
    session_start();
    include('connection.php');

    $imp_pago = $_GET['imp_pago'];
    $tipo_pago = "paypal";


    // Obtener el número de cliente
    $no_clie_query = mysqli_fetch_assoc(mysqli_query($connection, "SELECT no_clie FROM cliente WHERE nom_us = '" . $_SESSION['cliente']['nom_us'] . "'"));
    $no_clie = $no_clie_query['no_clie'];

    // Insert en la tabla VENTA
    $query_venta = "INSERT INTO venta(no_clie, fec_vta) VALUES($no_clie, now())";
    $resultado_venta = mysqli_query($connection, $query_venta);

    // Obtener el ID de la venta insertada
    $no_vta = mysqli_insert_id($connection);
    $_SESSION['no_vta'] = $no_vta;
    
    // Insertar en la tabla PAGO
    $pago_query = "INSERT INTO pago (no_vta, imp_pago, fec_pago, tipo_pago) VALUES ('$no_vta', '$imp_pago', NOW(), '$tipo_pago')";
    $resultado_pago = mysqli_query($connection, $pago_query);
    
    foreach ($_SESSION['carrito'] as $cve_inv => $producto) {
        $cant_prend = $producto['cant_prend'];
    
        // Inserción en la tabla VEN_INV
        $ven_inv_query = "INSERT INTO ven_inv (no_vta, cve_inv, cant_prend) VALUES ('$no_vta', '$cve_inv', '$cant_prend')";
        $resultado_ven_inv = mysqli_query($connection, $ven_inv_query);
    }

    // Limpiar el carrito después de realizar las inserciones
    $_SESSION['factura'] = $_SESSION['carrito'];
    unset($_SESSION['carrito']);

    // Variable de sesión para indicar que se ha realizado la compra
    $_SESSION['compra_realizada'] = true;

    header("Location: ../cart.php");
    
?>