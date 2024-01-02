<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL);

// Importamos la biblioteca Dompdf, para procesar el HTML/PDF y generar el PDF
require_once 'dompdf/vendor/autoload.php';
include 'php/functions.php';

$stock_agotado= stockAgotado();
$stock_disponible = stockDisponible();

$total_productos1 = mysqli_num_rows($stock_agotado);
$total_productos2 = mysqli_num_rows($stock_disponible);

// Contenido HTML del reporte
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Stock Disponible en Cada Sucursal</title>
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
    <h2>Reporte de Stock Disponible en Cada Sucursal</h2>
    <p>Empresa: Yasui</p>
    <p>Fecha de Generación: ' . date("Y-m-d") . '</p>
    <hr>
    
    <h4>Stock Agotado</h4>
    <p>Productos Mostrados: ' . $total_productos1 . '</p>
    
    <table>
        <thead>
            <tr>
                <th>Sucursal</th>
                <th>Prenda</th>
                <th>Talla</th>
                <th>Marca</th>
                <th>Existencias</th>
            </tr>
        </thead>
        <tbody>';
            
        if (isset($_GET['tipo_reporte'])) {

            while ($row = mysqli_fetch_array($stock_agotado)) {
                $html .= '
                <tr>
                <td>' . $row['nom_suc'] . '</td>
                <td>' . $row['nom_pren'] . '</td>
                <td>' . $row['tall_pren'] . '</td>
                <td>' . $row['nom_marca'] . '</td>
                <td>' . $row['exist_pren'] . '</td>
                </tr>';
            }
        }
       
$html .= '
        </tbody>
    </table>
    

    <h4>Stock Disponible</h4>
    <p>Productos Mostrados: ' . $total_productos2 . '</p>

    <table>
        <thead>
            <tr>
                <th>Sucursal</th>
                <th>Prenda</th>
                <th>Talla</th>
                <th>Marca</th>
                <th>Existencias</th>
            </tr>
        </thead>
        <tbody>';
        if (isset($_GET['tipo_reporte'])) {

            while ($row = mysqli_fetch_array($stock_disponible)) {
                $html .= '
                <tr>
                <td>' . $row['nom_suc'] . '</td>
                <td>' . $row['nom_pren'] . '</td>
                <td>' . $row['tall_pren'] . '</td>
                <td>' . $row['nom_marca'] . '</td>
                <td>' . $row['exist_pren'] . '</td>
                </tr>';
            }
        }
       
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