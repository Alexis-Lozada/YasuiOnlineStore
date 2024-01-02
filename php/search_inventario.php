<?php
    session_start();
    include 'functions.php';

    $search_inventario = $_POST['search_inventario'];
    $_SESSION['search_inventario'] = $search_inventario;

    $lista_query = searchInventario($_SESSION['search_inventario']);
    if (mysqli_num_rows($lista_query) == 0) {
        $_SESSION['message'] = "No se encontró ningún resultado";
    }

    header("Location: ../crud-inventarios.php");
?>