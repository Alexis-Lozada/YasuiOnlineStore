<?php 
    include 'php/functions.php';
?>

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
                            <button class="btn btn-black bg-white dropdown-toggle" type="button" id="sucursalDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sucursales
                            </button>
                            <div class="dropdown-menu" aria-labelledby="sucursalDropdown">
                                <?php
                                    $lista_sucursal = tablaSucursalSelect();
                                    while ($row = mysqli_fetch_array($lista_sucursal)) {
                                        if ($row['status_suc'] != 0) {
                                            $nombre_sucursal = $row['nom_suc'];
    
                                            $url = "php/search.php?sucursal={$row['cod_suc']}";
                                            
                                            echo "<a class='dropdown-item' href='$url'>$nombre_sucursal</a>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
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