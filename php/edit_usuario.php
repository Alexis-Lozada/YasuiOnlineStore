<?php
    session_start();
    include 'connection.php';

    $old_nom_us = $_POST['old_nom_us'];
    $new_nom_us = $_POST['new_nom_us'];
    $pass_us = $_POST['pass_us'];

    $edit_user = "UPDATE usuario SET nom_us='$new_nom_us', pass_us='$pass_us' WHERE nom_us='$old_nom_us' ";

    //Validaciones
    $unique_nom_us = mysqli_query($connection, "SELECT * FROM usuario WHERE nom_us = '$new_nom_us' AND nom_us != '$old_nom_us' ");
    if (mysqli_num_rows($unique_nom_us) > 0) {
        $_SESSION['ERROR'] = "Nombre de Usuario en Uso";
        header("Location: ../crud-usuarios.php");
        exit();
    }




    
    $execute = mysqli_query($connection, $edit_user);

    // Actualizar Datos de session si el usario editado es uno mismo.
    if ($old_nom_us == $_SESSION['admin']['nom_us']) {
        $execute = mysqli_query($connection, $edit_user);

        $_SESSION['admin'] = array(
            'nom_us'     =>   $new_nom_us,
            'pass_us'    =>   $password,
            'tipo_us'    =>   0,
            'status_us'  =>   1,
        );

        header("Location: ../crud-usuarios.php");
        exit();
    }
    

    header("Location: ../crud-usuarios.php");
    exit();
?>