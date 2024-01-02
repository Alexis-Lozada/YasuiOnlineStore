<?php
session_start();
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cve_inv']) && isset($_POST['increment'])) {
    $cve_inv = $_POST['cve_inv'];
    $increment = $_POST['increment'];

    // Asegúrate de que $increment sea un número
    $increment = intval($increment);

    // Realiza la actualización en el carrito
    if (isset($_SESSION['carrito'][$cve_inv])) {
        $_SESSION['carrito'][$cve_inv]['cant_prend'] += $increment;

        // Evita que la cantidad sea mayor que las existencias
        if ($_SESSION['carrito'][$cve_inv]['cant_prend'] > existenciasInventario($cve_inv)) {
            $_SESSION['carrito'][$cve_inv]['cant_prend'] = existenciasInventario($cve_inv);
        }

        // Asegúrate de que la cantidad no sea negativa
        if ($_SESSION['carrito'][$cve_inv]['cant_prend'] == 0) {
            $_SESSION['carrito'][$cve_inv]['cant_prend'] = 1;
        }
    }

    header("Location: ../cart.php");
    exit();
}
?>