<?php
    include 'php/functions.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include 'php/connection.php';
        

        $tipo_reporte = $_POST['tipo_reporte'];

        switch ($tipo_reporte) {
            case 1:
                $fecha_inicio = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_fin'];
                $cod_suc = $_POST['cod_suc'];

                $lista_query = reporteVenta($fecha_inicio, $fecha_fin, $cod_suc);
                $total_productos = mysqli_num_rows($lista_query);
                break;

            case 2:
                $cliente = $_POST['cliente'];

                $lista_query = reporteCliente($cliente);
                $total_productos = mysqli_num_rows($lista_query);
                break;

            case 3:
                $nom_pren = $_POST['nom_pren'];
                $tall_pren = $_POST['tall_pren'];
                $id_suc = $_POST['id_suc'];

                $lista_query = reporteSucursal($nom_pren, $tall_pren, $id_suc);
                $total_productos = mysqli_num_rows($lista_query);
                break;
            
            case 4:
                $lista_query = stockAgotado(); // Stock Agotado, colocamos este nombre pues es necesario para un switch que ya teniamos.
                $stock_disponible = stockDisponible(); // Stock Disponible

                $total_productos = mysqli_num_rows($lista_query); // Total Inventarios Agotados
                $total_productos2 = mysqli_num_rows($stock_disponible); // Total inventarios Disponibles
                break;

        }
    }
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .sidebar {
            width: 280px;
            float: left;
            height: 100vh; /* 100% de la altura de la ventana */
            position: fixed; /* Barra lateral fija */
            top: 0; /* Se fija en la parte superior */
            left: 0; /* Se fija en el lado izquierdo */
            padding-top: 72px;
        }
        .content {
            margin-left: 300px;
            padding: 20px;
            margin-top: 72px;
        }
        h1 {
            font-family: 'initial', 'sans-serif';
            letter-spacing: 5px;
        }
        
        a {
            text-decoration: none;
            color: rgb(85, 85, 85);
        }
        a:hover {
            text-decoration: underline;
        }

        .sidebar .nav-link:hover {
            background-color: rgb(235, 235, 235);
        }
        
        .btn-fav {
            border: none; 
            background: none; 
            padding: 0; 
            font-size: 1.25rem;
        }
        
        .btn-black, 
        .btn:hover {
            border: none;
        }
        .dropdown-item:active {
            background-color: black;
        }

        .edit:hover {
            color: #007bff;
        }
        .delete:hover {
            color: #dc3545;
        }

        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            background-color: #007bff !important;
        }
    </style>
</head>
<body>
    <?php include "site/header-dashboard.php" ?>

    <?php include "site/sidebar-dashboard.php" ?>           
        
    <hr>
    <div class="content">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-6">
                            <h2>Generación de Reportes</h2>
                        </div>
                        <div class="col-6 text-right">

                            <a href="#generarReporteModal" class="btn btn-success" data-toggle="modal">
                                <span>Generar</span> 
                                <i class="material-icons ml-1 align-middle"></i>
                            </a>

                            <?php
                                if (isset($lista_query)) {

                                    switch ($tipo_reporte) {
                                        case 1:
                                            $url_reporte = "reporte.php?tipo_reporte=$tipo_reporte&fecha_inicio=$fecha_inicio&fecha_fin=$fecha_fin&cod_suc=$cod_suc";
                                            break;
                                        
                                        case 2:
                                            $url_reporte = "reporte.php?tipo_reporte=$tipo_reporte&cliente=$cliente";
                                            break;

                                        case 3:
                                            $url_reporte = "reporte.php?tipo_reporte=$tipo_reporte&nom_pren=$nom_pren&tall_pren=$tall_pren&id_suc=$id_suc";
                                            break;

                                        case 4:
                                            $url_reporte = "reporte_stock.php?tipo_reporte=$tipo_reporte";
                                            break;

                                    }
                                ?>
                                    <a href="<?= $url_reporte ?>" class="btn btn-secondary" target="_blank">
                                        <span>Descargar</span> 
                                        <i class="material-icons ml-1 align-middle">cloud_download</i>
                                    </a>
                                <?php
                                }
                            ?>

                        </div>                            
                    </div>
                </div>

                <?php
                    if (isset($fecha_inicio) && isset($fecha_fin)) {
                        echo "<p>Productos Vendidos del $fecha_inicio al $fecha_fin</p>";
                    }
                    if (isset($cliente)) {
                        echo "<p>Reporte de Ventas del Cliente: $cliente</p>";
                    }
                    if (isset($nom_pren)) {
                        echo "<p>Reporte de Ventas del Producto: $nom_pren, talla: $tall_pren</p>";
                    }
                    if (isset($stock_disponible)) { // Usamos la variable stock_disponible para validar cuando el tipo_reporte sea 4.
                        echo "<br>";
                        echo "<h4>Stock Agotado</h4>";
                    }
                    if (isset($total_productos)) {
                        echo "<p><strong>Productos Mostrados: $total_productos</strong></p>";
                    }
                ?>

                <table class="table table-striped table-hover">
                    <thead>
                        <!-- Columnas -->
                        <tr>
                            <?php
                            if (isset($tipo_reporte) && $tipo_reporte!=4) {
                                echo "<th>Fecha</th>";
                                echo "<th>Sucursal</th>";
                                echo "<th>Producto</th>";
                                echo "<th>Talla</th>";
                                echo "<th>Marca</th>";
                                echo "<th>Precio Unitario</th>";
                                echo "<th>Cantidad</th>";
                                echo "<th>Importe</th>";
                            } 
                            
                            if (isset($tipo_reporte) && $tipo_reporte==4) {
                                echo "<th>Sucursal</th>";
                                echo "<th>Prenda</th>";
                                echo "<th>Talla</th>";
                                echo "<th>Marca</th>";
                                echo "<th>Existencias</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- Registros -->
                        <?php
                        if (isset($lista_query) && $tipo_reporte!=4) {
                            $importe_total = 0;

                            while ($row = mysqli_fetch_array($lista_query)) {
                                echo "<tr>";
                                echo "<td>" . $row['fec_vta'] . "</td>";
                                echo "<td>" . $row['nom_suc'] . "</td>";
                                echo "<td>" . $row['nom_pren'] . "</td>";
                                echo "<td>" . $row['tall_pren'] . "</td>";
                                echo "<td>" . $row['nom_marca'] . "</td>";
                                echo "<td>$" . $row['prec_pren'] . "</td>";
                                echo "<td>" . $row['cant_prend'] . "</td>";
                                echo "<td>$" . $row['importe'] . "</td>";
                                echo "</tr>";
                                $importe_total += $row['importe'];
                            }

                        } else if (isset($lista_query) && $tipo_reporte==4) {

                            while ($row = mysqli_fetch_array($lista_query)) {
                                echo "<tr>";
                                echo "<td>" . $row['nom_suc'] . "</td>";
                                echo "<td>" . $row['nom_pren'] . "</td>";
                                echo "<td>" . $row['tall_pren'] . "</td>";
                                echo "<td>" . $row['nom_marca'] . "</td>";
                                echo "<td>" . $row['exist_pren'] . "</td>";
                                echo "</tr>";
                            }
                        }
                       
                        ?>
                    </tbody>
                </table>

                <?php
                    if (isset($importe_total)) {
                        echo "<p><strong>Importe Total: $" . number_format($importe_total, 2, '.', ',') . "</strong></p>";
                    }
                ?>

                <!-- Si el Reporte es de Stock, se crea una segunda tabla para el Stock Disponible -->
                <?php
                    if (isset($stock_disponible)) { ?>
                        <br><br>
                        <h4>Stock Disponible</h4>
                        <?php
                        if (isset($total_productos2)) {
                        echo "<p><strong>Productos Mostrados: $total_productos2</strong></p>";
                        }?>

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                <th>Sucursal</th>
                                <th>Prenda</th>
                                <th>Talla</th>
                                <th>Marca</th>
                                <th>Existencias</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                while ($row = mysqli_fetch_array($stock_disponible)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['nom_suc'] . "</td>";
                                    echo "<td>" . $row['nom_pren'] . "</td>";
                                    echo "<td>" . $row['tall_pren'] . "</td>";
                                    echo "<td>" . $row['nom_marca'] . "</td>";
                                    echo "<td>" . $row['exist_pren'] . "</td>";
                                    echo "</tr>";
                                }
                            ?>

                            </tbody>
                        </table>
                    <?php }
                ?>
                
            </div>
        </div>
    </div>

    <!-- Generar Reporte -->
    <div class="modal fade" id="generarReporteModal" tabindex="-1" role="dialog" aria-labelledby="generarReporteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="generarReporteLabel">Generar Reporte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-4">
                    <!-- Contenido del formulario para agregar una Sucursal -->
                    <form action="" method="POST">

                        <div class="form-group row align-items-center">
                            <div class="col-2"> <label class="m-0">Reporte:</label> </div>
                            <div class="col-10">
                                <select class="form-select" id="tipo_reporte" name="tipo_reporte">
                                    <option value="1">Reporte de Venta</option>
                                    <option value="2">Reporte por Cliente</option>
                                    <option value="3">Reporte por Sucursal</option>
                                    <option value="4">Reporte de Stock</option>
                                </select>
                            </div>
                        </div>

                        <!-- Campos para Reporte de venta -->
                        <div id="camposVenta">
                            <div class="form-group row align-items-center">
                                <div class="col-2"> <label class="m-0">Período:</label> </div>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col">
                                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                                        </div>
                                        <div class="col-auto d-flex align-items-center">
                                            <span class="m-0">a</span>
                                        </div>
                                        <div class="col">
                                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row align-items-center">
                                <div class="col-2"> <label class="m-0">Sucursal:</label> </div>
                                <div class="col-10">
                                    <select class="form-select" name="cod_suc">
                                        <?php
                                        $lista_sucursal = tablaSucursalSelect();
                                        while ($row = mysqli_fetch_array($lista_sucursal)) {
                                            echo '<option value="' . $row['cod_suc'] . '">' . $row['nom_suc'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Campos para Reporte por Cliente -->
                        <div id="camposCliente">
                            <div class="form-group row align-items-center">
                                <div class="col-2"> <label class="m-0">Cliente:</label> </div>
                                <div class="col-10"> <input type="text" class="form-control" placeholder="Nombre de Usuario o Email" id="cliente" name="cliente"> </div>
                            </div>
                        </div>
                        
                        <!-- Campos para Reporte por Sucursal -->
                        <div id="camposSucursal">
                            <div class="form-group row align-items-center">
                                <div class="col-2"> <label class="m-0">Prenda:</label> </div>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" id="nom_pren" name="nom_pren" placeholder="Nombre">
                                        </div>
                                        <div class="col-auto d-flex align-items-center">
                                            <span class="m-0">Talla:</span>
                                        </div>
                                        <div class="col">
                                            <select class="form-select" id="tall_pren" name="tall_pren">
                                                <option value="Todas">Todas</option>
                                                <option value="XS">XS</option>
                                                <option value="S">S</option>
                                                <option value="M">M</option>
                                                <option value="L">L</option>
                                                <option value="XL">XL</option>
                                                <option value="XXL">XXL</option>
                                                <option value="XXXL">XXXL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <div class="col-2"> <label class="m-0">Sucursal:</label> </div>
                                <div class="col-10">
                                    <select class="form-select" name="id_suc">
                                        <?php
                                        $lista_sucursal = tablaSucursalSelect();
                                        while ($row = mysqli_fetch_array($lista_sucursal)) {
                                            echo '<option value="' . $row['cod_suc'] . '">' . $row['nom_suc'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Generar</button>
                        </div>
                        
                    </form>                
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var tipoReporteSelect = document.getElementById('tipo_reporte');
        var camposVenta = document.getElementById('camposVenta');
        var camposCliente = document.getElementById('camposCliente');
        var camposSucursal = document.getElementById('camposSucursal');

        var fecha_inicio = document.getElementById('fecha_inicio');
        var fecha_fin = document.getElementById('fecha_inicio');
        var cliente = document.getElementById('cliente');
        var nom_pren = document.getElementById('nom_pren');

        // Función para mostrar u ocultar campos según la opción seleccionada
        function actualizarCampos() {
            camposVenta.style.display = 'none';
            camposCliente.style.display = 'none';
            camposSucursal.style.display = 'none';

            if (tipoReporteSelect.value === '1') {
                camposVenta.style.display = 'block';
                fecha_inicio.setAttribute('required', 'required');
                fecha_fin.setAttribute('required', 'required');
                cliente.removeAttribute('required');
                nom_pren.removeAttribute('required');
            } else if (tipoReporteSelect.value === '2') {
                camposCliente.style.display = 'block';
                fecha_inicio.removeAttribute('required');
                fecha_fin.removeAttribute('required');
                cliente.setAttribute('required', 'required');
                nom_pren.removeAttribute('required');
            } else if (tipoReporteSelect.value === '3') {
                camposSucursal.style.display = 'block';
                fecha_inicio.removeAttribute('required');
                fecha_fin.removeAttribute('required');
                cliente.removeAttribute('required');
                nom_pren.setAttribute('required', 'required');
            } else if (tipoReporteSelect.value === '4') {
                fecha_inicio.removeAttribute('required');
                fecha_fin.removeAttribute('required');
                cliente.removeAttribute('required');
                nom_pren.removeAttribute('required');
            }
        }

        // Agrega un listener al cambio de la opción seleccionada
        tipoReporteSelect.addEventListener('change', function () {
            actualizarCampos();
        });

        // Llama a la función para mostrar los campos iniciales
        actualizarCampos();
    });
    </script>

    
</body>
</html>
