<?php
    session_start();
    include 'connection.php';

    
    $nom_us      = $_POST['nom_us'];
    $pass_us     = $_POST['pass_us'];
    $pass_cf     = $_POST['pass_cf'];


    if (isset($_SESSION['cliente'])) {

    $n1_clie     = $_POST['n1_clie'];
    $ap_clie     = $_POST['ap_clie'];
    $am_clie     = $_POST['am_clie'];
    $email_clie  = $_POST['email_clie'];
    $tel_clie    = $_POST['tel_clie'];

    $customer_query = "UPDATE cliente, usuario 
                       SET cliente.n1_clie     = '$n1_clie',
                           cliente.ap_clie     = '$ap_clie',
                           cliente.am_clie     = '$am_clie',
                           cliente.email_clie  = '$email_clie',
                           cliente.tel_clie    = '$tel_clie',
                           usuario.nom_us      = '$nom_us',
                           usuario.pass_us     = '$pass_us'
                       WHERE usuario.nom_us = cliente.nom_us 
                       AND   usuario.nom_us = '{$_SESSION['cliente']['nom_us']}'";

    // Validaciones
    if (empty($n1_clie) || strlen($n1_clie) < 3) {
        header("Location: ../account.php?error=nombre_invalido");
        exit();
    }

    if (empty($ap_clie) || strlen($ap_clie) < 3) {
        header("Location: ../account.php?error=apellido_paterno_invalido");
        exit();
    }
    
    if (empty($am_clie) || strlen($am_clie) < 3) {
        header("Location: ../account.php?error=apellido_materno_invalido");
        exit();
    }

    $unique_email = mysqli_query($connection, "SELECT * FROM cliente WHERE email_clie = '$email_clie' AND email_clie != '{$_SESSION['cliente']['email_clie']}' ");
    if (mysqli_num_rows($unique_email) > 0) {
        header("Location: ../account.php?error=email_duplicado");
        exit();
    }
    if (empty($email_clie)) {
        header("Location: ../account.php?error=email_vacio");
        exit();
    }

    $unique_nom_us = mysqli_query($connection, "SELECT * FROM usuario WHERE nom_us = '$nom_us' AND nom_us != '{$_SESSION['cliente']['nom_us']}' ");
    if (mysqli_num_rows($unique_nom_us) > 0) {
        header("Location: ../account.php?error=usuario_duplicado");
        exit();
    }
    if (strlen($nom_us) < 6) {
        header("Location: ../account.php?error=usuario_invalido");
        exit();
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $nom_us)) {
        header("Location: ../account.php?error=caracteres_invalidos");
        exit();
    }

    if (!empty($tel_clie) && strlen($tel_clie) != 10) {
        header("Location: ../account.php?error=tel_invalido");
        exit();
    }

    // Validación de contraseñas
    if ($pass_us !== $pass_cf) {
        header("Location: ../account.php?error=contrasena_no_coincide");
        exit();
    } else {
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@#$%&*.])/', $pass_us)) {
            header("Location: ../account.php?error=contrasena_invalida");
            exit();
        }
    }




    if (mysqli_query($connection, $customer_query)) {
        $_SESSION['cliente'] = array(
            // Mi Perfil
            'n1_clie'    =>   $n1_clie,
            'ap_clie'    =>   $ap_clie,
            'am_clie'    =>   $am_clie,
            'email_clie' =>   $email_clie,
            'nom_us'     =>   $nom_us,
            'tel_clie'   =>   $tel_clie,
            'pass_us'    =>   $pass_us,
            // Mi Dirección
            'cve_est'    =>   isset($_SESSION['cliente']['cve_est'])   ?  $_SESSION['cliente']['cve_est'] : null,
            'cve_mun'    =>   isset($_SESSION['cliente']['cve_mun'])   ?  $_SESSION['cliente']['cve_mun'] : null,
            'col_clie'   =>   isset($_SESSION['cliente']['col_clie'])  ?  $_SESSION['cliente']['col_clie'] : null,
            'call_clie'  =>   isset($_SESSION['cliente']['call_clie']) ?  $_SESSION['cliente']['call_clie'] : null,
            'ne_clie'    =>   isset($_SESSION['cliente']['ne_clie'])   ?  $_SESSION['cliente']['ne_clie'] : null,
            'ni_clie'    =>   isset($_SESSION['cliente']['ni_clie'])   ?  $_SESSION['cliente']['ni_clie'] : null,
            'cp_clie'    =>   isset($_SESSION['cliente']['cp_clie'])   ?  $_SESSION['cliente']['cp_clie'] : null,
            // Factura Electrónica
            'razs_clie'  =>   isset($_SESSION['cliente']['razs_clie']) ?  $_SESSION['cliente']['razs_clie'] : null,
            'rfc_clie'   =>   isset($_SESSION['cliente']['rfc_clie'])  ?  $_SESSION['cliente']['rfc_clie'] : null,
            'regf_clie'  =>   isset($_SESSION['cliente']['regf_clie']) ?  $_SESSION['cliente']['regf_clie'] : null,
            'cfdi_clie'  =>   isset($_SESSION['cliente']['cfdi_clie']) ?  $_SESSION['cliente']['cfdi_clie'] : null,
        );
        header("Location: ../account.php");
    }
    
    } else {
        $admin_query = "UPDATE usuario 
                        SET nom_us      = '$nom_us',
                            pass_us     = '$pass_us'
                        WHERE usuario.nom_us = '{$_SESSION['admin']['nom_us']}'";


        // Validaciones
        $unique_nom_us = mysqli_query($connection, "SELECT * FROM usuario WHERE nom_us = '$nom_us' AND nom_us != '{$_SESSION['admin']['nom_us']}' ");
        if (mysqli_num_rows($unique_nom_us) > 0) {
            header("Location: ../account.php?error=usuario_duplicado");
            exit();
        }
        if (strlen($nom_us) < 6) {
            header("Location: ../account.php?error=usuario_invalido");
            exit();
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $nom_us)) {
            header("Location: ../account.php?error=caracteres_invalidos");
            exit();
        }

        // Validación de contraseñas
        if ($pass_us !== $pass_cf) {
            header("Location: ../account.php?error=contrasena_no_coincide");
            exit();
        } else {
            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@#$%&*.])/', $pass_us)) {
                header("Location: ../account.php?error=contrasena_invalida");
                exit();
            }
        }

        if (mysqli_query($connection, $admin_query)) {
            $_SESSION['admin'] = array(
                'nom_us'     =>   $nom_us,
                'pass_us'    =>   $pass_us,
                'tipo_us'    =>   0,
                'status_us'  =>   1
            );
            header("Location: ../account.php");
        }
    }
?>