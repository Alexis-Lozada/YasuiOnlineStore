<?php
    session_start();
    include 'connection.php';

    $nom_us     =  $_SESSION['cliente']['nom_us'];
    $razs_clie  =  $_POST['razs_clie'];
    $rfc_clie   =  $_POST['rfc_clie'];
    $regf_clie  =  $_POST['regf_clie'];
    $cfdi_clie  =  $_POST['cfdi_clie'];


    $adress_query = "UPDATE cliente 
                       SET razs_clie  =  '$razs_clie',
                           rfc_clie   =  '$rfc_clie',
                           regf_clie  =  '$regf_clie',
                           cfdi_clie  =  '$cfdi_clie'
                       WHERE nom_us   =  '{$_SESSION['cliente']['nom_us']}' ";

    // Validaciones
    if (empty($razs_clie)) {
        header("Location: ../account.php?page=factura_electronica&error=razs_invalido");
        exit();
    }

    if (strlen($rfc_clie) != 13) {
        header("Location: ../account.php?page=factura_electronica&error=rfc_invalido");
        exit();
    }

    if (empty($regf_clie)) {
        header("Location: ../account.php?page=factura_electronica&error=regf_invalido");
        exit();
    }

    if (empty($cfdi_clie)) {
        header("Location: ../account.php?page=factura_electronica&error=cfdi_invalido");
        exit();
    }

    if (mysqli_query($connection, $adress_query)) {
        $_SESSION['cliente'] = array(
            // Mi Perfil
            'n1_clie'    =>   isset($_SESSION['cliente']['n1_clie']) ? $_SESSION['cliente']['n1_clie'] : null,
            'ap_clie'    =>   isset($_SESSION['cliente']['ap_clie']) ? $_SESSION['cliente']['ap_clie'] : null,
            'am_clie'    =>   isset($_SESSION['cliente']['am_clie']) ? $_SESSION['cliente']['am_clie'] : null,
            'email_clie' =>   isset($_SESSION['cliente']['email_clie']) ? $_SESSION['cliente']['email_clie'] : null,
            'nom_us'     =>   isset($_SESSION['cliente']['nom_us']) ? $_SESSION['cliente']['nom_us'] : null,
            'tel_clie'   =>   isset($_SESSION['cliente']['tel_clie']) ? $_SESSION['cliente']['tel_clie'] : null,
            'pass_us'    =>   isset($_SESSION['cliente']['pass_us']) ? $_SESSION['cliente']['pass_us'] : null,
            // Mi Dirección
            'cve_est'    =>   isset($_SESSION['cliente']['cve_est']) ? $_SESSION['cliente']['cve_est'] : null,
            'cve_mun'    =>   isset($_SESSION['cliente']['cve_mun']) ? $_SESSION['cliente']['cve_mun'] : null,
            'col_clie'   =>   isset($_SESSION['cliente']['col_clie']) ? $_SESSION['cliente']['col_clie'] : null,
            'call_clie'  =>   isset($_SESSION['cliente']['call_clie']) ? $_SESSION['cliente']['call_clie'] : null,
            'ne_clie'    =>   isset($_SESSION['cliente']['ne_clie']) ? $_SESSION['cliente']['ne_clie'] : null,
            'ni_clie'    =>   isset($_SESSION['cliente']['ni_clie']) ? $_SESSION['cliente']['ni_clie'] : null,
            'cp_clie'    =>   isset($_SESSION['cliente']['cp_clie']) ? $_SESSION['cliente']['cp_clie'] : null,
            // Factura Electrónica
            'razs_clie'  =>   $razs_clie,
            'rfc_clie'   =>   $rfc_clie,
            'regf_clie'  =>   $regf_clie,
            'cfdi_clie'  =>   $cfdi_clie,
        );
        header("Location: ../account.php?page=factura_electronica");
    }
    
    mysqli_close($connection);
?>