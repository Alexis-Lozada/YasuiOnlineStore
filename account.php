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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title> Tienda de ropa - Yasui </title>

    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "site/header.php" ?>

    <div class="space-header"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3"></div>
            <div class="col-12 col-md-8 col-lg-6">

                <!-- PERFIL PARA CLIENTE -->
                <div class=" mx-3 mx-sm-0 px-sm-5 px-4 mb-5" style="display: <?php echo isset($_SESSION['cliente']) ? 'block' : 'none'; ?>">

                    <nav aria-label="breadcrumb" class="justify-content-center d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="account.php">Mi Perfil</a></li>
                            <li class="breadcrumb-item"><a href="account.php?page=mi_direccion">Mi Dirección</a></li>
                            <li class="breadcrumb-item"><a href="account.php?page=factura_electronica">Factura Electrónica</a></li>
                        </ol>
                    </nav>

                    <br>

                    <!-- FORMULARIO DE PERFIL -->
                    <form action="php/update_perfil.php" method="POST" <?php echo (isset($_GET['page'])) ? 'style="display: none;"' : 'style="display: block;"'; ?>>
                        <h2 class="text-center"> Mi Perfil </h2>
                        <br>

                        <input type="hidden" name="n1_clie" value="<?= isset($_SESSION['cliente']['n1_clie']) ? $_SESSION['cliente']['n1_clie'] : '' ?>">

                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Nombre:</label> </div>
                            <input type="text" class="form-control mt-2 mb-4 rounded-0" placeholder="Nombre" name="n1_clie" value="<?php echo isset($_SESSION['cliente']) ? $_SESSION['cliente']['n1_clie'] : ''; ?>">
                        </div>
                        <?= isset($_GET['error']) && $_GET['error'] === 'nombre_invalido' ? '<p class="mx-lg-5" style="color: red;">El nombre es demasiado corto.</p>' : '' ?>


                        <div class="form-group mx-lg-5">
                            <div class="row">
                                <div class="col-6">
                                    <label class="m-0">Apellido Paterno:</label> 
                                    <input type="text" class="form-control mt-2 mb-4 rounded-0" placeholder="Apellido Paterno" name="ap_clie" value="<?php echo isset($_SESSION['cliente']) ? $_SESSION['cliente']['ap_clie'] : ''; ?>">
                                </div>
                                <div class="col-6">
                                    <label class="m-0">Apellido Materno:</label> 
                                    <input type="text" class="form-control mt-2 mb-4 rounded-0" placeholder="Apellido Materno" name="am_clie"  value="<?php echo isset($_SESSION['cliente']) ? $_SESSION['cliente']['am_clie'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <?= isset($_GET['error']) && $_GET['error'] === 'apellido_paterno_invalido' ? '<p class="mx-lg-5" style="color: red;">El apellido paterno es demasiado corto.</p>' : '' ?>
                        <?= isset($_GET['error']) && $_GET['error'] === 'apellido_materno_invalido' ? '<p class="mx-lg-5" style="color: red;">El apellido materno es demasiado corto.</p>' : '' ?>


                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Email:</label> </div>
                            <input type="email" class="form-control mt-2 mb-4 rounded-0" placeholder="Email" name="email_clie" value="<?php echo isset($_SESSION['cliente']) ? $_SESSION['cliente']['email_clie'] : ''; ?>">
                        </div>
                        <?= isset($_GET['error']) && $_GET['error'] === 'email_vacio' ? '<p class="mx-lg-5" style="color: red;">El email no puede estar vacío.</p>' : '' ?>
                        <?= isset($_GET['error']) && $_GET['error'] === 'email_duplicado' ? '<p class="mx-lg-5" style="color: red;">El email ya está en uso.</p>' : '' ?>


                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Nombre de Usuario:</label> </div>
                            <input type="text" class="form-control mt-2 mb-4 rounded-0" placeholder="Nombre de Usuario" name="nom_us" value="<?php echo isset($_SESSION['cliente']) ? $_SESSION['cliente']['nom_us'] : ''; ?>">
                        </div>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'usuario_duplicado') ? '<p class="mx-lg-5" style="color: red;">El nombre de usuario ya está en uso.</p>' : ''; ?>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'usuario_invalido') ? '<p class="mx-lg-5" style="color: red;">El nombre de usuario es inválido. Debe tener al menos 6 caracteres.</p>' : ''; ?>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'caracteres_invalidos') ? '<p class="mx-lg-5" style="color: red;">El nombre de usuario solo puede contener letras, números y guiones bajos.</p>' : ''; ?>


                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Teléfono:</label> </div>
                            <input type="tel" class="form-control mt-2 mb-4 rounded-0" placeholder="Teléfono" maxlength="10" name="tel_clie" value="<?php echo isset($_SESSION['cliente']['tel_clie']) ? $_SESSION['cliente']['tel_clie'] : ''; ?>">
                        </div>

                        <?= (isset($_GET['error']) && $_GET['error'] === 'tel_invalido') ? '<p class="mx-lg-5" style="color: red;">Por favor, ingresa exactamente 10 dígitos en el campo de teléfono.</p>' : ''; ?>


                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Contraseña:</label> </div>
                            <input type="password" class="form-control mt-2 mb-4 rounded-0" placeholder="Contarseña" name="pass_us" value="<?php echo isset($_SESSION['cliente']) ? $_SESSION['cliente']['pass_us'] : ''; ?>">
                        </div>

                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Confirmar Contraseña:</label> </div>
                            <input type="password" class="form-control mt-2 mb-4 rounded-0" placeholder="Confirmar Contraseña" name="pass_cf">
                        </div>

                        <?= (isset($_GET['error']) && $_GET['error'] === 'contrasena_no_coincide') ? '<div id="error" class="alert alert-danger rounded-0 my-4 mx-lg-5">¡Las Contraseñas no coinciden, vuelve a intentar!</div>' : ''; ?>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'contrasena_invalida') ? '<div id="easy-password" class="alert alert-danger rounded-0 mx-lg-5"><strong>Contraseña débil:</strong> Tu contraseña debe cumplir con los siguientes criterios:<ul><li>Debe contener al menos una letra mayúscula.</li><li>Debe contener al menos una letra minúscula.</li><li>Debe contener al menos un número.</li><li>Debe contener al menos uno de los siguientes caracteres especiales: @, #, $, %, & o *.</li></ul></div>' : ''; ?>

                        <div class="form-group mx-lg-5">
                            <button type="submit" class="btn btn-dark w-100 rounded-0"> ACTUALIZAR </button>
                        </div>
                    </form>

                    <!-- FORMULARIO DE DIRECCION -->
                    <form action="php/update_direccion.php" method="POST" <?php echo (isset($_GET['page']) && $_GET['page'] == "mi_direccion") ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                        <h2 class="text-center"> Mi Dirección </h2>
                        <br>

                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Estado:</label> </div>
                            <select class="form-control mt-2 mb-4 rounded-0 estadoSelect" name="cve_est">
                                <?php
                                $lista_tipo = tablaEstado();
                                while ($row = mysqli_fetch_array($lista_tipo)) {
                                    echo '<option value="' . $row['cve_est'] . '">' . $row['nom_est'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Municipio:</label> </div>
                            <select class="form-control mt-2 mb-4 rounded-0 municipioSelect" name="cve_mun"></select>
                        </div>

                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Colonia:</label> </div>
                            <input type="text" class="form-control mt-2 mb-4 rounded-0" placeholder="Colonia" name="col_clie" value="<?php echo isset($_SESSION['cliente']['col_clie']) ? $_SESSION['cliente']['col_clie'] : ''; ?>">
                        </div>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'col_invalido') ? '<p class="mx-lg-5" style="color: red;">El nombre de colonia es demasiado corto.</p>' : ''; ?>

                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Calle:</label> </div>
                            <input type="text" class="form-control mt-2 mb-4 rounded-0" placeholder="Calle" name="call_clie" value="<?php echo isset($_SESSION['cliente']['call_clie']) ? $_SESSION['cliente']['call_clie'] : ''; ?>">
                        </div>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'call_invalido') ? '<p class="mx-lg-5" style="color: red;">El nombre de calle es demasiado corto.</p>' : ''; ?>

                        <div class="form-group mx-lg-5">
                            <div class="row">
                                <div class="col-6">
                                    <label class="m-0">Número Exterior:</label>
                                    <input type="number" class="form-control mt-2 mb-4 rounded-0" step="1" min="0" placeholder="Número Exterior" name="ne_clie" value="<?php echo isset($_SESSION['cliente']['ne_clie']) ? $_SESSION['cliente']['ne_clie'] : ''; ?>">
                                </div>
                                <div class="col-6">
                                    <label class="m-0">Número Interior:</label>
                                    <input type="number" class="form-control mt-2 mb-4 rounded-0" step="1" min="0" placeholder="Número Interior" name="ni_clie" value="<?php echo isset($_SESSION['cliente']['ni_clie']) ? $_SESSION['cliente']['ni_clie'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'ne_invalido') ? '<p class="mx-lg-5" style="color: red;">El número exterior no puede estar vacio.</p>' : ''; ?>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'ni_invalido') ? '<p class="mx-lg-5" style="color: red;">El número interior no puede estar vacio.</p>' : ''; ?>

                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Código Postal:</label> </div>
                            <input type="number" class="form-control mt-2 mb-4 rounded-0" step="1" min="0" placeholder="Código Postal" name="cp_clie" value="<?php echo isset($_SESSION['cliente']['cp_clie']) ? $_SESSION['cliente']['cp_clie'] : ''; ?>">
                        </div>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'cp_invalido') ? '<p class="mx-lg-5 mb-4" style="color: red;">Proporciona únicamente 5 dígitos para el código postal.</p>' : ''; ?>

                        <div class="form-group mx-lg-5">
                            <button type="submit" class="btn btn-dark w-100 rounded-0"> ACTUALIZAR </button>
                        </div>
                        
                    </form>

                    <!-- FORMULARIO DE FACTURACIÓN ELECTRÓNICA -->
                    <form action="php/update_facturacion.php" id="factura_electronica" method="POST" <?php echo (isset($_GET['page']) && $_GET['page'] == "factura_electronica") ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                        <h2 class="text-center"> Facturación Electrónica </h2>
                        <br>
                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Razón Social:</label> </div>
                            <input type="text" class="form-control mt-2 mb-4 rounded-0" placeholder="Razón Social" name="razs_clie" value="<?php echo isset($_SESSION['cliente']['razs_clie']) ? $_SESSION['cliente']['razs_clie'] : ''; ?>">
                        </div>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'razs_invalido') ? '<p class="mx-lg-5" style="color: red;">La razón social no puede estar vacio.</p>' : ''; ?>
                        
                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">RFC:</label> </div>
                            <input type="text" class="form-control mt-2 mb-4 rounded-0" placeholder="RFC" name="rfc_clie" maxlength="13" value="<?php echo isset($_SESSION['cliente']['rfc_clie']) ? $_SESSION['cliente']['rfc_clie'] : ''; ?>">
                        </div>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'rfc_invalido') ? '<p class="mx-lg-5" style="color: red;">Por favor, ingresa exactamente 13 dígitos en el campo de RFC.</p>' : ''; ?>
                        
                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Régimen Fiscal:</label> </div>
                            <select class="form-control mt-2 mb-4 rounded-0" name="regf_clie" value="<?php echo isset($_SESSION['cliente']['regf_clie']) ? $_SESSION['cliente']['regf_clie'] : ''; ?>">
                                <option value="601 - General de Ley Personas Morales">601 - General de Ley Personas Morales</option>
                                <option value="603 - Personas Morales con Fines no Lucrativos">603 - Personas Morales con Fines no Lucrativos</option>
                                <option value="605 - Sueldos y Salarios e Ingresos Asimilados a Salarios">605 - Sueldos y Salarios e Ingresos Asimilados a Salarios</option>
                                <option value="606 - Arrendamiento">606 - Arrendamiento</option>
                            </select>
                        </div>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'regf_invalido') ? '<p class="mx-lg-5" style="color: red;">El Regimen Fiscal no puede estar vacio.</p>' : ''; ?>
                
                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Uso de CFDI:</label> </div>
                            <select class="form-control mt-2 mb-4 rounded-0" name="cfdi_clie" value="<?php echo isset($_SESSION['cliente']['cfdi_clie']) ? $_SESSION['cliente']['cfdi_clie'] : ''; ?>">
                                <option value="G01 - Adquisición de mercancias">G01 - Adquisición de mercancias</option>
                                <option value="G02 - Devoluciones, descuentos o bonificaciones">G02 - Devoluciones, descuentos o bonificaciones</option>
                                <option value="G03 - Gastos en general">G03 - Gastos en general</option>
                                <option value="P01 - Por definir">P01 - Por definir</option>
                            </select>
                        </div>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'cfdi_invalido') ? '<p class="mx-lg-5" style="color: red;">El uso de CFDI no puede estar vacio.</p>' : ''; ?>
                        
                        <div class="form-group mx-lg-5">
                            <button type="submit" class="btn btn-dark w-100 rounded-0"> ACTUALIZAR </button>
                        </div>
                        
                    </form>

                    <br>
                    <div class="text-end px-lg-5"> <a href="php/logout.php">Cerrar Sesión</a>  </div>

                </div>




                <!-- PERFIL PARA ADMINISTRADOR -->
                <div class=" mx-3 mx-sm-0 px-sm-5 px-4 mb-5" style="display: <?php echo isset($_SESSION['admin']) ? 'block' : 'none'; ?>">

                    <nav aria-label="breadcrumb" class="justify-content-center d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="account.php">Mi Perfil</a></li>
                        </ol>
                    </nav>

                    <!-- FORMULARIO DE PERFIL -->
                    <form action="php/update_perfil.php" method="POST" <?php echo (isset($_GET['page'])) ? 'style="display: none;"' : 'style="display: block;"'; ?>>
                        <h2 class="text-center"> Mi Perfil </h2>
                        <br>

                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Nombre de Usuario:</label> </div>
                            <input type="text" class="form-control mt-2 mb-4 rounded-0" placeholder="Nombre de Usuario" name="nom_us" value="<?php echo isset($_SESSION['admin']) ? $_SESSION['admin']['nom_us'] : ''; ?>">
                        </div>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'usuario_duplicado') ? '<p class="mx-lg-5" style="color: red;">El nombre de usuario ya está en uso.</p>' : ''; ?>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'usuario_invalido') ? '<p class="mx-lg-5" style="color: red;">El nombre de usuario es inválido. Debe tener al menos 6 caracteres.</p>' : ''; ?>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'caracteres_invalidos') ? '<p class="mx-lg-5" style="color: red;">El nombre de usuario solo puede contener letras, números y guiones bajos.</p>' : ''; ?>


                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Contraseña:</label> </div>
                            <input type="password" class="form-control mt-2 mb-4 rounded-0" placeholder="Contarseña" name="pass_us" value="<?php echo isset($_SESSION['admin']) ? $_SESSION['admin']['pass_us'] : ''; ?>">
                        </div>

                        <div class="form-group mx-lg-5">
                            <div> <label class="m-0">Confirmar Contraseña:</label> </div>
                            <input type="password" class="form-control mt-2 mb-4 rounded-0" placeholder="Confirmar Contraseña" name="pass_cf">
                        </div>

                        <?= (isset($_GET['error']) && $_GET['error'] === 'contrasena_no_coincide') ? '<div id="error" class="alert alert-danger rounded-0 my-4 mx-lg-5">¡Las Contraseñas no coinciden, vuelve a intentar!</div>' : ''; ?>
                        <?= (isset($_GET['error']) && $_GET['error'] === 'contrasena_invalida') ? '<div id="easy-password" class="alert alert-danger rounded-0 mx-lg-5"><strong>Contraseña débil:</strong> Tu contraseña debe cumplir con los siguientes criterios:<ul><li>Debe contener al menos una letra mayúscula.</li><li>Debe contener al menos una letra minúscula.</li><li>Debe contener al menos un número.</li><li>Debe contener al menos uno de los siguientes caracteres especiales: @, #, $, %, & o *.</li></ul></div>' : ''; ?>

                        <div class="form-group mx-lg-5">
                            <button type="submit" class="btn btn-dark w-100 rounded-0"> ACTUALIZAR </button>
                        </div>
                    </form>

                    <br>
                    <div class="text-end px-lg-5"> <a href="php/logout.php">Cerrar Sesión</a>  </div>

                </div>

            </div>

            <div class="col-md-2 col-lg-3"></div>
        </div>
    </div>

    <!-- SELECT DE ESTADO Y MUNICIPIO -->
    <script>
        $(document).ready(function () {
            var cve_est = <?php echo isset($_SESSION['cliente']['cve_est']) ? $_SESSION['cliente']['cve_est'] : 'null'; ?>;
            var cve_mun = <?php echo isset($_SESSION['cliente']['cve_mun']) ? $_SESSION['cliente']['cve_mun'] : 'null'; ?>;

            $('.estadoSelect').on('change', function () {
                var selectedEstado = $(this).val(); 

                $.ajax({
                    type: 'GET',
                    url: 'php/get_municipios.php',
                    data: { cve_est: selectedEstado },
                    success: function (data) {
                        $('.municipioSelect').html(data);

                        if (cve_mun !== null) {
                            $('.municipioSelect').val(cve_mun);
                        }
                    }
                });
            }); 

            if (cve_est !== null) {
                $('.estadoSelect').val(cve_est).trigger('change');
            }

            $('.estadoSelect').trigger('change');
        });
    </script>

    <!-- SELECT DE REGF Y CFDI -->
    <script>
    $(document).ready(function() {
        // Selecciona automáticamente las opciones al cargar la página
        $('#factura_electronica select[name="regf_clie"]').val('<?php echo isset($_SESSION['cliente']['regf_clie']) ? $_SESSION['cliente']['regf_clie'] : ''; ?>');
        $('#factura_electronica select[name="cfdi_clie"]').val('<?php echo isset($_SESSION['cliente']['cfdi_clie']) ? $_SESSION['cliente']['cfdi_clie'] : ''; ?>');
    });
    </script>

</body>
</html>
