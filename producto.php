<?php
    session_start();
    include 'php/connection.php';
    $cve_inv = $_GET['cve_inv'];

    $query_pren = "SELECT sucursal.cod_suc, cve_inv, prenda.id_pren, nom_suc, marca.cve_marca, nom_marca, cve_tipo, nom_pren, tall_pren, prec_pren, cto_pren, desc_pren, status_pren, img_pren, exist_pren FROM marca, prenda, inventario, sucursal WHERE sucursal.cod_suc=inventario.cod_suc AND marca.cve_marca=prenda.cve_marca AND prenda.id_pren=inventario.id_pren AND cve_inv='$cve_inv'";
    $result_pren = $connection->query($query_pren);

    if ($result_pren->num_rows > 0) {
        // Obtener los datos de la prenda
        $row_pren = $result_pren->fetch_assoc();
        $id_pren = $row_pren['id_pren'];
        $desc_pren = $row_pren['desc_pren'];
        $prec_pren = $row_pren['prec_pren'];
        $img_pren = $row_pren['img_pren'];
        $nom_pren = $row_pren['nom_pren'];
        $exist_pren = $row_pren['exist_pren'];
        $tall_pren = $row_pren['tall_pren'];
        $nom_marca = $row_pren['nom_marca'];
        $cod_suc = $row_pren['cod_suc'];
        $nom_suc = $row_pren['nom_suc'];

        // Liberar el resultado
        $result_pren->free_result();
    } else {
        echo "No se encontraron resultados para el ID de prenda proporcionado.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title> Login - Yasui </title>

    <link href="assets/css/styless.css" rel="stylesheet">

    <style>
        .col-12 img {
    max-width: 100%;
    height: auto;
}
    </style>

    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "site/header.php" ?>

    <div class="space-header"></div>

    <div class="container space-header forms-container">
        <div class="row">
            <div class="col-md-2 col-lg-1"></div>

            <div class="col-12 col-md-8 col-lg-10">

                <div class="row g-5">
                    <div class="col-12 col-md-6 col-lg-6 px-5">
                        <img src="<?php echo $row_pren['img_pren']; ?>" alt="">
                    </div>

                    <div class="col-12 col-md-6 col-lg-6 px-5">

                        <form action="php/addCart.php" method="POST">

                            <!-- ID de prenda -->
                            <input type="hidden" name="id_pren" value="<?php echo $row_pren['id_pren']; ?>">

                            <!-- Imagen de prenda -->
                            <input type="hidden" name="img_pren" value="<?php echo $row_pren['img_pren']; ?>">

                            <!-- Clave de inventario -->
                            <input type="hidden" name="cve_inv" value="<?php echo $row_pren['cve_inv']; ?>">

                            <!-- Nombre y precio -->
                            <h2><?php echo $row_pren['nom_pren']; ?></h2>
                            <input type="hidden" name="nom_pren" value="<?php echo $row_pren['nom_pren']; ?>">
                            <p class="">$MXN <?php echo $row_pren['prec_pren']; ?></p>
                            <input type="hidden" name="prec_pren" value="<?php echo $row_pren['prec_pren']; ?>">
                            <h6 class="mb-4"><?php echo $row_pren['nom_marca']; ?></h6>

                            <!-- Nombre de Sucursal -->
                            <div class="my-4">
                            <i class="bi bi-shop" style="font-size: 1.5rem; margin-right: 5px;"></i>
                                <span class="ms-2"><?php echo $nom_suc; ?></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Talla:</label>
                                <div class="row g-2 ">
                                    <?php
                                        $lista_tipo = buscarTallas($nom_pren, $cod_suc);
                                        while ($row = mysqli_fetch_array($lista_tipo)) {
                                            echo '<div class="col-4"><a href="producto.php?cve_inv='.$row['cve_inv'].'"><div class="' . ($row['cve_inv'] == $cve_inv ? 'bg-dark text-white' : 'border') . ' p-2 text-center">'.$row['tall_pren'].'</div></a></div>';
                                        }
                                    ?>
                                </div>
                            </div>

                            <!-- Talla de prenda -->
                            <input type="hidden" name="tall_pren" value="<?php echo $row_pren['tall_pren']; ?>">
                            

                            <!-- Descripción de la prenda -->
                            <div class="my-5">
                                <label for="descripcion" class="form-label w-100 ">Descripción:</label>
                                <label id="descripcion" name="dess_pren"><?php echo $row_pren['desc_pren']; ?></label>
                            </div>

                            <!-- Selector de cantidad -->
                            <div class="mb-2 row">
                                <label for="cantidad" class="form-label">Seleccionar Cantidad:</label>
                                <div class="col-5 my-1 mb-4">
                                    <div class="input-group input-group-sm">
                                        <button type="button" class="btn btn-outline-dark" id="decrementBtn" onclick="decrement()">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="number" class="form-control text-center" name="cant_prend" id="quantityInput" value="1" readonly max="1">
                                        <button type="button" class="btn btn-outline-dark" id="incrementBtn" onclick="increment()">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Existencias disponibles -->
                            <div class="mt-2">
                                <?php
                                    $existencias = $row_pren['exist_pren'];
                                    $colorTexto = $existencias > 0 ? 'text-dark' : 'text-danger';
                                ?>
                                <p class="<?php echo $colorTexto; ?>"> <?php echo $existencias; ?> unidades disponbles </p>
                            </div>

                            <?php
                                $sesionClienteDefinida = isset($_SESSION['cliente']);
                                $existenciasDisponibles = $row_pren['exist_pren'] > 0;
                                $botonDeshabilitado = $sesionClienteDefinida && $existenciasDisponibles ? '' : 'disabled';
                                $textoBoton = $existenciasDisponibles ? 'AGREGAR AL CARRITO' : 'NO DISPONIBLE';
                            ?>
                            
                            <!-- Botón para agregar al carrito -->
                            <button type="submit" class="btn btn-dark w-100 rounded-0" <?php echo $botonDeshabilitado; ?>><?php echo $textoBoton; ?></button>

                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-2 col-lg-1"></div>
        </div>
    </div>

    <div class="space-header"></div>

    <!-- Controlador de Cantidad de productos -->
    <script>
    function increment() {
        var inputElement = document.getElementById('quantityInput');
        var currentValue = parseInt(inputElement.value, 10);
        if (currentValue < <?php echo $row_pren['exist_pren'] ?>) {
                inputElement.value = currentValue + 1;
            }
    }

    function decrement() {
        var inputElement = document.getElementById('quantityInput');
        var currentValue = parseInt(inputElement.value, 10);
        if (currentValue > 1) {
            inputElement.value = currentValue - 1;
        }
    }
    </script>
    
</body>
</html>