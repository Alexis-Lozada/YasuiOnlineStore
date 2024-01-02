<?php
    include 'connection.php';
    include 'functions.php';
    
    if (isset($_GET['cve_est'])) {
        $cve_est = $_GET['cve_est'];

        // Llama a la función tablaMunicipio con el valor de $cve_est como argumento
        $lista_tipo = tablaMunicipio($cve_est);

        // Genera la lista de opciones de municipios
        $options = '';
        while ($row = mysqli_fetch_array($lista_tipo)) {
            $options .= '<option value="' . $row['cve_mun'] . '">' . $row['nom_mun'] . '</option>';
        }

        // Devuelve las opciones de municipios como respuesta
        echo $options;
    }
?>