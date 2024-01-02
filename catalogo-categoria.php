<?php
    session_start();
    include ('php/functions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title> Catálogo </title>

    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header class="bg-white fixed-top border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-2 d-flex justify-content-center">
                    <a href="index.php"
                        class="d-flex align-items-center my-md-2 my-lg-0 me-lg-auto text-black text-decoration-none">
                        <h1 class=""> YASUI </h1>
                    </a>
                </div>
                <!-- Contenido de la columna derecha (col-10) -->
                <nav class="navbar p-0 col-10 d-flex align-items-center justify-content-md-end">
                    <ul class="nav text-black">
                        <li class="nav-item">
                            <div class="dropdown">
                                <button class="btn btn-black bg-white dropdown-toggle" type="button" id="categoriasDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Categorías
                                </button>
                                <div class="dropdown-menu" aria-labelledby="categoriasDropdown">
                                    <a class="dropdown-item" href="php/search.php?sucursal=<?php echo $_GET['sucursal']; ?>&categoria=1">Camisetas</a>
                                    <a class="dropdown-item" href="php/search.php?sucursal=<?php echo $_GET['sucursal']; ?>&categoria=2">Pantalones</a>
                                    <a class="dropdown-item" href="php/search.php?sucursal=<?php echo $_GET['sucursal']; ?>&categoria=3">Vestidos</a>
                                    <a class="dropdown-item" href="php/search.php?sucursal=<?php echo $_GET['sucursal']; ?>&categoria=4">Sudaderas</a>
                                    <a class="dropdown-item" href="php/search.php?sucursal=<?php echo $_GET['sucursal']; ?>&categoria=5">Chaquetas</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <form class="form-inline mx-2 d-none d-md-flex" action="php/search.php" method="GET" onsubmit="return validateSearchForm('search_query');">
                                <div class="input-group mb-0">
                                <input type="hidden" name="sucursal" value="<?php echo $_GET['sucursal']; ?>">
                                <input type="hidden" name="categoria" value="<?php echo $_GET['categoria']; ?>">
                                    <input type="text" class="form-control" name="search_query" id="search_query" placeholder="Buscar" aria-label="Buscar" aria-describedby="button-addon2">
                                    <button class="btn btn-dark" type="submit" id="button-addon2">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </li>                        
                        <li class="nav-item">
                            <a href="login.php" class="nav-link text-black">
                                <i class="bi bi-person"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cart.php" class="nav-link text-black">
                                <i class="bi bi-cart"></i>
                            </a>
                        </li>
                        <li class="nav-item d-none">
                            <a href="#" class="nav-link text-black">
                                <i class="bi bi-heart"></i>
                            </a>
                        </li>
                        <?php
                        if (isset($_SESSION['admin'])) {
                            // Este contenido se mostrará solo a los administradores
                            echo '
                                <li class="nav-item">
                                    <a href="dashboard-inicio.php" class="nav-link text-black">
                                        <i class="bi bi-graph-up blue-icon"></i>
                                        <span class="d-none d-lg-inline">Dashboard</span>
                                    </a>
                                </li>
                            ';
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="space-header"></div>

    <div class="container">
        <form class="form-inline mx-2 d-block d-md-none px-5 mt-5" action="php/search.php" method="GET" onsubmit="return validateSearchForm('search_query2');">
            <div class="input-group mb-0">
            <input type="hidden" name="sucursal" value="<?php echo $_GET['sucursal']; ?>">
            <input type="hidden" name="categoria" value="<?php echo $_GET['categoria']; ?>">
                <input type="text" class="form-control" name="search_query" id="search_query2" placeholder="Buscar" aria-label="Buscar" aria-describedby="button-addon2">
                <button class="btn btn-dark" type="submit" id="button-addon3">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    <section class="my-5">
        <div class="container">
            <div class="row g-2">

                <!-- Inserción de Productos Por Categoria -->

                <?php
                    $registrosEncontrados = 0;

                    if (isset($_GET['sucursal']) && isset($_GET['categoria'])) {
                        $sucursal = $_GET['sucursal'];
                        $categoria = $_GET['categoria'];

                        if (isset($_GET['search_query'])) {
                            $search_query = $_GET['search_query'];
                            $lista_query = inventarioNombre($sucursal, $categoria, $search_query);
                        } else {
                            $lista_query = inventarioCategoria($sucursal, $categoria);
                        }

                        while ($row = mysqli_fetch_array($lista_query)) {
                            $registrosEncontrados++;
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
                    }

                    if ($registrosEncontrados === 0) {
                        echo '<div class="text-center mt-5">';
                        echo '<i class="bi bi-exclamation-circle text-warning fs-2"></i>';
                        echo '<p class="text-warning mt-2">No se encontraron coincidencias.</p>';
                        echo '</div>';
                    }

                ?>

            </div>
        </div>
    </section>
    
    <?php include "site/footer.php" ?>

    <script>
        function validateSearchForm(searchQueryId) {
            var searchQuery = document.getElementById(searchQueryId).value;

            if (searchQuery.trim() === "") {
                return false; // Evita el envío del formulario
            }

            return true; // Permite el envío del formulario
        }
    </script>

</body>

</html>