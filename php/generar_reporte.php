<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        include 'connection.php';
        include 'functions.php';

        $tipo_reporte = $_POST['tipo_reporte'];

        switch ($tipo_reporte) {
            case 1:
                $fecha_inicio = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_fin'];
                $cod_suc = $_POST['cod_suc'];

                echo $cod_suc;


                break;

            case 2:
                $cliente = $_POST['cliente'];
                break;

            case 3:
                $nom_pren = $_POST['nom_pren'];
                $tall_pren = $_POST['tall_pren'];
                $cos_suc = $_POST['cos_suc'];
                break;

        }
    }
    
?>