<?php
    session_start();
    include 'connection.php';

    $nom_us    =  $_GET['nom_us'];
    $pass_us   =  $_GET['pass_us'];
    $tipo_us   =  $_GET['tipo_us'];

    $n1_clie   =  $_GET['n1_clie'];
    $ap_clie   =  $_GET['ap_clie'];
    $am_clie   =  $_GET['am_clie'];
    $email_clie=  $_GET['email_clie'];
    $pass_cf   =  $_GET['pass_cf'];

    //Validaciones
    $unique_nom_us = mysqli_query($connection, "SELECT * FROM usuario WHERE nom_us='$nom_us' ");
    if (mysqli_num_rows($unique_nom_us) > 0) {
        $_SESSION['ERROR'] = "Nombre de Usuario en Uso";
        header("Location: ../crud-usuarios.php");
        exit();
    }
    $unique_email_clie = mysqli_query($connection, "SELECT * FROM cliente WHERE email_clie = '$email_clie' ");
    if (mysqli_num_rows($unique_email_clie) > 0) {
        $_SESSION['ERROR'] = "Email en Uso";
        header("Location: ../crud-usuarios.php");
        exit();
    }

    

    $user_query = "INSERT INTO usuario VALUES('$nom_us', '$pass_us', '$tipo_us', 1)";
    $execute = mysqli_query($connection, $user_query);

    if ($tipo_us == 1) {
        $customer_query = "INSERT INTO cliente(nom_us, n1_clie, ap_clie, am_clie, email_clie) 
                           VALUES('$nom_us', '$n1_clie', '$ap_clie', '$am_clie', '$email_clie' )";
        $execute = mysqli_query($connection, $customer_query);
    }


    if ($execute) {
        header("Location: ../crud-usuarios.php");
    } else {
        echo '
            <script>
                alert("Registro Fallido");
                window.location = "../crud-productos.php";
            </script>
        ';
    }
?>