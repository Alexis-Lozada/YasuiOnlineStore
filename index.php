<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title> Tienda de ropa - Yasui </title>

    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "site/header.php" ?>

    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicadores -->
        <ol class="carousel-indicators list-unstyled">
            <li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#myCarousel" data-bs-slide-to="1"></li>
            <li data-bs-target="#myCarousel" data-bs-slide-to="2"></li>
        </ol>

        <!-- Slides del carrusel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/img/hero_1_.jpg" alt="Imagen 1">
                <div class="carousel-caption">
                    <h3>Slide 1</h3>
                    <p>Descripción del primer slide.</p>
                    <a href="#" class="btn btn-outline-light  btn-md mt-2 rounded-0 d-none d-sm-block">Comprar ahora</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/hero_2_.jpg" alt="Imagen 2">
                <div class="carousel-caption">
                    <h3>Slide 2</h3>
                    <p>Descripción del segundo slide.</p>
                    <a href="#" class="btn btn-outline-light  btn-md mt-2 rounded-0 d-none d-sm-block">Comprar ahora</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/hero_3_.jpg" alt="Imagen 3">
                <div class="carousel-caption">
                    <h3>Slide 3</h3>
                    <p>Descripción del tercer slide.</p>
                    <a href="#" class="btn btn-outline-light  btn-md mt-2 rounded-0 d-none d-sm-block">Comprar ahora</a>
                </div>
            </div>
        </div>

        <!-- Controles de navegación -->
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </a>
    </div>

    <section class="my-5">
        <h2 class="text-center mb-4"> Productos Destacados </h2>
        <div class="container">
            <div class="row g-2">

                <!-- Inserción de Productos Más Vendidos -->

                <?php
                    $lista_query = productosTop();

                    while ($row = mysqli_fetch_array($lista_query)) {

                        echo '
                        <div class="col-6 col-md-3 text-center">
                            <div class="bg-light">
                                <a href="producto.php?cve_inv='.$row["cve_inv"].'"> <img src="'.$row["img_pren"].'" class="w-100"> </a>
                                <h3 class="fs-6 my-3 mx-3 text-start"> <a href="producto.php?cve_inv='.$row["cve_inv"].'"> '.$row["nom_pren"].' </a> </h3>
                                <p class="fs-6 pb-3 mx-3 text-start">
                                <span>$MXN '.$row['prec_pren'].'</span>
                                </p>
                            </div>
                        </div>
                        ';
                    }
                ?>
                
            </div>
        </div>
    </section>
    
    <?php include "site/footer.php" ?>
</body>

</html>