<?php
    session_start();
    include 'functions.php';

    $search_user = $_POST['search_user'];
    $_SESSION['search_user'] = $search_user;

    $lista_query = searchUsuario($_SESSION['search_user']);
    if (mysqli_num_rows($lista_query) == 0) {
        $_SESSION['message'] = "No se encontró ningún resultado";
    }

    header("Location: ../crud-usuarios.php");
?>