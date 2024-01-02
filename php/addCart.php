<?php

    // Verifica si el formulario ha sido enviado y si se envió una cantidad del producto por medio del método POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cant_prend'])) {

        include ("connection.php");
        session_start();

        $cant_prend = $_POST['cant_prend'];
        $cve_inv    = $_POST['cve_inv'];
        $id_pren    = $_POST['id_pren'];
        $nom_pren   = $_POST['nom_pren'];
        $img_pren   = $_POST['img_pren'];
        $prec_pren  = $_POST['prec_pren'];
        $tall_pren  = $_POST['tall_pren'];


        // Verifica si la variable de sesión carrito está definida
        if (!isset($_SESSION['carrito'])) {
            // Si no está definida, inicialízala como un array vacío
            $_SESSION['carrito'] = array();
        }

        // Actualiza o agrega al carrito en la sesión
        if (isset($_SESSION['carrito'][$cve_inv])) {
            // Si el inventario ya está en el carrito, actualiza la cantidad
            $_SESSION['carrito'][$cve_inv]['cant_prend'] = $cant_prend;
            
        } else {
            // Si no está en el carrito, agrégalo
            $_SESSION['carrito'][$cve_inv] = array(
                'cant_prend' => $cant_prend,
                'id_pren'    => $id_pren,
                'nom_pren'   => $nom_pren,
                'img_pren'   => $img_pren,
                'prec_pren'  => $prec_pren,
                'tall_pren'  => $tall_pren,
            );
        }

        // Muestra la información del carrito
        Header("Location: ../cart.php");
    }
?>