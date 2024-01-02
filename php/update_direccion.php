<?php
    session_start();
    include 'connection.php';

    $nom_us     =  $_SESSION['cliente']['nom_us'];
    $cve_est    =  $_POST['cve_est'];
    $cve_mun    =  $_POST['cve_mun'];
    $col_clie   =  $_POST['col_clie'];
    $call_clie  =  $_POST['call_clie'];
    $ne_clie    =  $_POST['ne_clie'];
    $ni_clie    =  $_POST['ni_clie'];
    $cp_clie    =  $_POST['cp_clie'];

    $adress_query = "UPDATE cliente 
                       SET cve_mun    =  '$cve_mun',
                           col_clie   =  '$col_clie',
                           call_clie  =  '$call_clie',
                           ne_clie    =  '$ne_clie',
                           ni_clie    =  '$ni_clie',
                           cp_clie    =  '$cp_clie'
                       WHERE nom_us   =  '{$_SESSION['cliente']['nom_us']}' ";

    // Validaciones
    if (strlen($col_clie) < 3) {
        header("Location: ../account.php?page=mi_direccion&error=col_invalido");
        exit();
    }

    if (strlen($call_clie) < 3) {
        header("Location: ../account.php?page=mi_direccion&error=call_invalido");
        exit();
    }

    if (empty($ne_clie)) {
        header("Location: ../account.php?page=mi_direccion&error=ne_invalido");
        exit();
    }

    if (empty($ni_clie)) {
        header("Location: ../account.php?page=mi_direccion&error=ni_invalido");
        exit();
    }

    if (strlen($cp_clie) != 5) {
        header("Location: ../account.php?page=mi_direccion&error=cp_invalido");
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
            'cve_est'    =>   $cve_est,
            'cve_mun'    =>   $cve_mun,
            'col_clie'   =>   $col_clie,
            'call_clie'  =>   $call_clie,
            'ne_clie'    =>   $ne_clie,
            'ni_clie'    =>   $ni_clie,
            'cp_clie'    =>   $cp_clie,
            // Factura Electrónica
            'razs_clie'  =>   isset($_SESSION['cliente']['razs_clie']) ?  $_SESSION['cliente']['razs_clie'] : null,
            'rfc_clie'   =>   isset($_SESSION['cliente']['rfc_clie'])  ?  $_SESSION['cliente']['rfc_clie'] : null,
            'regf_clie'  =>   isset($_SESSION['cliente']['regf_clie']) ?  $_SESSION['cliente']['regf_clie'] : null,
            'cfdi_clie'  =>   isset($_SESSION['cliente']['cfdi_clie']) ?  $_SESSION['cliente']['cfdi_clie'] : null,
        );
        header("Location: ../account.php?page=mi_direccion");
    }
    
    mysqli_close($connection);
?>