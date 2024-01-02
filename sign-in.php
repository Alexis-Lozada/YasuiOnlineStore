<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title> Login - Yasui </title>
    
    <link rel="stylesheet" href="assets/css/styles.css">
    
    <!--<script>
        // Esta función se ejecutará después de la carga de la página
        window.onload = function() {
            // Limpia la URL actual
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>-->
</head>
<body>
    <?php include "site/header.php" ?>
    
    <div class="container space-header forms-container">
        <div class="row">
            <div class="col-md-2 col-lg-4"></div>
            <div class="col-12 col-md-8 col-lg-4">
                
                <!-- Mensaje de Contraseña inválida -->
                <?php
                    if (isset($_GET['error']) && $_GET['error'] === 'contrasena_invalida') {
                        echo '
                            <div id="easy-password" class="alert alert-danger rounded-0">
                            <strong>Contraseña débil:</strong> Tu contraseña debe cumplir con los siguientes
                            criterios:
                            <ul>
                                <li>Debe contener al menos una letra mayúscula.</li>
                                <li>Debe contener al menos una letra minúscula.</li>
                                <li>Debe contener al menos un número.</li>
                                <li>Debe contener al menos uno de los siguientes caracteres especiales: @, #, $, %, &
                                    o *.</li>
                                </ul>
                            </div>
                        ';
                    }
                ?>
                    
                    <div class="bg-light mx-3 mx-sm-0 p-sm-5 p-4">
                        <form action="php/sign-in.php" method="GET" onsubmit="validarPasswords()">
                            <h2 class="text-center"> Registrarse </h2>
                            <input type="text" class="form-control my-4 rounded-0" placeholder="Nombre" name="n1_clie" value="<?php echo isset($_GET['n1_clie']) ? $_GET['n1_clie'] : ''; ?>">
                            <!-- Mensaje de Nombre no válido -->
                            <?php
                            if (isset($_GET['error']) && $_GET['error'] === 'nombre_invalido') {
                                echo '<p style="color: red;">El nombre es demasdiado corto.</p>';
                            }
                            ?>

                            <input type="text" class="form-control my-4 rounded-0" placeholder="Apellido Paterno" name="ap_clie" value="<?php echo isset($_GET['ap_clie']) ? $_GET['ap_clie'] : ''; ?>">
                            <!-- Mensaje de Apellido P no válido -->
                            <?php
                            if (isset($_GET['error']) && $_GET['error'] === 'apellido_paterno_invalido') {
                                echo '<p style="color: red;">El apellido paterno es demasiado corto.</p>';
                            }
                            ?>

                            <input type="text" class="form-control my-4 rounded-0" placeholder="Apellido Materno" name="am_clie" value="<?php echo isset($_GET['am_clie']) ? $_GET['am_clie'] : ''; ?>">
                            <!-- Mensaje de Apellido M no válido -->
                            <?php
                            if (isset($_GET['error']) && $_GET['error'] === 'apellido_materno_invalido') {
                                echo '<p style="color: red;">El apellido materno es demasiado corto.</p>';
                            }
                            ?>

                            <input type="email" class="form-control my-4 rounded-0" placeholder="Email" name="email_clie" value="<?php echo isset($_GET['email_clie']) ? $_GET['email_clie'] : ''; ?>">
                            <!-- Mensaje de Email vacio -->
                            <?php
                            if (isset($_GET['error']) && $_GET['error'] === 'email_vacio') {
                                echo '<p style="color: red;">El email no puede estar vacio.</p>';
                            }
                            ?>
                            
                            <!-- Mensaje de Email duplicado -->
                            <?php
                            if (isset($_GET['error']) && $_GET['error'] === 'email_duplicado') {
                                echo '<p style="color: red;">El email ya está en uso.</p>';
                            }
                            ?>
                            
                            <input type="text" class="form-control my-4 rounded-0" placeholder="Nombre de usuario" name="nom_us" value="<?php echo isset($_GET['nom_us']) ? $_GET['nom_us'] : ''; ?>">
                            <!-- Mensaje de Usuario invalido-->
                            <?php
                            if (isset($_GET['error']) && $_GET['error'] === 'nombre_us_invalido') {
                                echo '<p style="color: red;">El nombre de usuario es inválido. Debe tener al menos 6 caracteres.</p>';
                            }
                            ?>
                            
                            <!-- Mensaje de Usuario duplicado -->
                            <?php
                            if (isset($_GET['error']) && $_GET['error'] === 'usuario_duplicado') {
                                echo '<p style="color: red;">El nombre de usuario ya está en uso.</p>';
                            }
                            ?>

                            <?= (isset($_GET['error']) && $_GET['error'] === 'caracteres_invalidos') ? '<p style="color: red;">El nombre de usuario solo puede contener letras, números y guiones bajos.</p>' : ''; ?>
                            
                            <input type="password" id="main-contrasena" class="form-control my-4 rounded-0" placeholder="Contraseña" name="pass_us">
                            <input type="password" id="contrasena-confirmation" class="form-control my-4 rounded-0" placeholder="Confirmar Contraseña" name="confirm_pass_us">
                            <button type="submit" class="btn btn-dark w-100 rounded-0"> REGISTRARSE </button>
                        </form>
                </div>

                <!-- Mensajes de Contraseñas no coincidentes -->
                <?php
                    if (isset($_GET['error']) && $_GET['error'] === 'contrasena_no_coincide') {
                        echo '
                            <div id="error" class="alert alert-danger rounded-0 my-4">
                                ¡Las Contraseñas no coinciden, vuelve a intentar!
                            </div>
                        ';
                    }
                ?>
                    
                    <div class="m-auto mt-3 mb-5">
                        <p class="text-center mb-0"> ¿Ya tienes una cuenta? <a href="login.php" class="text-warning"> Inicia sesión aquí </a></p>
                    </div>
                </div>
                <div class="col-md-2 col-lg-4"></div>
            </div>
        </div>
        
        <footer class="bg-dark text-white text-center py-3">
            <div class="mb-3">
                <a href="#" class="text-white mx-2"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white mx-2"><i class="bi bi-twitter"></i></a>
                <a href="#" class="text-white mx-2"><i class="bi bi-instagram"></i></a>
            </div>
            <p>YASUI &copy; 2023</p>
        </footer>
        
    </body>
    </html>