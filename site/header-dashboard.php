<?php
session_start();

if (!isset($_SESSION['admin'])) {
    if (isset($_SESSION['cliente'])) {
        header("Location: index.php");
    } else {
        header("Location: login.php");
    }
}
?>

<header class="fixed-top bg-dark text-white">
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand text-white" href="dashboard-inicio.php">Dashboard</a>
            <ul class="nav">
                 <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <!-- id se conecta con el aria labelledby -->
                        <img src="https://cdn-icons-png.flaticon.com/512/6073/6073873.png" alt="John Doe" class="rounded-circle" width="30" height="30">
                        <?php echo $_SESSION['admin']['nom_us']?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="account.php">Cuenta</a></li>
                        <li><a class="dropdown-item" href="php/logout.php">Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>