<?php
    session_start();
    include 'connection.php';

    $cve_inv    = $_GET['cve_inv'];
    $exist_pren = $_GET['exist_pren'];

    $edit_inventario = "UPDATE inventario SET exist_pren='$exist_pren' WHERE cve_inv='$cve_inv' ";
    $execute = mysqli_query($connection, $edit_inventario);
    header("LOcation: ../crud-inventarios.php");
?>