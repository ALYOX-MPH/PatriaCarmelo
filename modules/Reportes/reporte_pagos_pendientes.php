<?php
// Asegúrate de que las rutas sean correctas
require_once __DIR__ . '/../../vendor/autoload.php';
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

// 1. Obtener datos de la base de datos
// Seleccionamos los clientes cuyo estado no está como 'Pagado' o 'Completo'
$db = new Model_DB();
$conn = $db->connect();
$stmt = $conn->prepare("
    SELECT 
        id, 
        nombre, 
        poliza, 
        cedula, 
        telefono, 
        montoSeguro, 
        montoInicial, 
        estado, 
        fecha_creacion
    FROM seguros 
    WHERE estado = 'En proceso' OR estado = 'Pendiente'
    ORDER BY fecha_creacion DESC
");
$stmt->execute();
$pagos_pendientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <h1>Reporte de Pagos Pendientes</h1>';

if (empty($pagos_pendientes)) {
    $html .= '<p style="text-align: center; margin-top: 50px;">No hay pagos pendientes en este momento. ✨</p>';
} else {
    $html .= '
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Póliza</th>
                <th>Monto Seguro</th>
                <th>Monto Inicial</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($pagos_pendientes as $pago) {
        // Usamos el operador ?? para manejar valores nulos y evitar errores
        $id = $pago['id'] ?? '';
        $nombre = $pago['nombre'] ?? '';
        $cedula = $pago['cedula'] ?? '';
        $poliza = $pago['poliza'] ?? '';
        $montoSeguro = $pago['montoSeguro'] ?? '';
        $montoInicial = $pago['montoInicial'] ?? '';
        $fecha_creacion = $pago['fecha_creacion'] ?? '';

        $html .= '
            <tr>
                <td>' . htmlspecialchars($id) . '</td>
                <td>' . htmlspecialchars($nombre) . '</td>
                <td>' . htmlspecialchars($cedula) . '</td>
                <td>' . htmlspecialchars($poliza) . '</td>
                <td>' . htmlspecialchars(number_format($montoSeguro, 2)) . '</td>
                <td>' . htmlspecialchars(number_format($montoInicial, 2)) . '</td>
                <td>' . htmlspecialchars($fecha_creacion) . '</td>
            </tr>';
    }

    $html .= '
        </tbody>
    </table>';
}

// 4. Escribir el HTML y generar el PDF
$mpdf->WriteHTML($html);

// 5. Salida del PDF al navegador
$mpdf->Output('reporte_pagos_pendientes.pdf', 'I');
exit;