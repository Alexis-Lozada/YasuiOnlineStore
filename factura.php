<?php
session_start();
ini_set('display_errors', 'on');
error_reporting(E_ALL);

// Importamos la biblioteca Dompdf, para procesar el HTML/PDF y generar el PDF
require_once 'dompdf/vendor/autoload.php';
include 'php/connection.php';

$nom_mun = $connection->query("SELECT nom_mun FROM municipio WHERE cve_mun = '".$_SESSION['cliente']['cve_mun']."'")->fetch_assoc()['nom_mun'];
$nom_est = $connection->query("SELECT nom_est FROM estado WHERE cve_est = '".$_SESSION['cliente']['cve_est']."'")->fetch_assoc()['nom_est'];

// Contenido HTML del reporte
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Stock</title>
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

        .stock-agotado {
            background-color: #ffcdd2; /* Rojo */
        }

        /* Estilo para los datos del receptor */
        .receptor-info p {
            margin: 5px 0;
            font-size: 12px; /* Tamaño de fuente para los datos del receptor */
        }
    </style>
</head>
<body>

    <div style="background-color: gray; color: white; text-align: center; padding: 5px; width: 100%; margin-top: 0; font-size: 12px;"> FACTURA ELECTRÓNICA (CFDI) </div>

    <h2>YASUI S.A DE C.V</h2>
    <hr>
    <br>

    <div class="receptor-info">
        <p><strong>FACTURA:</strong> ' . $_SESSION['folio_fac'] . '</p>
    </div>


    <br><br>

    <div class="receptor-info">
        <p><strong>RECPETOR:</strong> ' . strtoupper($_SESSION['cliente']['razs_clie']) . '</p>
        <p><strong>RFC CLIENTE:</strong> ' . strtoupper($_SESSION['cliente']['rfc_clie']) . '</p>
        <p><strong>DIRECCIÓN:</strong> ' . $_SESSION['cliente']['call_clie'] . ' ' . $_SESSION['cliente']['ne_clie'] . '-' . $_SESSION['cliente']['ni_clie'] . ', ' . $_SESSION['cliente']['col_clie'] . ', ' . $_SESSION['cliente']['cp_clie'] . ', ' . $nom_mun . ', ' . $nom_est . '.</p>
        <p><strong>TELÉFONO:</strong> ' . $_SESSION['cliente']['tel_clie'] . '</p>
        <p><strong>USO DE CFDI:</strong> ' . $_SESSION['cliente']['cfdi_clie'] . '</p>
    </div>

    <br>

    <table>
        <thead>
            <tr>
                <th>CANT.</th>
                <th>DESCRIPCIÓN</th>
                <th>PRECIO UNITARIO</th>
                <th>IMPORTE</th>
            </tr>
        </thead>
        <tbody>';

// Inicializar el total
$total = 0;

// Iterar sobre los elementos del carrito_factura
foreach ($_SESSION["factura"] as $cve_inv => $producto) {
    $subtotal = $producto['cant_prend'] * $producto['prec_pren'];
    $total += $subtotal;
    $html .= '
            <tr>
                <td>' . $producto['cant_prend'] . '</td>
                <td>' . $producto['nom_pren'] . '</td>
                <td>$' . $producto['prec_pren'] . '</td>
                <td>$' . ($producto['cant_prend'] * $producto['prec_pren']) . '</td>
            </tr>';
}

// Calcular el subtotal dividido entre 1.16
$subTotalDesglosado = $total / 1.16;

// Continuar con el resto del HTML
$html .= '
        </tbody>
    </table>

    <!-- Sección de Totales -->
    <table class="total-section" style="width: 42%; float: right;">
        <tbody>
            <tr>
                <td colspan="3" align="right">SUBTOTAL:</td>
                <td>$' . number_format($subTotalDesglosado, 2) . '</td>
            </tr>
            <tr>
                <td colspan="3" align="right">IVA (16%):</td>
                <td>$' . number_format(($total - $subTotalDesglosado), 2) . '</td>
            </tr>
            <tr>
                <td colspan="3" align="right">TOTAL:</td>
                <td>$' . number_format($total, 2) . '</td>
            </tr>
            <!-- Puedes agregar más filas para otros campos si es necesario -->
        </tbody>
    </table>


</body>
</html>
';

// Crear una instancia de Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

// Creamos una instancia de Options
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
$dompdf->stream('reporte_stock.pdf', ['Attachment' => 0]);
?>
