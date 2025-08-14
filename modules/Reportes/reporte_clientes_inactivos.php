<?php
// Asegúrate de que las rutas sean correctas
require_once __DIR__ . '/../../vendor/autoload.php';
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

// 1. Obtener los clientes sin pagos registrados
$db = new Model_DB();
$conn = $db->connect();
$stmt = $conn->prepare("
    SELECT
        s.id,
        s.nombre,
        s.cedula,
        s.poliza,
        s.fecha_creacion
    FROM seguros s
    LEFT JOIN pagos p ON s.id = p.seguro_id
    WHERE p.id IS NULL AND s.deleted = 0
    GROUP BY s.id
    ORDER BY s.fecha_creacion DESC
");
$stmt->execute();
$clientes_inactivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <h1>Reporte de Clientes Inactivos</h1>';

if (empty($clientes_inactivos)) {
    $html .= '<p style="text-align: center; margin-top: 50px;">¡Excelente! Todos los clientes han realizado al menos un pago. ✅</p>';
} else {
    $html .= '
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Cliente</th>
                <th>Cédula</th>
                <th>Póliza</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($clientes_inactivos as $cliente) {
        // Usamos el operador ?? para manejar valores nulos y evitar errores
        $id = $cliente['id'] ?? '';
        $nombre = $cliente['nombre'] ?? '';
        $cedula = $cliente['cedula'] ?? '';
        $poliza = $cliente['poliza'] ?? '';
        $fecha_creacion = $cliente['fecha_creacion'] ?? '';

        $html .= '
            <tr>
                <td>' . htmlspecialchars($id) . '</td>
                <td>' . htmlspecialchars($nombre) . '</td>
                <td>' . htmlspecialchars($cedula) . '</td>
                <td>' . htmlspecialchars($poliza) . '</td>
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
$mpdf->Output('reporte_clientes_inactivos.pdf', 'I');
exit;