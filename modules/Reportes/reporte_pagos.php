<?php
// Asegúrate de que las rutas sean correctas
require_once __DIR__ . '/../../vendor/autoload.php';
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

// 1. Obtener datos de la base de datos
// Seleccionamos los datos relevantes de la tabla `seguros` que representan los pagos.
$db = new Model_DB();
$conn = $db->connect();
$stmt = $conn->prepare("
    SELECT 
        id, 
        nombre, 
        poliza, 
        montoSeguro, 
        montoInicial, 
        estado, 
        tipo_pago,
        fecha_creacion
    FROM seguros 
    ORDER BY fecha_creacion DESC
");
$stmt->execute();
$pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2. Crear la instancia de mPDF
$mpdf = new Mpdf();

// 3. Generar el contenido HTML del PDF
$html = '
    <style>
        body { font-family: sans-serif; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
    <h1>Reporte de Pagos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Póliza</th>
                <th>Monto Seguro</th>
                <th>Monto Inicial</th>
                <th>Estado</th>
                <th>Tipo de Pago</th>
            </tr>
        </thead>
        <tbody>';

foreach ($pagos as $pago) {
    // Usamos el operador ?? para manejar valores nulos y evitar el error "Deprecated"
    $id = $pago['id'] ?? '';
    $nombre = $pago['nombre'] ?? '';
    $poliza = $pago['poliza'] ?? '';
    $montoSeguro = $pago['montoSeguro'] ?? '';
    $montoInicial = $pago['montoInicial'] ?? '';
    $estado = $pago['estado'] ?? '';
    $tipo_pago = $pago['tipo_pago'] ?? '';

    $html .= '
        <tr>
            <td>' . htmlspecialchars($id) . '</td>
            <td>' . htmlspecialchars($nombre) . '</td>
            <td>' . htmlspecialchars($poliza) . '</td>
            <td>' . htmlspecialchars($montoSeguro) . '</td>
            <td>' . htmlspecialchars($montoInicial) . '</td>
            <td>' . htmlspecialchars($estado) . '</td>
            <td>' . htmlspecialchars($tipo_pago) . '</td>
        </tr>';
}

$html .= '
        </tbody>
    </table>';

// 4. Escribir el HTML y generar el PDF
$mpdf->WriteHTML($html);

// 5. Salida del PDF al navegador
// El segundo parámetro 'I' (Inline) hace que el PDF se muestre en el navegador.
// Cambia a 'D' (Download) si quieres que se descargue directamente.
$mpdf->Output('reporte_de_pagos.pdf', 'I');
exit;