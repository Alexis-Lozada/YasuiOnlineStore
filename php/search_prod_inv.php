<?php
    session_start();
    include 'functions.php';

    $search_prod_inv = $_POST['search_prod_inv'];
    $_SESSION['search_prod_inv'] = $search_prod_inv;

    $lista_query = searchProductoInv($_SESSION['search_prod_inv']);
    if (mysqli_num_rows($lista_query) == 0) {
        $_SESSION['message'] = "No se encontró ningún resultado";
    }

    header("Location: ../crud-inventarios-productos.php");
?>