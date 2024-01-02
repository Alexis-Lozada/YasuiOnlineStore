<?php
    session_start();
    include 'connection.php';

    // Manejar la imagen
    $directorio_destino = "../assets/img/";

    if (isset($_FILES["imagen"])) {
        $nombre_archivo = basename($_FILES["imagen"]["name"]);
        $ruta_destino = $directorio_destino . $nombre_archivo;

        move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_destino);
        $img_pren = "assets/img/".$nombre_archivo;
    }
    
    $id_pren       = $_POST['id_pren'];
    $cve_marca     = $_POST['cve_marca'];
    $cve_tipo      = $_POST['cve_tipo'];
    $nom_pren      = $_POST['nom_pren'];
    $tall_pren     = $_POST['tall_pren'];
    $cto_pren      = $_POST['cto_pren'];
    $desc_pren     = $_POST['desc_pren'];
    

    $prenda_duplicada = "SELECT * FROM prenda WHERE nom_pren='$nom_pren' AND tall_pren='$tall_pren' AND id_pren!='$id_pren' ";
    $execute = mysqli_query($connection, $prenda_duplicada);
    $num_rows = mysqli_num_rows($execute);

    if ($num_rows > 0) {
        $_SESSION['ERROR'] = "Producto en existencia";
        header("Location: ../crud-productos.php");
    } else {

        if (!isset($_FILES["imagen"])) {
            $actualizar_prenda = "UPDATE prenda 
            SET nom_pren = '$nom_pren', tall_pren = '$tall_pren', cto_pren = '$cto_pren', cve_tipo = '$cve_tipo', cve_marca = '$cve_marca', desc_pren = '$desc_pren'
            WHERE id_pren = $id_pren";

            $execute = mysqli_query($connection, $actualizar_prenda);
            header("Location: ../crud-productos.php");
        } else {
            $actualizar_prenda = "UPDATE prenda 
            SET nom_pren = '$nom_pren', tall_pren = '$tall_pren', cto_pren = '$cto_pren', cve_tipo = '$cve_tipo', cve_marca = '$cve_marca', desc_pren = '$desc_pren', img_pren='$img_pren'
            WHERE id_pren = $id_pren";

            $execute = mysqli_query($connection, $actualizar_prenda);
            header("Location: ../crud-productos.php");
        }
    }
?>