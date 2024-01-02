<?php
$url_actual = $_SERVER['REQUEST_URI'];

$class_inicio = (strpos($url_actual, 'dashboard-inicio.php') !== false) ? 'active' : 'link-dark';
$class_reportes = (strpos($url_actual, 'dashboard-reportes.php') !== false) ? 'active' : 'link-dark';
$class_sucursales = (strpos($url_actual, 'crud-sucursales.php') !== false) ? 'active' : 'link-dark';
$class_inventarios = (strpos($url_actual, 'crud-inventarios.php') !== false) || (strpos($url_actual, 'crud-inventarios-productos.php') !== false)  ? 'active' : 'link-dark';
$class_productos = (strpos($url_actual, 'crud-productos.php') !== false) ? 'active' : 'link-dark';
$class_usuarios = (strpos($url_actual, 'crud-usuarios.php') !== false) ? 'active' : 'link-dark';
$class_ru_perfil = (strpos($url_actual, 'ru-perfil.php') !== false) ? 'active' : 'link-dark';
?>

<div class="sidebar bg-light">
    <a href="dashboard-inicio.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4"><strong>Menú de Administración</strong></span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="dashboard-inicio.php" class="nav-link <?php echo $class_inicio; ?>" aria-current="page">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                Inicio
            </a>
        </li>
        <li class="nav-item">
            <a href="dashboard-reportes.php" class="nav-link <?php echo $class_reportes; ?>" aria-current="page">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                Reportes
            </a>
        </li>
        <li class="nav-item">
            <a href="crud-sucursales.php" class="nav-link <?php echo $class_sucursales; ?>" aria-current="page">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                Sucursales
            </a>
        </li>
        <li>
            <a href="crud-inventarios.php" class="nav-link <?php echo $class_inventarios; ?>">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                Inventarios
            </a>
        </li>
        <li>
            <a href="crud-productos.php" class="nav-link <?php echo $class_productos; ?>">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                Productos
            </a>
        </li>
        <li>
            <a href="crud-usuarios.php" class="nav-link <?php echo $class_usuarios; ?>">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                Usuarios
            </a>
        </li>
        <hr>
        <li>
            <a href="index.php" class="nav-link link-dark">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
                Salir
            </a>
        </li>
    </ul>
</div>