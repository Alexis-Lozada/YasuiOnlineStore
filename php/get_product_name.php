<?php
include 'connection.php';

if (isset($_POST['id_pren'])) {
    $id_pren = $_POST['id_pren'];
    
    // Realiza una consulta para obtener el nombre del producto usando el $id_pren
    $query = "SELECT nom_pren FROM prenda WHERE id_pren = $id_pren";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['nom_pren']; // Devuelve el nombre del producto
    } else {
        echo "Producto no encontrado";
    }
} else {
    echo "ID de prenda no proporcionado";
}
?>