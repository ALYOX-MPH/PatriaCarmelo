<?php
// Asegúrate de que las rutas sean correctas
require_once __DIR__ . '/../../vendor/autoload.php';
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

// 1. Obtener los ingresos mensuales de la base de datos
$db = new Model_DB();
$conn = $db->connect();
$stmt = $conn->prepare("
    SELECT 
        YEAR(fecha) AS anio,
        MONTH(fecha) AS mes,
        SUM(monto) AS total_ingresos
    FROM pagos
    GROUP BY anio, mes
    ORDER BY anio ASC, mes ASC
");
$stmt->execute();
$ingresos_mensuales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mapeo de números de mes a nombres en español
$meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];

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
    <h1>Reporte de Ingresos Mensuales</h1>';

if (empty($ingresos_mensuales)) {
    $html .= '<p style="text-align: center; margin-top: 50px;">No hay ingresos registrados en la base de datos. 📈</p>';
} else {
    $html .= '
    <table>
        <thead>
            <tr>
                <th>Año</th>
                <th>Mes</th>
                <th>Total de Ingresos</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($ingresos_mensuales as $ingreso) {
        // Usamos el operador ?? para manejar valores nulos y evitar errores
        $anio = $ingreso['anio'] ?? '';
        $mes_numero = $ingreso['mes'] ?? '';
        $mes_nombre = $meses[$mes_numero] ?? ''; // Usamos el array para obtener el nombre del mes
        $total_ingresos = $ingreso['total_ingresos'] ?? 0;

        $html .= '
            <tr>
                <td>' . htmlspecialchars($anio) . '</td>
                <td>' . htmlspecialchars($mes_nombre) . '</td>
                <td>' . htmlspecialchars(number_format($total_ingresos, 2)) . '</td>
            </tr>';
    }

    $html .= '
        </tbody>
    </table>';
}

// 4. Escribir el HTML y generar el PDF
$mpdf->WriteHTML($html);

// 5. Salida del PDF al navegador
$mpdf->Output('reporte_ingresos_mensuales.pdf', 'I');
exit;