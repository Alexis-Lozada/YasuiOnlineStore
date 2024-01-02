<?php
    session_start();
    include 'connection.php';

    // Manejar la imagen
    $directorio_destino = "../assets/img/";
    $nombre_archivo = basename($_FILES["imagen"]["name"]);
    $ruta_destino = $directorio_destino . $nombre_archivo;

    move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_destino);


    $cve_marca = $_POST['cve_marca'];
    $cve_tipo = $_POST['cve_tipo'];
    $nom_pren = $_POST['nom_pren'];
    $tall_pren = $_POST['tall_pren'];
    $cto_pren = $_POST['cto_pren'];
    $desc_pren = $_POST['desc_pren'];
    $img_pren = "assets/img/".$nombre_archivo;

    $prenda_duplicada = "SELECT * FROM prenda WHERE nom_pren='$nom_pren' AND tall_pren='$tall_pren' ";
    $execute = mysqli_query($connection, $prenda_duplicada);
    $num_rows = mysqli_num_rows($execute);

    if ($num_rows > 0) {
        $_SESSION['ERROR'] = "Producto en existencia";
        header("Location: ../crud-productos.php");
    } else {
        $query_prenda = "INSERT INTO prenda(cve_marca, cve_tipo, nom_pren, tall_pren, cto_pren, desc_pren, status_pren, img_pren)
                       VALUES('$cve_marca', '$cve_tipo', '$nom_pren', '$tall_pren', '$cto_pren', '$desc_pren', 1, '$img_pren')";
        $execute = mysqli_query($connection, $query_prenda);
        header("Location: ../crud-productos.php");
    }
?>