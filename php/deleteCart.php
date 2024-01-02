<?php
    session_start();
    $cve_inv = $_GET['cve_inv'];

    
    unset($_SESSION['carrito'][$cve_inv]);
    header("Location: ../cart.php");
?>