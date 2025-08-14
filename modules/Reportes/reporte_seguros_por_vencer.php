<?php
// Asegúrate de que las rutas sean correctas
require_once __DIR__ . '/../../vendor/autoload.php';
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

// 1. Obtener los seguros que están próximos a vencer
// Filtramos por seguros cuyo estado sea 'Por Vencer' y que no estén borrados.
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
    WHERE estado = 'Por Vencer' AND deleted = 0
    ORDER BY fecha_creacion DESC
");
$stmt->execute();
$seguros_por_vencer = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <h1>Reporte de Seguros por Vencer</h1>';

if (empty($seguros_por_vencer)) {
    $html .= '<p style="text-align: center; margin-top: 50px;">No hay seguros por vencer en este momento. 🥳</p>';
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

    foreach ($seguros_por_vencer as $seguro) {
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
$mpdf->Output('reporte_seguros_por_vencer.pdf', 'I');
exit;