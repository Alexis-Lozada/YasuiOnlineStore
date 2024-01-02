<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL);

// Importamos la biblioteca Dompdf, para procesar el HTML/PDF y generar el PDF
require_once 'dompdf/vendor/autoload.php';
include 'php/functions.php';

switch ($_GET['tipo_reporte']) {
    case 1:
        $titulo = "Reporte de Ventas";
        
        $fecha_inicio = $_GET['fecha_inicio'];
        $fecha_fin = $_GET['fecha_fin'];
        $cod_suc = $_GET['cod_suc'];

        $descripcion = "Productos Vendidos del $fecha_inicio al $fecha_fin";

        $lista_query = reporteVenta($fecha_inicio, $fecha_fin, $cod_suc);
        $total_productos = mysqli_num_rows($lista_query);
        break;
    
    case 2:
        $titulo = "Reporte de Ventas por Cliente";
        $cliente = $_GET['cliente'];

        $descripcion = "Reporte de Ventas del Cliente: $cliente";

        $lista_query = reporteCliente($cliente);
        $total_productos = mysqli_num_rows($lista_query);
        break;

    case 3:
        $titulo = "Reporte de Ventas por Sucursal";

        $nom_pren = $_GET['nom_pren'];
        $tall_pren = $_GET['tall_pren'];
        $id_suc = $_GET['id_suc'];

        $descripcion = "Reporte de Ventas del Producto: $nom_pren, talla: $tall_pren";

        $lista_query = reporteSucursal($nom_pren, $tall_pren, $id_suc);
        $total_productos = mysqli_num_rows($lista_query);
        break;

    default:
        echo "<p>Tipo de reporte no válido</p>";
        break;
}

// Contenido HTML del reporte
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px; /* Tamaño de fuente ajustado */
        }

        p{
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h2>'. $titulo .'</h2>
    <p>Empresa: Yasui</p>
    <p>Fecha de Generación: ' . date("Y-m-d") . '</p>
    <hr>
    
    <p>' . $descripcion . '</p>
    <p>Productos Mostrados: ' . $total_productos . '</p>
    
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Sucursal</th>
                <th>Producto</th>
                <th>Talla</th>
                <th>Marca</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Importe</th>
            </tr>
        </thead>
        <tbody>';
            
        if (isset($lista_query)) {
            $importe_total = 0;

            while ($row = mysqli_fetch_array($lista_query)) {
                $html .= '
                <tr>
                <td>' . $row['fec_vta'] . '</td>
                <td>' . $row['nom_suc'] . '</td>
                <td>' . $row['nom_pren'] . '</td>
                <td>' . $row['tall_pren'] . '</td>
                <td>' . $row['nom_marca'] . '</td>
                <td>$' . $row['prec_pren'] . '</td>
                <td>' . $row['cant_prend'] . '</td>
                <td>$' . $row['importe'] . '</td>
                </tr>';
                $importe_total += $row['importe'];
            }
        }
       
$html .= '
        </tbody>
    </table>';

    $html .= "<p><strong>Importe Total: $" . number_format($importe_total, 2, '.', ',') . "</strong></p>";

$html .= '
</body>
</html>
';

// Crear una instancia de Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

// Creamos una instancia de Options. Dentro de options podemos habilitar el procesamiento de lenguaje PHP y HTML, con esto evitamos errores en el procesamiento del código de la página que queremos renderizar
$options = new Options();
$options->set('isPhpEnabled', true);
$options->set('isHtml5ParserEnabled', true);

// Crear una instancia de Dompdf con las opciones configuradas
$dompdf = new Dompdf($options);

// Cargar el contenido HTML en Dompdf
$dompdf->loadHtml($html);

// Renderizar el PDF
$dompdf->render();

// Salida del PDF al navegador
$dompdf->stream('Reporte-de-Ventas.pdf', ['Attachment' => 0]);
?>