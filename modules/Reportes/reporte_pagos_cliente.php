<?php
// Asegúrate de que las rutas sean correctas
require_once __DIR__ . '/../../vendor/autoload.php';
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

// 1. Obtener todos los pagos de todos los clientes
$db = new Model_DB();
$conn = $db->connect();

// Hacemos un JOIN entre 'seguros' y 'pagos'
$stmt = $conn->prepare("
    SELECT
        s.id AS seguro_id,
        s.nombre AS nombre_cliente,
        s.poliza,
        s.secuencia_seguro,
        s.cedula,
        s.montoSeguro,
        s.estado AS estado_seguro,
        p.id AS pago_id,
        p.monto AS monto_pago,
        p.fecha AS fecha_pago
    FROM seguros s
    JOIN pagos p ON s.id = p.seguro_id
    ORDER BY s.nombre ASC, p.fecha DESC
");
$stmt->execute();
$pagos_totales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2. Agrupar los pagos por cliente para una presentación más legible
$pagos_por_cliente = [];
foreach ($pagos_totales as $pago) {
    $cedula = $pago['cedula'];
    if (!isset($pagos_por_cliente[$cedula])) {
        $pagos_por_cliente[$cedula] = [
            'nombre_cliente' => $pago['nombre_cliente'],
            'pagos' => []
        ];
    }
    $pagos_por_cliente[$cedula]['pagos'][] = $pago;
}

// 3. Crear la instancia de mPDF
$mpdf = new Mpdf();
$html = '
    <style>
        body { font-family: sans-serif; }
        h1 { text-align: center; }
        .cliente-section { margin-top: 30px; border-bottom: 2px solid #ccc; padding-bottom: 10px; }
        .cliente-section h2 { font-size: 1.2em; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 0.9em; }
        th { background-color: #f8f8f8; }
        .total { font-weight: bold; background-color: #e0e0e0; }
    </style>
    <h1>Reporte de Pagos por Cliente (Todos)</h1>';

// 4. Generar el contenido HTML del PDF
foreach ($pagos_por_cliente as $cedula => $datos_cliente) {
    $html .= '<div class="cliente-section">';
    $html .= '<h2>' . htmlspecialchars($datos_cliente['nombre_cliente']) . ' (Cédula: ' . htmlspecialchars($cedula) . ')</h2>';
    $html .= '<table>
                <thead>
                    <tr>
                        <th>ID Pago</th>
                        <th>Fecha Pago</th>
                        <th>Monto Pagado</th>
                        <th>ID Seguro</th>
                        <th>Póliza</th>
                        <th>No. Seguro</th>
                        <th>Estado Seguro</th>
                    </tr>
                </thead>
                <tbody>';

    $totalPagadoCliente = 0;
    foreach ($datos_cliente['pagos'] as $pago) {
        $pago_id = $pago['pago_id'] ?? '';
        $fecha_pago = $pago['fecha_pago'] ?? '';
        $monto_pago = $pago['monto_pago'] ?? 0;
        $seguro_id = $pago['seguro_id'] ?? '';
        $poliza = $pago['poliza'] ?? '';
        $secuencia_seguro = $pago['secuencia_seguro'] ?? '';
        $estado_seguro = $pago['estado_seguro'] ?? '';

        $totalPagadoCliente += (float)$monto_pago;

        $html .= '
            <tr>
                <td>' . htmlspecialchars($pago_id) . '</td>
                <td>' . htmlspecialchars($fecha_pago) . '</td>
                <td>' . htmlspecialchars(number_format($monto_pago, 2)) . '</td>
                <td>' . htmlspecialchars($seguro_id) . '</td>
                <td>' . htmlspecialchars($poliza) . '</td>
                <td>' . htmlspecialchars($secuencia_seguro) . '</td>
                <td>' . htmlspecialchars($estado_seguro) . '</td>
            </tr>';
    }

    $html .= '
            <tr class="total">
                <td colspan="2" style="text-align: right;">Total Pagado por este Cliente:</td>
                <td>' . htmlspecialchars(number_format($totalPagadoCliente, 2)) . '</td>
                <td colspan="4"></td>
            </tr>
        </tbody>
    </table></div>';
}

// 5. Escribir el HTML y generar el PDF
$mpdf->WriteHTML($html);

// 6. Salida del PDF al navegador
$mpdf->Output('reporte_de_pagos_por_cliente.pdf', 'I');
exit;