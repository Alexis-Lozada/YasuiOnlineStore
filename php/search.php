<?php
$sucursalSeleccionada = isset($_GET['sucursal']) ? $_GET['sucursal'] : null;
$categoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : null;
$terminoDeBusqueda = isset($_GET['search_query']) ? $_GET['search_query'] : null;

if ($sucursalSeleccionada && !isset($_GET['categoria'])) {
    header("Location: ../catalogo-sucursal.php?sucursal=".$sucursalSeleccionada);
} elseif ($categoriaSeleccionada && !isset($_GET['search_query'])) {
    header("Location: ../catalogo-categoria.php?sucursal=".$sucursalSeleccionada."&categoria=".$categoriaSeleccionada);
} elseif ($terminoDeBusqueda) {
    header("Location: ../catalogo-categoria.php?sucursal=".$sucursalSeleccionada."&categoria=".$categoriaSeleccionada."&search_query=".$terminoDeBusqueda);
} else {
    // En caso de que no haya categoría ni término de búsqueda, redirige a catalogo.php sin ninguna variable.
    header("Location: ../catalogo.php");
}
?>