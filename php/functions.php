<?php
    //Paginación
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $records_per_page = 10;
    $offset = ($page - 1) * $records_per_page;


    // CRUD DE PRODUCTOS
    function tablaPrenda() {
        include 'connection.php';
        global $page, $records_per_page, $offset;

        $tabla_prenda = "SELECT prenda.id_pren, marca.cve_marca, tipo.cve_tipo, nom_pren, tall_pren, prec_pren, cto_pren, desc_pren, status_pren, img_pren, nom_marca, nom_tipo FROM marca, tipo, prenda WHERE marca.cve_marca=prenda.cve_marca AND tipo.cve_tipo=prenda.cve_tipo ORDER BY prenda.id_pren DESC LIMIT $offset, $records_per_page";
        return mysqli_query($connection, $tabla_prenda);
    }

    function registrosTablaPrenda() {
        include 'connection.php';
        

        if (!isset($_SESSION['search_producto'])) {
            $query = "SELECT COUNT(*) as total FROM prenda";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
        } else {
            $nom_pren = $_SESSION['search_producto'];
            $query = "SELECT COUNT(*) as total FROM prenda WHERE nom_pren LIKE '%$nom_pren%' ";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
        }

        
        return $row['total'];
    }

    function searchProducto($nom_pren) {
        include 'connection.php';
        global $page, $records_per_page, $offset;

        $search_producto = "SELECT prenda.id_pren, marca.cve_marca, tipo.cve_tipo, nom_pren, tall_pren, prec_pren, cto_pren, desc_pren, status_pren, img_pren, nom_marca, nom_tipo FROM marca, tipo, prenda WHERE marca.cve_marca=prenda.cve_marca AND tipo.cve_tipo=prenda.cve_tipo AND nom_pren LIKE '%$nom_pren%' ORDER BY prenda.id_pren DESC LIMIT $offset, $records_per_page";
        return mysqli_query($connection, $search_producto);
    }


    function tablaTipo() {
        include 'connection.php';

        $tabla_tipo = "SELECT * FROM tipo";
        return mysqli_query($connection, $tabla_tipo);
    }

    function tablaMarca() {
        include 'connection.php';

        $tabla_marca = "SELECT * FROM marca";
        return mysqli_query($connection, $tabla_marca);
    }




    // CRUD DE INVENTARIO
    function tablaInventario() {
        include 'connection.php';
        global $page, $records_per_page, $offset;

        $tabla_inventario = "SELECT cve_inv, sucursal.cod_suc, prenda.id_pren, tall_pren, exist_pren, status_inv, nom_suc, nom_pren  FROM sucursal, prenda, inventario WHERE sucursal.cod_suc=inventario.cod_suc AND prenda.id_pren=inventario.id_pren ORDER BY inventario.cve_inv ASC LIMIT $offset, $records_per_page";
        return mysqli_query($connection, $tabla_inventario);
    }

    function tablaSucursalSelect() {
        include 'connection.php';

        $tabla_sucursal = "SELECT * FROM sucursal";
        return mysqli_query($connection, $tabla_sucursal);
    }

    function searchInventario($nom_pren) {
        include 'connection.php';
        global $page, $records_per_page, $offset;

        $search_inventario = "SELECT cve_inv, sucursal.cod_suc, prenda.id_pren, tall_pren, exist_pren, status_inv, nom_suc, nom_pren  FROM sucursal, prenda, inventario WHERE sucursal.cod_suc=inventario.cod_suc AND prenda.id_pren=inventario.id_pren AND nom_pren LIKE '%$nom_pren%' ORDER BY inventario.cve_inv ASC LIMIT $offset, $records_per_page";
        return mysqli_query($connection, $search_inventario);
    }

    function registrosTablaInventario() {
        include 'connection.php';
        

        if (!isset($_SESSION['search_inventario'])) {
            $query = "SELECT COUNT(*) as total FROM inventario, sucursal WHERE sucursal.cod_suc=inventario.cod_suc";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
        } else {
            $nom_pren = $_SESSION['search_inventario'];
            $query = "SELECT COUNT(*) as total FROM inventario, prenda, sucursal WHERE sucursal.cod_suc=inventario.cod_suc AND prenda.id_pren=inventario.id_pren AND nom_pren LIKE '%$nom_pren%' ";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
        }

        
        return $row['total'];
    }

    //
    function searchProductoInv($nom_pren) {
        include 'connection.php';
        global $page, $records_per_page, $offset;

        $search_producto = "SELECT prenda.id_pren, marca.cve_marca, tipo.cve_tipo, nom_pren, tall_pren, prec_pren, cto_pren, desc_pren, status_pren, img_pren, nom_marca, nom_tipo FROM marca, tipo, prenda WHERE marca.cve_marca=prenda.cve_marca AND tipo.cve_tipo=prenda.cve_tipo AND nom_pren LIKE '%$nom_pren%' AND status_pren!=0 ORDER BY prenda.id_pren DESC LIMIT $offset, $records_per_page";
        return mysqli_query($connection, $search_producto);
    }

    function tablaPrendaInv() {
        include 'connection.php';
        global $page, $records_per_page, $offset;

        $tabla_prenda = "SELECT prenda.id_pren, marca.cve_marca, tipo.cve_tipo, nom_pren, tall_pren, prec_pren, cto_pren, desc_pren, status_pren, img_pren, nom_marca, nom_tipo FROM marca, tipo, prenda WHERE marca.cve_marca=prenda.cve_marca AND tipo.cve_tipo=prenda.cve_tipo AND status_pren!=0 ORDER BY prenda.id_pren DESC LIMIT $offset, $records_per_page";
        return mysqli_query($connection, $tabla_prenda);
    }

    function registrosTablaPrendaInv() {
        include 'connection.php';
        

        if (!isset($_SESSION['search_prod_inv'])) {
            $query = "SELECT COUNT(*) as total FROM prenda WHERE status_pren!=0";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
        } else {
            $nom_pren = $_SESSION['search_prod_inv'];
            $query = "SELECT COUNT(*) as total FROM prenda WHERE nom_pren LIKE '%$nom_pren%' AND status_pren!=0 ";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
        }

        
        return $row['total'];
    }
    //





    // CRUD USUARIOS
    function tablaUsuario() {
        include 'connection.php';
        global $page, $records_per_page, $offset;

        $tabla_usuario = "SELECT nom_us, CAST(AES_DECRYPT(pass_us, 'pichula') AS CHAR) as pass_us, tipo_us, status_us FROM usuario LIMIT $offset, $records_per_page";
        return mysqli_query($connection, $tabla_usuario);
    }

    function searchUsuario($user) {
        include 'connection.php';
        global $page, $records_per_page, $offset;
        $search_usuario = "SELECT nom_us, CAST(AES_DECRYPT(pass_us, 'pichula') AS CHAR) as pass_us, tipo_us, status_us FROM usuario WHERE nom_us LIKE '%$user%' LIMIT $offset, $records_per_page";
        return mysqli_query($connection, $search_usuario);
    }

    function registrosTablaUsuario() {
        include 'connection.php';
        

        if (!isset($_SESSION['search_user'])) {
            $query = "SELECT COUNT(*) as total FROM usuario";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
        } else {
            $user = $_SESSION['search_user'];
            $query = "SELECT COUNT(*) as total FROM usuario WHERE nom_us LIKE '%$user%' ";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
        }

        
        return $row['total'];
    }




    // CRUD DE SUCURSALES
    function tablaSucursal() {
        include 'connection.php';
        global $page, $records_per_page, $offset;

        $tabla_sucursal = "SELECT cod_suc, municipio.cve_mun, nom_suc, col_suc, call_suc, ne_suc, ni_suc, cp_suc, status_suc, nom_mun, nom_est, estado.cve_est FROM sucursal, municipio, estado WHERE estado.cve_est=municipio.cve_est AND municipio.cve_mun=sucursal.cve_mun ORDER BY cod_suc ASC LIMIT $offset, $records_per_page";
        return mysqli_query($connection, $tabla_sucursal);
    }

    function searchSucursal($nom_suc) {
        include 'connection.php';
        global $page, $records_per_page, $offset;
        $search_sucursal = "SELECT cod_suc, municipio.cve_mun, nom_suc, col_suc, call_suc, ne_suc, ni_suc, cp_suc, status_suc, nom_mun, nom_est, estado.cve_est FROM sucursal, municipio, estado WHERE estado.cve_est=municipio.cve_est AND municipio.cve_mun=sucursal.cve_mun AND nom_suc LIKE '%$nom_suc%' ORDER BY cod_suc ASC LIMIT $offset, $records_per_page";
        return mysqli_query($connection, $search_sucursal);
    }

    function registrosTablaSucursal() {
        include 'connection.php';
        

        if (!isset($_SESSION['search_sucursal'])) {
            $query = "SELECT COUNT(*) as total FROM sucursal";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
        } else {
            $nom_suc = $_SESSION['search_sucursal'];
            $query = "SELECT COUNT(*) as total FROM sucursal WHERE nom_suc LIKE '%$nom_suc%' ";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
        }

        
        return $row['total'];
    }

    function tablaEstado() { // Selector de Estado
        include 'connection.php';

        $tabla_estado = "SELECT * FROM estado";
        return mysqli_query($connection, $tabla_estado);
    }

    function tablaMunicipio($cve_est) { // Selector de Municipio
        include 'connection.php';

        $tabla_municipio = "SELECT * FROM municipio WHERE cve_est=$cve_est";
        return mysqli_query($connection, $tabla_municipio);
    }



    // FUNCIONES DEL BUSCADOR DEL CATALOGO
    function inventarioSucursal($sucursal) {
        include 'connection.php';

        $query_inv_suc = "SELECT * FROM prenda, inventario where prenda.id_pren=inventario.id_pren AND cod_suc='$sucursal' AND status_inv!=0 GROUP BY nom_pren";
        return mysqli_query($connection, $query_inv_suc); 
    }


    function inventarioCategoria($sucursal, $categoria) {
        include 'connection.php';

        $query_inv_ctg = "SELECT * FROM prenda, inventario where prenda.id_pren=inventario.id_pren AND cod_suc=$sucursal AND status_inv!=0 AND cve_tipo='$categoria' GROUP BY nom_pren";
        return mysqli_query($connection, $query_inv_ctg); 
    }

    function inventarioNombre($sucursal, $categoria, $search_query) {
        include 'connection.php';

        $query_inv_nom = "SELECT * FROM prenda, inventario where prenda.id_pren=inventario.id_pren AND cod_suc=$sucursal AND status_inv!=0 AND cve_tipo='$categoria' AND nom_pren LIKE '%$search_query%' GROUP BY nom_pren";
        return mysqli_query($connection, $query_inv_nom); 
    }

    function productosTop() {
        include 'connection.php';

        $query_prod_top = "SELECT *, SUM(cant_prend) AS total_vendido FROM prenda, inventario, ven_inv 
        WHERE prenda.id_pren=inventario.id_pren AND inventario.cve_inv=ven_inv.cve_inv AND status_inv!=0 GROUP BY nom_pren ORDER BY total_vendido DESC LIMIT 8";
        return mysqli_query($connection, $query_prod_top); 
    }




    // FUNCIONES DE PRODUCTO
    function buscarTallas($nom_pren, $cod_suc) { // busca las diferenets tallas que tiene una prenda
        include 'connection.php';

        $query_tallas = "SELECT cve_inv, tall_pren FROM inventario, prenda WHERE prenda.id_pren=inventario.id_pren AND nom_pren='$nom_pren' AND cod_suc=$cod_suc AND status_inv!=0 ORDER BY FIELD(tall_pren, 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL')";
        return mysqli_query($connection, $query_tallas); 
    }

    function existenciasInventario($cve_inv) {
        include 'connection.php';

        $query_inventario = "SELECT exist_pren FROM inventario WHERE cve_inv='$cve_inv' ";
        $result = mysqli_query($connection, $query_inventario);
        $row = mysqli_fetch_assoc($result);

        return $row['exist_pren'];
    }




    // FUNCIONES DE REPORTES
    function reporteVenta($fecha_inico, $fecha_fin, $cod_suc) {
        include 'connection.php';

        $ventas_x_fecha = "SELECT fec_vta, nom_suc, nom_pren, tall_pren, nom_marca, prec_pren, cant_prend, (cant_prend*prec_pren) AS importe
                        FROM venta, ven_inv, inventario, prenda, marca, sucursal
                        WHERE venta.no_vta=ven_inv.no_vta AND inventario.cve_inv=ven_inv.cve_inv AND prenda.id_pren=inventario.id_pren AND marca.cve_marca=prenda.cve_marca AND sucursal.cod_suc=inventario.cod_suc
                        AND sucursal.cod_suc='$cod_suc' AND fec_vta BETWEEN '$fecha_inico' AND '$fecha_fin' ORDER BY fec_vta DESC";

        return mysqli_query($connection, $ventas_x_fecha);
    }

    function reporteCliente($cliente) {
        include 'connection.php';

        $ventas_x_cliente = "SELECT fec_vta, nom_suc, nom_pren, tall_pren, nom_marca, prec_pren, cant_prend, (cant_prend*prec_pren) AS importe
                        FROM venta, ven_inv, inventario, prenda, marca, sucursal, cliente
                        WHERE venta.no_vta=ven_inv.no_vta AND inventario.cve_inv=ven_inv.cve_inv AND prenda.id_pren=inventario.id_pren AND marca.cve_marca=prenda.cve_marca AND sucursal.cod_suc=inventario.cod_suc AND venta.no_clie=cliente.no_clie
                        AND (nom_us='$cliente' || email_clie='$cliente') ORDER BY fec_vta DESC";

        return mysqli_query($connection, $ventas_x_cliente);
    }

    function reporteSucursal($nom_pren, $tall_pren, $cod_suc) {
        include 'connection.php';

        if ($tall_pren == "Todas") {
            $ventas_x_sucursal = "SELECT fec_vta, nom_suc, nom_pren, tall_pren, nom_marca, prec_pren, cant_prend, (cant_prend*prec_pren) AS importe
                                  FROM venta, ven_inv, inventario, prenda, marca, sucursal
                                  WHERE venta.no_vta=ven_inv.no_vta AND inventario.cve_inv=ven_inv.cve_inv AND prenda.id_pren=inventario.id_pren AND marca.cve_marca=prenda.cve_marca AND sucursal.cod_suc=inventario.cod_suc
                                  AND nom_pren LIKE '%$nom_pren%' AND sucursal.cod_suc='$cod_suc' ORDER BY fec_vta DESC";
        } else {
            $ventas_x_sucursal = "SELECT fec_vta, nom_suc, nom_pren, tall_pren, nom_marca, prec_pren, cant_prend, (cant_prend*prec_pren) AS importe
                                  FROM venta, ven_inv, inventario, prenda, marca, sucursal
                                  WHERE venta.no_vta=ven_inv.no_vta AND inventario.cve_inv=ven_inv.cve_inv AND prenda.id_pren=inventario.id_pren AND marca.cve_marca=prenda.cve_marca AND sucursal.cod_suc=inventario.cod_suc
                                  AND nom_pren LIKE '%$nom_pren%' AND tall_pren='$tall_pren' AND sucursal.cod_suc='$cod_suc' ORDER BY fec_vta DESC";
        }

        return mysqli_query($connection, $ventas_x_sucursal);
    }

    function stockAgotado() {
        include 'connection.php';

        $stock_agotado = "SELECT *  FROM sucursal, prenda, inventario, marca WHERE sucursal.cod_suc=inventario.cod_suc AND prenda.id_pren=inventario.id_pren AND marca.cve_marca=prenda.cve_marca AND status_inv!=0 AND exist_pren=0 ORDER BY inventario.cve_inv ASC";
        return mysqli_query($connection, $stock_agotado);
    }

    function stockDisponible() {
        include 'connection.php';

        $stock_x_disponible = "SELECT *  FROM sucursal, prenda, inventario, marca WHERE sucursal.cod_suc=inventario.cod_suc AND prenda.id_pren=inventario.id_pren AND marca.cve_marca=prenda.cve_marca AND status_inv!=0 AND exist_pren>0 ORDER BY inventario.cve_inv ASC";
        return mysqli_query($connection, $stock_x_disponible);
    }

?>