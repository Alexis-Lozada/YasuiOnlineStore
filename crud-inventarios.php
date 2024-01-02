<?php
    include ('php/functions.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Inventarios</title>
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

    <!-- SECCION PARA VISUALIZAR TODOS LOS INVENTARIOS -->
    <div id="crud_inventarios" class="content">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-6">
                            <h2>Administrar Inventarios</h2>
                        </div>
                        <div class="col-6 text-right">

                            <form action="php/search_inventario.php" method="POST" class="btn border-0">
                                <input type="text" class="form-control" name="search_inventario" placeholder="Buscar">
                            </form>

                            <a href="crud-inventarios-productos.php" class="btn btn-success" id="btn_crud_productos">
                                <span>Agregar</span> 
                                <i class="material-icons ml-1 align-middle"></i>
                            </a>

                        </div>                            
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <!-- Columnas -->
                        <tr>
                            <th>Sucursal</th>
                            <th>Prenda</th>
                            <th>Talla</th>
                            <th>Existencias</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Registros -->
                        <?php
                        if (isset($_SESSION['search_inventario'])) {
                            $lista_query = searchInventario($_SESSION['search_inventario']);
                        } else {
                            $lista_query = tablaInventario();
                        }

                        while ($row = mysqli_fetch_array($lista_query)) {
                            echo "<tr>";
                            echo "<td>" . $row['nom_suc'] . "</td>";
                            echo "<td>" . $row['nom_pren'] . "</td>";
                            echo "<td>" . $row['tall_pren'] . "</td>";
                            echo "<td>" . $row['exist_pren'] . "</td>";
                            if ($row['status_inv']  == 0) {
                                echo "<td>Desabilitado</td>";
                            } else {
                                echo "<td>Habilitado</td>";
                            }
                            echo '<td> 
                                <a href="#editInventarioModal" class="edit" data-toggle="modal" data-cve_inv="'.$row['cve_inv'].'" data-cod_suc="'.$row['cod_suc'].'" data-nom_suc="'.$row['nom_suc'].'" data-tall_pren="'.$row['tall_pren'].'" data-nom_pren="'.$row['nom_pren'].'" data-exist_pren="'.$row['exist_pren'].'" data-status_inv="'.$row['status_inv'].'"><i class="material-icons" data-toggle="tooltip" title="" data-original-title="Editar"></i></a>
                                <a href="php/delete_inventario.php?cve_inv='.$row['cve_inv'].'&status_inv='.$row['status_inv'].' " class="delete"><i class="material-icons" data-toggle="tooltip" title="" data-original-title="Eliminar"></i></a>
                                </td>';
                            echo "</tr>";
                        }
                        ?>
                        
                    </tbody>
                </table>
                
                <div class="clearfix">
                    <div class="hint-text my-3">Mostrando <b><?php echo min($records_per_page, registrosTablaInventario()); ?></b> de <b><?php echo registrosTablaInventario(); ?></b> entradas</div>
                    <ul class="pagination">
                        <?php
                            $total_pages = ceil(registrosTablaInventario() / $records_per_page);

                            if ($page > 1) {
                                echo '<li class="page-item"><a href="?page=' . ($page - 1) . '" class="page-link">Anterior</a></li>';
                            }

                            $paginas_a_mostrar = 10;
                            $mitad_rango = ($paginas_a_mostrar / 2);

                            $inicio_rango = max(1, $page - $mitad_rango);
                            $fin_rango = min($total_pages, $inicio_rango + $paginas_a_mostrar - 1);
                        
                            for ($i = $inicio_rango; $i <= $fin_rango; $i++) {
                                if ($i == $page) {
                                    echo '<li class="page-item active"><a href="#" class="page-link">' . $i . '</a></li>';
                                } else {
                                    echo '<li class="page-item"><a href="?page=' . $i . '" class="page-link">' . $i . '</a></li>';
                                }
                            }
                        
                            if ($page < $total_pages) {
                                echo '<li class="page-item"><a href="?page=' . ($page + 1) . '" class="page-link">Siguiente</a></li>';
                            }
                        ?>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>


    <!-- Modal Agregar Inventarios -->
    <div class="modal fade" id="addInventarioModal" tabindex="-1" role="dialog" aria-labelledby="AddInventarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="AddInventarioModalLabel">Integrar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-4">
                    <!-- Contenido del formulario para agregar un inventario -->
                    <form action="php/add_inventario.php" method="POST">

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label>Sucursal:</label> </div>
                            <div class="col-9">
                                <select class="form-control" name="cod_suc">
                                    <?php
                                    $lista_sucursal = tablaSucursalSelect();
                                    while ($row = mysqli_fetch_array($lista_sucursal)) {
                                        if ($row['status_suc'] != 0) {
                                            echo '<option value="' . $row['cod_suc'] . '">' . $row['nom_suc'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- ID de prenda en elemento oculto -->
                        <input type="hidden" name="id_pren">

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label">Existencias:</label> </div>
                            <div class="col-9"> <input type="number" class="form-control" step="1" min="1" placeholder="Existencias" name="exist_pren" required> </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success guardarBtn">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    

    <!-- Modal Editar Inventarios -->
    <div class="modal fade" id="editInventarioModal" tabindex="-1" role="dialog" aria-labelledby="editInventarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="editInventarioModalLabel">Editar Inventario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-4">
                    <!-- Contenido del formulario para agregar un inventario -->
                    <form action="php/edit_inventario.php" method="GET">

                        <input type="hidden" name="cve_inv">

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label>Sucursal:</label> </div>
                            <div class="col-9">
                                <select class="form-control" name="cod_suc" disabled>
                                    <?php
                                    $lista_sucursal = tablaSucursalSelect();
                                    while ($row = mysqli_fetch_array($lista_sucursal)) {
                                        echo '<option value="' . $row['cod_suc'] . '">' . $row['nom_suc'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label>Nombre:</label> </div>
                            <div class="col-9"> <input type="text" class="form-control" name="nom_pren" readonly> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label">Talla:</label> </div>
                            <div class="col-9">
                                <select class="form-control" name="tall_pren" disabled>
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

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label">Existencias:</label> </div>
                            <div class="col-9"> <input type="number" class="form-control" step="1" min="0" placeholder="Existencias" name="exist_pren" required> </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Mensaje de Error -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="errorModalLabel"> <?php echo isset($_SESSION['ERROR']) ? $_SESSION['ERROR'] : ''; ?> </h5>
                    <button type="button" class="close close-modal-btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-4">
                
                <?= isset($_SESSION['ERROR']) && $_SESSION['ERROR'] === "Inventario Duplicado" ? '<p>El inventario que intentas agregar ya existe.</p>' : ''; ?>

                <?= isset($_SESSION['ERROR']) && $_SESSION['ERROR'] === "Producto no Encontrado" ? '<p>El producto que intentas ingresar no se encuentra.</p>' : ''; ?>
                    
                </div>
                <div class="modal-footer mx-4">
                    <button type="button" class="btn btn-danger close-modal-btn" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- LLenar campos del Formulario Editar Inventario -->
    <script>
        $('.edit').click(function () {
        // Obtener los datos del producto actual y llenar el formulario de edición
        var cve_inv = $(this).data('cve_inv');
        var cod_suc = $(this).data('cod_suc');
        var nom_pren = $(this).data('nom_pren');
        var tall_pren = $(this).data('tall_pren');
        var exist_pren = $(this).data('exist_pren');
        var status_inv = $(this).data('status_inv');

        // Llenar los campos del formulario con los datos del producto actual
        $('#editInventarioModal input[name="cve_inv"]').val(cve_inv);
        $('#editInventarioModal select[name="cod_suc"]').val(cod_suc);
        $('#editInventarioModal input[name="nom_pren"]').val(nom_pren);
        $('#editInventarioModal select[name="tall_pren"]').val(tall_pren);
        $('#editInventarioModal input[name="exist_pren"]').val(exist_pren);
        $('#editInventarioModal select[name="status_inv"]').val(status_inv);
        });
    </script>
    

    <script>
        $(document).ready(function() {
            <?php
            if (isset($_SESSION['ERROR'])) {
            ?>
                $('#errorModal').modal('show');
            <?php
                unset($_SESSION['ERROR']);
            }
            ?>
            $('.close-modal-btn').click(function () {
                $(this).closest('.modal').modal('hide');
            });
        });
    </script>

    </script>

    <!-- LLenar campos ocultos del Formulario Integrar Producto -->
    <script>
        $('.agregar_inventario').click(function () {
        var id_pren = $(this).data('id_pren');

        // Llenar los campos del formulario con los datos del producto actual
        $('#addInventarioModal input[name="id_pren"]').val(id_pren);
        });
    </script>

    

</body>
</html>