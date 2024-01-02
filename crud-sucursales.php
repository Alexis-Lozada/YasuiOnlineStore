<?php
include ('php/functions.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Sucursales</title>

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
                            <h2>Administrar Sucursales</h2>
                        </div>
                        <div class="col-6 text-right">

                            <form action="php/search_sucursal.php" method="POST" class="btn border-0">
                                    <input type="text" class="form-control" name="search_sucursal" placeholder="Buscar">
                            </form>

                            <a href="#addSucursalModal" class="btn btn-success" data-toggle="modal">
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
                            <th>Nombre</th>
                            <!--<th>Estado</th>-->
                            <th>Municipio</th>
                            <th>Colonia</th>
                            <th>Calle</th>
                            <th>Núm. Ext.</th>
                            <th>Núm. Int.</th>
                            <th>CP</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Registros -->
                        <?php
                        if (isset($_SESSION['search_sucursal'])) {
                            $lista_query = searchSucursal($_SESSION['search_sucursal']);
                        } else {
                            $lista_query = tablaSucursal();
                        }
                        while ($row = mysqli_fetch_array($lista_query)) {
                            echo "<tr>";
                            echo "<td>" . $row['nom_suc'] . "</td>";
                            //echo "<td>" . $row['nom_est'] . "</td>";
                            echo "<td>" . $row['nom_mun'] . "</td>";
                            echo "<td>" . $row['col_suc'] . "</td>";
                            echo "<td>" . $row['call_suc'] . "</td>";
                            echo "<td>" . $row['ne_suc'] . "</td>";
                            echo "<td>" . $row['ni_suc'] . "</td>";
                            echo "<td>" . $row['cp_suc'] . "</td>";
                            if ($row['status_suc']  == 0) {
                                echo "<td>Deshabilitado</td>";
                            } else {
                                echo "<td>Habilitado</td>";
                            }
                            echo '<td> 
                                <a href="#editSucursalModal" class="edit" data-toggle="modal" data-cod="'.$row['cod_suc'].'" data-nom="'.$row['nom_suc'].'" data-est="'.$row['cve_est'].'" data-mun="'.$row['cve_mun'].'" data-col="'.$row['col_suc'].'" data-call="'.$row['call_suc'].'" data-ne="'.$row['ne_suc'].'" data-ni="'.$row['ni_suc'].'" data-cp="'.$row['cp_suc'].'" data-status="'.$row['status_suc'].'"><i class="material-icons" data-toggle="tooltip" title="" data-original-title="Editar"></i></a>
                                <a href="php/delete_sucursal.php?cod_suc='.$row['cod_suc'].'&status_suc='.$row['status_suc'].' " class="delete"><i class="material-icons" data-toggle="tooltip" title="" data-original-title="Eliminar"></i></a>
                                </td>';
                            echo "</tr>";
                        }
                        ?>

                    </tbody>
                </table>

                <div class="clearfix">
                    <div class="hint-text my-3">Mostrando <b><?php echo min($records_per_page, registrosTablaSucursal()); ?></b> de <b><?php echo registrosTablaSucursal(); ?></b> entradas</div>
                    <ul class="pagination">
                        <?php
                            $total_pages = ceil(registrosTablaSucursal() / $records_per_page);

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

    <!-- Modal Agregar Producto -->
    <div class="modal fade" id="addSucursalModal" tabindex="-1" role="dialog" aria-labelledby="AddSucursalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="AddProduSucursalLabel">Añadir Sucursal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-4">
                    <!-- Contenido del formulario para agregar una Sucursal -->
                    <form action="php/add_sucursal.php" method="GET">

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0" for="nombre">Nombre:</label> </div>
                            <div class="col-9"> <input type="text" class="form-control" placeholder="Nombre de sucursal" name="nom_suc" required minlength="6"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Estado:</label> </div>
                            <div class="col-9">
                                <select class="form-control estadoSelect" name="cve_est">
                                    <?php
                                    $lista_tipo = tablaEstado();
                                    while ($row = mysqli_fetch_array($lista_tipo)) {
                                        echo '<option value="' . $row['cve_est'] . '">' . $row['nom_est'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Municipio:</label> </div>
                            <div class="col-9">
                                <select class="form-control municipioSelect" name="cve_mun">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Colonia:</label> </div>
                            <div class="col-9"> <input type="text" class="form-control" placeholder="Colonia" name="col_suc" required minlength="4"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Calle:</label> </div>
                            <div class="col-9"> <input type="text" class="form-control" placeholder="Calle" name="call_suc" required minlength="4"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Núm. Ext:</label> </div>
                            <div class="col-9"> <input type="number" class="form-control" placeholder="Número Exterior" name="ne_suc" required step="1"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Núm. Int:</label> </div>
                            <div class="col-9"> <input type="number" class="form-control" placeholder="Número Interior" name="ni_suc" required step="1"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">CP:</label> </div>
                            <div class="col-9"> <input type="number" class="form-control" placeholder="Código Postal" name="cp_suc" required step="1"> </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>                
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Producto -->
    <div class="modal fade" id="editSucursalModal" tabindex="-1" role="dialog" aria-labelledby="editSucursalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="editSucursalModalLabel">Editar Sucursal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-4">
                    <!-- Contenido del formulario para editar una Sucursal -->
                    <form action="php/edit_sucursal.php" method="GET">

                        <!-- ID de sucursal en elemento oculto -->
                        <input type="hidden" name="cod_suc">
                        
                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0" for="nombre">Nombre:</label> </div>
                            <div class="col-9"> <input type="text" class="form-control" placeholder="Nombre de sucursal" name="nom_suc" required minlength="6"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Estado:</label> </div>
                            <div class="col-9">
                                <select class="form-control estadoSelect" name="cve_est">
                                    <?php
                                    $lista_tipo = tablaEstado();
                                    while ($row = mysqli_fetch_array($lista_tipo)) {
                                        echo '<option value="' . $row['cve_est'] . '">' . $row['nom_est'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Municipio:</label> </div>
                            <div class="col-9">
                                <select class="form-control municipioSelect" name="cve_mun">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Colonia:</label> </div>
                            <div class="col-9"> <input type="text" class="form-control" placeholder="Colonia" name="col_suc" required minlength="4"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Calle:</label> </div>
                            <div class="col-9"> <input type="text" class="form-control" placeholder="Calle" name="call_suc" required minlength="4"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Núm. Ext:</label> </div>
                            <div class="col-9"> <input type="number" class="form-control" placeholder="Número Exterior" name="ne_suc" required step="1"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Núm. Int:</label> </div>
                            <div class="col-9"> <input type="number" class="form-control" placeholder="Número Interior" name="ni_suc" required step="1"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">CP:</label> </div>
                            <div class="col-9"> <input type="number" class="form-control" placeholder="Código Postal" name="cp_suc" required step="1"> </div>
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

    <!-- Modal Eliminar Producto -->
    <div class="modal fade" id="deleteSucursalModal" tabindex="-1" role="dialog" aria-labelledby="deleteSucursalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSucursalModalLabel">Eliminar Sucursal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este producto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form id="delete_producto" method="POST" action="php/delete_producto.php">
                        <input type="hidden" id="productToDeleteId" name="id_pren" value="">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    $('.edit').click(function () {
    // Obtener los datos del producto actual y llenar el formulario de edición
    var cod = $(this).data('cod');
    var nom = $(this).data('nom');
    var est = $(this).data('est');
    var col = $(this).data('col');
    var call = $(this).data('call');
    var ne = $(this).data('ne');
    var ni = $(this).data('ni');
    var cp = $(this).data('cp');
    var status = $(this).data('status');

    // Llenar los campos del formulario con los datos del producto actual
    $('#editSucursalModal input[name="cod_suc"]').val(cod);
    $('#editSucursalModal input[name="nom_suc"]').val(nom);
    $('#editSucursalModal select[name="cve_est"]').val(est).change();
    $('#editSucursalModal input[name="col_suc"]').val(col);
    $('#editSucursalModal input[name="call_suc"]').val(call);
    $('#editSucursalModal input[name="col_suc"]').val(col);
    $('#editSucursalModal input[name="ne_suc"]').val(ne);
    $('#editSucursalModal input[name="ni_suc"]').val(ni);
    $('#editSucursalModal input[name="cp_suc"]').val(cp);
    $('#editSucursalModal select[name="status_suc"]').val(status);
    });
    </script>

    <script>
    $('.estadoSelect').on('change', function () {
        var selectedEstado = $(this).val(); // Obtiene el valor seleccionado

        // Realiza una solicitud AJAX para obtener la lista de municipios
        $.ajax({
            type: 'GET',
            url: 'php/get_municipios.php', // Ruta al archivo PHP que manejará la solicitud
            data: { cve_est: selectedEstado }, // Envía el valor seleccionado como un parámetro
            success: function (data) {
                // Actualiza la lista de municipios en el formulario con la respuesta del servidor
                $('.municipioSelect').html(data);
            }
        });
    });
    </script>
    

</body>
</html>