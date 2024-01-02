<?php
    include ('php/functions.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Productos</title>

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
                            <h2>Administrar Productos</h2>
                        </div>
                        <div class="col-6 text-right">

                            <form action="php/search_producto.php" method="POST" class="btn border-0">
                                <input type="text" class="form-control" name="search_producto" placeholder="Buscar">
                            </form>

                            <a href="#addProductoModal" class="btn btn-success" data-toggle="modal">
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
                            <th>Talla</th>
                            <th>Precio</th>
                            <th>Costo</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Registros -->
                        <?php
                        if (isset($_SESSION['search_producto'])) {
                            $lista_query = searchProducto($_SESSION['search_producto']);
                        } else {
                            $lista_query = tablaPrenda();
                        }

                        while ($row = mysqli_fetch_array($lista_query)) {
                            echo "<tr>";
                            echo "<td>" . $row['nom_pren'] . "</td>";
                            echo "<td>" . $row['tall_pren'] . "</td>";
                            echo "<td>" . $row['prec_pren'] . "</td>";
                            echo "<td>" . $row['cto_pren'] . "</td>";
                            echo "<td>" . $row['nom_tipo'] . "</td>";
                            echo "<td>" . $row['nom_marca'] . "</td>";
                            if ($row['status_pren']  == 0) {
                                echo "<td>Desabilitado</td>";
                            } else {
                                echo "<td>Habilitado</td>";
                            }
                            echo '<td> 
                                <a href="#editProductoModal" class="edit" data-toggle="modal" data-id="'.$row['id_pren'].'" data-nombre="'.$row['nom_pren'].'" data-talla="'.$row['tall_pren'].'" data-precio="'.$row['prec_pren'].'" data-costo="'.$row['cto_pren'].'" data-categoria="'.$row['cve_tipo'].'" data-marca="'.$row['cve_marca'].'" data-desc="'.$row['desc_pren'].'" data-status="'.$row['status_pren'].'" data-url="'.$row['img_pren'].'"><i class="material-icons" data-toggle="tooltip" title="" data-original-title="Editar"></i></a>
                                <a href="php/delete_producto.php?id_pren='.$row['id_pren'].'&status_pren='.$row['status_pren'].' " class="delete"><i class="material-icons" data-toggle="tooltip" title="" data-original-title="Eliminar"></i></a>
                                </td>';
                            echo "</tr>";
                        }
                        ?>

                    </tbody>
                </table>

                <div class="clearfix">
                    <div class="hint-text my-3">Mostrando <b><?php echo min($records_per_page, registrosTablaPrenda()); ?></b> de <b><?php echo registrosTablaPrenda(); ?></b> entradas</div>
                    <ul class="pagination">
                        <?php
                            $total_pages = ceil(registrosTablaPrenda() / $records_per_page);

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
    <div class="modal fade" id="addProductoModal" tabindex="-1" role="dialog" aria-labelledby="AddProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="AddProductoModalLabel">Añadir Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-4">
                    <!-- Contenido del formulario para agregar un producto -->
                    <form action="php/add_producto.php" method="POST" enctype="multipart/form-data">


                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0" for="nombre">Nombre:</label> </div>
                            <div class="col-9"> <input type="text" class="form-control" placeholder="Nombre" name="nom_pren" required minlength="6"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0">Talla:</label> </div>
                            <div class="col-9">
                                <select class="form-control" id="talla" name="tall_pren">
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
                            <div class="col-3"> <label class="m-0" for="costo">Costo:</label> </div>
                            <div class="col-9"> <input type="number" class="costo-input form-control" step="0.10" min="1" placeholder="Costo" name="cto_pren" required> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0" for="categoria">Categoría:</label> </div>
                            <div class="col-9">
                                <select class="form-control" id="categoriaSelect" name="cve_tipo">
                                    <?php
                                    $lista_tipo = tablaTipo();
                                    while ($row = mysqli_fetch_array($lista_tipo)) {
                                        echo '<option value="' . $row['cve_tipo'] . '">' . $row['nom_tipo'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0" for="marca">Marca:</label> </div>
                            <div class="col-9">
                                <select class="form-control" id="marcaSelect" name="cve_marca">
                                    <?php
                                    $lista_marca = tablaMarca();
                                    while ($row = mysqli_fetch_array($lista_marca)) {
                                        echo '<option value="' . $row['cve_marca'] . '">' . $row['nom_marca'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0" for="url">Imagen:</label> </div>
                            <div class="col-9"> <input type="file" name="imagen" accept="image/*" required> </div>
                        </div>

                        <!-- agregar aqui un campo para descripcion -->
                        <div class="form-group mt-4">
                            <label for="descripcion">Descripción del producto:</label>
                            <textarea class="form-control" id="descripcion" name="desc_pren" rows="4"></textarea>
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
    <div class="modal fade" id="editProductoModal" tabindex="-1" role="dialog" aria-labelledby="editProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="editProductoModalLabel">Editar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-4">
                    <!-- Contenido del formulario para editar una producto -->
                    <form action="php/edit_producto.php" method="POST" enctype="multipart/form-data">

                        <!-- ID de prenda en elemento oculto -->
                        <input type="hidden" name="id_pren">

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0" for="nombre">Nombre:</label> </div>
                            <div class="col-9"> <input type="text" class="form-control" placeholder="Nombre" name="nom_pren" required minlength="6"> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0" for="talla">Talla:</label> </div>
                            <div class="col-9">
                                <select class="form-control" id="talla" name="tall_pren">
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
                            <div class="col-3"> <label class="m-0" for="costo">Costo:</label> </div>
                            <div class="col-9"> <input type="number" class="costo-input form-control" step="0.10" min="1" placeholder="Costo" name="cto_pren" required> </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0" for="categoria">Categoría:</label> </div>
                            <div class="col-9">
                                <select class="form-control" id="categoriaSelect" name="cve_tipo">
                                    <?php
                                    $lista_tipo = tablaTipo();
                                    while ($row = mysqli_fetch_array($lista_tipo)) {
                                        echo '<option value="' . $row['cve_tipo'] . '">' . $row['nom_tipo'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0" for="marca">Marca:</label> </div>
                            <div class="col-9">
                                <select class="form-control" id="marcaSelect" name="cve_marca">
                                    <?php
                                    $lista_marca = tablaMarca();
                                    while ($row = mysqli_fetch_array($lista_marca)) {
                                        echo '<option value="' . $row['cve_marca'] . '">' . $row['nom_marca'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-3"> <label class="m-0" for="url">Imagen:</label> </div>
                            <div class="col-9"> <input type="file" name="imagen" accept="image/*"> </div>
                        </div>

                        <!-- agregar aqui un campo para descripcion -->
                        <div class="form-group mt-4">
                            <label for="descripcion">Descripción del producto:</label>
                            <textarea class="form-control" id="descripcion" name="desc_pren" rows="4"></textarea>
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
    <div class="modal fade" id="deleteProductoModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductoModalLabel">Eliminar Producto</h5>
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
                
                <?= isset($_SESSION['ERROR']) && $_SESSION['ERROR'] === "Producto en existencia" ? '<p>El Producto que intentas ingresar ya se encuentra en existencia, favor de revisar los datos proporcionados.</p>' : ''; ?>
                    
                </div>
                <div class="modal-footer mx-4">
                    <button type="button" class="btn btn-danger close-modal-btn" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    $('.edit').click(function () {
    // Obtener los datos del producto actual y llenar el formulario de edición
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');
    var talla = $(this).data('talla');
    var costo = $(this).data('costo');
    var categoria = $(this).data('categoria');
    var marca = $(this).data('marca');
    var desc = $(this).data('desc');
    var status = $(this).data('status');
    var url = $(this).data('url');

    // Llenar los campos del formulario con los datos del producto actual
    $('#editProductoModal input[name="id_pren"]').val(id);
    $('#editProductoModal input[name="nom_pren"]').val(nombre);
    $('#editProductoModal select[name="tall_pren"]').val(talla);
    $('#editProductoModal input[name="cto_pren"]').val(costo);
    $('#editProductoModal select[name="cve_tipo"]').val(categoria);
    $('#editProductoModal select[name="cve_marca"]').val(marca);
    $('#editProductoModal textarea[name="desc_pren"]').val(desc);
    $('#editProductoModal select[name="status_pren"]').val(status);
    $('#editProductoModal input[name="img_pren"]').val(url);
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

</body>
</html>