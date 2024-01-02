<?php
    session_start();
    include 'functions.php';

    $search_producto = $_POST['search_producto'];
    $_SESSION['search_producto'] = $search_producto;

    $lista_query = searchProducto($_SESSION['search_producto']);
    if (mysqli_num_rows($lista_query) == 0) {
        $_SESSION['message'] = "No se encontró ningún resultado";
    }

    header("Location: ../crud-productos.php");
?>