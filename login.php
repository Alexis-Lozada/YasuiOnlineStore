<?php
    session_start();
    
    if (isset($_SESSION['cliente']) || isset($_SESSION['admin'])) {
        Header("Location: account.php");
    }
?>

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
</head>

<body>
    <?php include "site/header.php" ?>

    <div class="container space-header forms-container">
        <div class="row">
            <div class="col-md-2 col-lg-4"></div>
            <div class="col-12 col-md-8 col-lg-4">
                
                <div class="bg-light mx-3 mx-sm-0 p-sm-5 p-4">
                    <form action="php/login.php" method="GET" class="login_form">
                        <h2 class="text-center"> Iniciar Sesión </h2>
                        <div class="form-group">
                            <input type="text" class="form-control my-2 my-4 rounded-0" placeholder="Email o nombre de usuario" name="identificador">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control my-4 rounded-0" placeholder="Contraseña" name="password">
                        </div>
                        <?php
                            if (isset($_GET['error']) && $_GET['error'] === 'user_not_found') {
                                echo '
                                    <p style="color: red;">Usuario o contraseña incorrecta.</p>
                                ';
                            }
                        ?>
                        <!-- Mensajes de Contraseñas no coincidentes -->
                        <?php
                            if (isset($_GET['error']) && $_GET['error'] === 'cuenta_deshabilitada') {
                                echo '
                                    <div id="error" class="alert alert-danger rounded-0 my-4">
                                        ¡Esta cuenta ha sido deshabilitada!
                                    </div>
                                ';
                            }
                        ?>
                        <button type="submit" class="btn btn-dark w-100 rounded-0"> CONTINUAR </button>
                    </form>
                </div>
    
                <div class="m-auto mt-3 mb-5">
                    <p class="text-center mb-0"> ¿Aún no tienes una cuenta? <a href="sign-in.php" class="text-warning"> Regístrate aqui </a></p>
                </div>
            </div>
            <div class="col-md-2 col-lg-4"></div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 fixed-bottom">
        <div class="mb-3">
            <a href="#" class="text-white mx-2"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-white mx-2"><i class="bi bi-twitter"></i></a>
            <a href="#" class="text-white mx-2"><i class="bi bi-instagram"></i></a>
        </div>
        <p>YASUI &copy; 2023</p>
    </footer>
    
</body>
</html>