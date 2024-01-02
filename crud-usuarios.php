<?php
include ('php/functions.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Usuarios</title>

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
                            <h2>Administrar Usuarios</h2>
                        </div>
                        <div class="col-6 text-right">
                            
                            <form action="php/search_user.php" method="POST" class="btn border-0">
                                <input type="text" class="form-control" name="search_user" placeholder="Buscar">
                            </form>

                            <a href="#addUsuarioModal" class="btn btn-success" data-toggle="modal">
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
                            <th>Nombre de Usuario</th>
                            <th>Tipo de Usuario</th>
                            <th>Estatus de Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Registros -->
                        <?php
                        if (isset($_SESSION['search_user'])) {
                            $lista_query = searchUsuario($_SESSION['search_user']);
                        } else {
                            $lista_query = tablaUsuario();
                        }
                        
                        while ($row = mysqli_fetch_array($lista_query)) {
                            echo "<tr>";

                            echo "<td>" . $row['nom_us'] . "</td>";
                            
                            if ($row['tipo_us']  == 0) {
                                echo "<td>Administrador</td>";
                            } else {
                                echo "<td>Cliente</td>";
                            }

                            if ($row['status_us']  == 0) {
                                echo "<td>Deshabilitado</td>";
                            } else {
                                echo "<td>Habilitado</td>";
                            }
                            
                            echo '<td>';

                                if ($row['tipo_us'] == 0) {
                                    echo '<a href="#editUsuarioModal" class="edit" data-toggle="modal" data-nom_us="'.$row['nom_us'].'" data-pass_us="'.$row['pass_us'].'"><i class="material-icons" data-toggle="tooltip" title="" data-original-title="Editar"></i></a>';
                                }

                                if (isset($_SESSION['admin']['nom_us']) && $_SESSION['admin']['nom_us'] != $row['nom_us']) {
                                    echo '<a href="php/delete_usuario.php?nom_us='.$row['nom_us'].'&status_us='.$row['status_us'].' " class="delete"><i class="material-icons" data-toggle="tooltip" title="" data-original-title="Eliminar"></i></a>';
                                }
                                
                            echo '</td>';
                            echo "</tr>";
                        }

                        ?>

                    </tbody>
                </table>

                <div class="clearfix">
                    <div class="hint-text my-3">Mostrando <b><?php echo min($records_per_page, registrosTablaUsuario()); ?></b> de <b><?php echo registrosTablaUsuario(); ?></b> entradas</div>
                    <ul class="pagination">
                        <?php
                            $total_pages = ceil(registrosTablaUsuario() / $records_per_page);

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

    <!-- Modal Agregar Usuario -->
    <div class="modal fade" id="addUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="AddUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="AddUsuarioModalLabel">Añadir Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-4">
                    <!-- Contenido del formulario para agregar un usuario -->
                    <form action="php/add_usuario.php" method="GET">

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Nombre:</label> </div>
                            <div class="col-9"> <input type="text" class="form-control" placeholder="Nombre de Usuario" name="nom_us" required minlength="6"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Tipo:</label> </div>
                            <div class="col-9">
                                <select class="form-control" name="tipo_us" id="tipoUsuario">
                                    <option value="0">Administrador</option>
                                    <option value="1">Cliente</option>
                                </select>
                            </div>
                        </div>


                        <!-- Campos que aparecen para Cliente -->
                        <div id="camposCliente" style="display: none;">

                            <div class="form-group row align-items-center">
                                <div class="col-3"> <label class="m-0">Nombre:</label> </div>
                                <div class="col-9"> <input type="text" class="form-control" placeholder="Nombre de Pila" name="n1_clie" id="n1_clie"> </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <div class="col-3"> <label class="m-0">Apellido P:</label> </div>
                                <div class="col-9"> <input type="text" class="form-control" placeholder="Apellido Paterno" name="ap_clie" id="ap_clie"> </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <div class="col-3"> <label class="m-0">Apellido M:</label> </div>
                                <div class="col-9"> <input type="text" class="form-control" placeholder="Apellido Materno" name="am_clie" id="am_clie"> </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <div class="col-3"> <label class="m-0">Email:</label> </div>
                                <div class="col-9"> <input type="email" class="form-control" placeholder="Email" name="email_clie" id="email_clie"> </div>
                            </div>

                        </div>


                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Contraseña:</label> </div>
                            <div class="col-9"> <input type="password" class="form-control" placeholder="Contraseña" name="pass_us" required minlength="8"> </div>
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

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="editUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="editUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-4">
                    <!-- Contenido del formulario para editar una usuario -->
                    <form action="php/edit_usuario.php" method="POST">

                        <input type="hidden" name="old_nom_us">
                        
                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Nombre:</label> </div>
                            <div class="col-9"> <input type="text" class="form-control" placeholder="Nombre de Usuario" name="new_nom_us" required minlength="6"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Contraseña:</label> </div>
                            <div class="col-9"> <input type="password" class="form-control" placeholder="Contraseña" name="pass_us" required minlength="8"> </div>
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
                
                <?= isset($_SESSION['ERROR']) && $_SESSION['ERROR'] === "Nombre de Usuario en Uso" ? '<p>El Nombre de usuario que intentas ingresar ya se encuentra en uso, favor de intentar con otro distinto.</p>' : ''; ?>
                <?= isset($_SESSION['ERROR']) && $_SESSION['ERROR'] === "Email en Uso" ? '<p>El Email que intentas ingresar ya se encuentra en uso, favor de intentar con otro distinto.</p>' : ''; ?>
                    
                </div>
                <div class="modal-footer mx-4">
                    <button type="button" class="btn btn-danger close-modal-btn" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Llenar campos de editar usuario con sus datos -->
    <script>
    $('.edit').click(function () {
    // Obtener los datos del producto actual y llenar el formulario de edición
    var old_nom_us = $(this).data('nom_us');
    var new_nom_us = $(this).data('nom_us');
    var pass_us = $(this).data('pass_us');


    // Llenar los campos del formulario con los datos del producto actual
    $('#editUsuarioModal input[name="old_nom_us"]').val(old_nom_us);
    $('#editUsuarioModal input[name="new_nom_us"]').val(new_nom_us);
    $('#editUsuarioModal input[name="pass_us"]').val(pass_us);
    });
    </script>




    <!-- Mostrar y Ocultar Campos de Cliente -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tipoUsuario = document.getElementById('tipoUsuario');
            var camposCliente = document.getElementById('camposCliente');

            tipoUsuario.addEventListener('change', function () {
                // Si el tipo de usuario es Cliente, muestra los campos de cliente y hazlos obligatorios
                if (tipoUsuario.value === '1') {
                    camposCliente.style.display = 'block';
                    document.getElementById('n1_clie').required = true;
                    document.getElementById('ap_clie').required = true;
                    document.getElementById('am_clie').required = true;
                    document.getElementById('email_clie').required = true;
                } else {
                    // Si el tipo de usuario es Administrador, oculta los campos de cliente y hazlos no obligatorios
                    camposCliente.style.display = 'none';
                    document.getElementById('n1_clie').required = false;
                    document.getElementById('ap_clie').required = false;
                    document.getElementById('am_clie').required = false;
                    document.getElementById('email_clie').required = false;
                }
            });
        });
    </script>
    



    <!-- Mostrar y Ocultar mensaje de Error -->
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
    

</body>
</html>