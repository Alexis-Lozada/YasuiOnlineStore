<?php
    session_start();
    include 'functions.php';

    $search_sucursal = $_POST['search_sucursal'];
    $_SESSION['search_sucursal'] = $search_sucursal;

    $lista_query = searchSucursal($_SESSION['search_sucursal']);
    if (mysqli_num_rows($lista_query) == 0) {
        $_SESSION['message'] = "No se encontró ningún resultado";
    }

    header("Location: ../crud-sucursales.php");
?>