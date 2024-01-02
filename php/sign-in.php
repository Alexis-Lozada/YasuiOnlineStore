<?php
    session_start();
    include 'connection.php';

    $n1_clie = $_GET['n1_clie'];
    $ap_clie = $_GET['ap_clie'];
    $am_clie = $_GET['am_clie'];
    $email_clie = $_GET['email_clie'];
    $nom_us = $_GET['nom_us'];
    $pass_us = $_GET['pass_us'];
    $confirm_pass_us = $_GET['confirm_pass_us'];

    $query_usuario = "INSERT INTO usuario(nom_us, pass_us, tipo_us, status_us)
                      VALUES('$nom_us', '$pass_us', 1, 1)";

    $query_cliente = "INSERT INTO cliente(nom_us, n1_clie, ap_clie, am_clie, email_clie)
                      VALUES('$nom_us', '$n1_clie', '$ap_clie', '$am_clie', '$email_clie')";


    // Validaciones
    if (empty($n1_clie) || strlen($n1_clie) < 3) {
        header("Location: ../sign-in.php?error=nombre_invalido&ap_clie=$ap_clie&am_clie=$am_clie&email_clie=$email_clie&nom_us=$nom_us&pass_us=$pass_us");
        exit();
    }

    if (empty($ap_clie) || strlen($ap_clie) < 3) {
        header("Location: ../sign-in.php?error=apellido_paterno_invalido&n1_clie=$n1_clie&am_clie=$am_clie&email_clie=$email_clie&nom_us=$nom_us&pass_us=$pass_us");
        exit();
    }
    
    if (empty($am_clie) || strlen($am_clie) < 3) {
        header("Location: ../sign-in.php?error=apellido_materno_invalido&n1_clie=$n1_clie&ap_clie=$ap_clie&email_clie=$email_clie&nom_us=$nom_us&pass_us=$pass_us");
        exit();
    }

    if (empty($email_clie)) {
        header("Location: ../sign-in.php?error=email_vacio&n1_clie=$n1_clie&ap_clie=$ap_clie&am_clie=$am_clie&nom_us=$nom_us");
        exit();
    }
    $unique_email_clie = mysqli_query($connection, "SELECT * FROM cliente WHERE email_clie = '$email_clie' ");
    if (mysqli_num_rows($unique_email_clie) > 0) {
        header("Location: ../sign-in.php?error=email_duplicado&n1_clie=$n1_clie&ap_clie=$ap_clie&am_clie=$am_clie&email_clie=$email_clie&nom_us=$nom_us");
        exit();
    }

    if (empty($nom_us) || strlen($nom_us) < 6) {
        header("Location: ../sign-in.php?error=nombre_us_invalido&n1_clie=$n1_clie&ap_clie=$ap_clie&am_clie=$am_clie&email_clie=$email_clie&nom_us=$nom_us");
        exit();
    }
    $unique_nom_us = mysqli_query($connection, "SELECT * FROM usuario WHERE nom_us = '$nom_us' ");
    if (mysqli_num_rows($unique_nom_us) > 0) {
        header("Location: ../sign-in.php?error=usuario_duplicado&n1_clie=$n1_clie&ap_clie=$ap_clie&am_clie=$am_clie&email_clie=$email_clie&nom_us=$nom_us");
        exit();
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $nom_us)) {
        header("Location: ../sign-in.php?error=caracteres_invalidos&n1_clie=$n1_clie&ap_clie=$ap_clie&am_clie=$am_clie&email_clie=$email_clie&nom_us=$nom_us");
        exit();
    }

    // Validación de contraseñas
    if ($_GET['pass_us'] !== $_GET['confirm_pass_us']) {
        // Las contraseñas no coinciden
        header("Location: ../sign-in.php?error=contrasena_no_coincide&n1_clie=$n1_clie&ap_clie=$ap_clie&am_clie=$am_clie&email_clie=$email_clie&nom_us=$nom_us");
        exit();
    } else {
        // Verificar si la contraseña cumple con los criterios deseados
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@#$%&*.])/', $_GET['pass_us'])) {
            // La contraseña no cumple con los criterios
            header("Location: ../sign-in.php?error=contrasena_invalida&n1_clie=$n1_clie&ap_clie=$ap_clie&am_clie=$am_clie&email_clie=$email_clie&nom_us=$nom_us");
            exit();
        }
    }


    $execute = mysqli_query($connection, $query_usuario);
    $execute = mysqli_query($connection, $query_cliente);

    if ($execute) {
        $_SESSION['cliente'] = array(
            'nom_us'     =>   $nom_us,
            'n1_clie'    =>   $n1_clie,
            'ap_clie'    =>   $ap_clie,
            'am_clie'    =>   $am_clie,
            'email_clie' =>   $email_clie,
            'pass_us'    =>   $pass_us,
            'tipo_us'    =>   1,
            'status_us'  =>   1
        );
        header("Location: ../index.php");
    } else {
        echo '
            <script>
                alert("Registro Fallido");
                window.location = "../sign-in.php";
            </script>
        ';
    }

    mysqli_close($connection);
?>