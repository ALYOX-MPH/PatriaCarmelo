<?php
// Asegúrate de que las rutas sean correctas
require_once __DIR__ . '/../../vendor/autoload.php';
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

// 1. Obtener la cantidad de seguros por tipo de vehículo
$db = new Model_DB();
$conn = $db->connect();
$stmt = $conn->prepare("
    SELECT
        tipo_vehiculo,
        COUNT(id) AS total_seguros
    FROM seguros
    GROUP BY tipo_vehiculo
    ORDER BY total_seguros DESC
");
$stmt->execute();
$seguros_por_tipo = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <h1>Reporte de Seguros por Tipo de Vehículo</h1>';

if (empty($seguros_por_tipo)) {
    $html .= '<p style="text-align: center; margin-top: 50px;">No hay seguros registrados para ningún tipo de vehículo. 🚗</p>';
} else {
    $html .= '
    <table>
        <thead>
            <tr>
                <th>Tipo de Vehículo</th>
                <th>Cantidad de Seguros</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($seguros_por_tipo as $tipo) {
        // Usamos el operador ?? para manejar valores nulos y evitar errores
        $tipo_vehiculo = $tipo['tipo_vehiculo'] ?? 'Sin especificar';
        $total_seguros = $tipo['total_seguros'] ?? 0;

        $html .= '
            <tr>
                <td>' . htmlspecialchars($tipo_vehiculo) . '</td>
                <td>' . htmlspecialchars($total_seguros) . '</td>
            </tr>';
    }

    $html .= '
        </tbody>
    </table>';
}

// 4. Escribir el HTML y generar el PDF
$mpdf->WriteHTML($html);

// 5. Salida del PDF al navegador
$mpdf->Output('reporte_seguros_por_tipo_vehiculo.pdf', 'I');
exit;