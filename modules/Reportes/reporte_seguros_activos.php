<?php
// Asegúrate de que las rutas sean correctas
require_once __DIR__ . '/../../vendor/autoload.php';
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

// 1. Obtener los seguros activos de la base de datos
// Filtramos por seguros que no estén vencidos, cancelados y no estén borrados.
$db = new Model_DB();
$conn = $db->connect();
$stmt = $conn->prepare("
    SELECT 
        id, 
        nombre, 
        poliza, 
        cedula, 
        secuencia_seguro,
        montoSeguro, 
        estado, 
        fecha_creacion
    FROM seguros 
    WHERE estado != 'Vencido' AND estado != 'Cancelado' AND deleted = 0
    ORDER BY fecha_creacion DESC
");
$stmt->execute();
$seguros_activos = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <h1>Reporte de Seguros Activos</h1>';

if (empty($seguros_activos)) {
    $html .= '<p style="text-align: center; margin-top: 50px;">No hay seguros activos en este momento. ✅</p>';
} else {
    $html .= '
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>No. Póliza</th>
                <th>No. Seguro</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($seguros_activos as $seguro) {
        // Usamos el operador ?? para manejar valores nulos y evitar errores
        $id = $seguro['id'] ?? '';
        $nombre = $seguro['nombre'] ?? '';
        $cedula = $seguro['cedula'] ?? '';
        $poliza = $seguro['poliza'] ?? '';
        $secuencia_seguro = $seguro['secuencia_seguro'] ?? '';
        $montoSeguro = $seguro['montoSeguro'] ?? '';
        $estado = $seguro['estado'] ?? '';
        $fecha_creacion = $seguro['fecha_creacion'] ?? '';

        $html .= '
            <tr>
                <td>' . htmlspecialchars($id) . '</td>
                <td>' . htmlspecialchars($nombre) . '</td>
                <td>' . htmlspecialchars($cedula) . '</td>
                <td>' . htmlspecialchars($poliza) . '</td>
                <td>' . htmlspecialchars($secuencia_seguro) . '</td>
                <td>' . htmlspecialchars(number_format($montoSeguro, 2)) . '</td>
                <td>' . htmlspecialchars($estado) . '</td>
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
$mpdf->Output('reporte_seguros_activos.pdf', 'I');
exit;