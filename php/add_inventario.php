<?php
    session_start();
    include 'connection.php';

    $cod_suc    = $_POST['cod_suc'];
    $id_pren    = $_POST["id_pren"];
    $exist_pren = $_POST['exist_pren'];

    // Verificar si el Inventario ya existe.
    $verificar_inventario = "SELECT * FROM inventario WHERE cod_suc='$cod_suc' AND id_pren='$id_pren' ";
    $execute = mysqli_query($connection, $verificar_inventario);

    // Si se encuentra un inventario, las existencias que se le agregan a dicho inventario.
    if (mysqli_num_rows($execute) > 0) {

        //obtener ID del inventario ya existente.
        $obtener_inventario = mysqli_fetch_assoc($execute);
        $cve_inv = $obtener_inventario['cve_inv'];


        $agregar_stock = "UPDATE inventario SET exist_pren=exist_pren + $exist_pren WHERE cve_inv='$cve_inv' ";
        $execute = mysqli_query($connection, $agregar_stock);
        Header("Location: ../crud-inventarios.php");
        exit();

    } else {
        // Si no hay un Inventario existente, se crea uno entonces.

        $crear_inventario = "INSERT INTO inventario (cod_suc, id_pren, exist_pren, status_inv)
                             VALUES ('$cod_suc', '$id_pren', '$exist_pren', 1)";
        $execute = mysqli_query($connection, $crear_inventario);

        Header("Location: ../crud-inventarios.php");
    }

?>