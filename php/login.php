<?php
    session_start();
    include 'connection.php';

    $user     = $_GET['identificador'];
    $password = $_GET['password'];

    $query_customer = "SELECT * FROM usuario, cliente
                       WHERE usuario.nom_us=cliente.nom_us AND (usuario.nom_us='$user' OR email_clie='$user') AND pass_us=aes_encrypt('$password', 'pichula') AND tipo_us=1";

    $query_admin    = "SELECT nom_us, pass_us, tipo_us, status_us FROM usuario WHERE nom_us='$user' AND pass_us=aes_encrypt('$password', 'pichula') AND tipo_us=0";


    $customer_result = mysqli_query($connection, $query_customer);
    $admin_result    = mysqli_query($connection, $query_admin);


    if (mysqli_num_rows($customer_result) == 1) {
        $row = mysqli_fetch_assoc($customer_result);

        if ($row['status_us'] == 0) {
            session_destroy();
            header("Location: ../login.php?error=cuenta_deshabilitada");
            exit();
        }

        $row_est = mysqli_fetch_assoc(mysqli_query($connection, "SELECT estado.cve_est FROM cliente, municipio, estado WHERE estado.cve_est=municipio.cve_est AND municipio.cve_mun=cliente.cve_mun AND nom_us='" . $row['nom_us'] . "'"));

        $_SESSION['cliente'] = array(
            'nom_us'     =>   $row['nom_us'],
            'pass_us'    =>   $password,
            'tipo_us'    =>   $row['tipo_us'],
            'status_us'  =>   $row['status_us'],

            'n1_clie'    =>   $row['n1_clie'],
            'ap_clie'    =>   $row['ap_clie'],
            'am_clie'    =>   $row['am_clie'],
            'email_clie' =>   $row['email_clie'],
            'tel_clie'   =>   $row['tel_clie'],

            'cve_est'    =>   $row_est['cve_est'],
            'cve_mun'    =>   $row['cve_mun'],
            'col_clie'   =>   $row['col_clie'],
            'call_clie'  =>   $row['call_clie'],
            'ne_clie'    =>   $row['ne_clie'],
            'ni_clie'    =>   $row['ni_clie'],
            'cp_clie'    =>   $row['cp_clie'],

            'razs_clie'  =>   $row['razs_clie'],
            'rfc_clie'   =>   $row['rfc_clie'],
            'regf_clie'  =>   $row['regf_clie'],
            'cfdi_clie'  =>   $row['cfdi_clie'],
        );
        header("Location: ../index.php");
        exit();

    } elseif (mysqli_num_rows($admin_result) == 1) {
        $row = mysqli_fetch_assoc($admin_result);

        if ($row['status_us'] == 0) {
            session_destroy();
            header("Location: ../login.php?error=cuenta_deshabilitada");
            exit();
        }

        $_SESSION['admin'] = array(
            'nom_us'     =>   $row['nom_us'],
            'pass_us'    =>   $password,
            'tipo_us'    =>   $row['tipo_us'],
            'status_us'  =>   $row['status_us']
        );
        header("Location: ../index.php");
        exit();

    } else {
        header("Location: ../login.php?error=user_not_found");
        exit();
    }

?>