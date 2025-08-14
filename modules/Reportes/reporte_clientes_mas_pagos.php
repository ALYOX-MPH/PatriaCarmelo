<?php
// Asegúrate de que las rutas sean correctas
require_once __DIR__ . '/../../vendor/autoload.php';
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

// 1. Obtener el ranking de clientes por número de pagos
$db = new Model_DB();
$conn = $db->connect();
$stmt = $conn->prepare("
    SELECT
        s.nombre,
        s.cedula,
        COUNT(p.id) AS total_pagos
    FROM seguros s
    JOIN pagos p ON s.id = p.seguro_id
    GROUP BY s.id
    ORDER BY total_pagos DESC
");
$stmt->execute();
$ranking_clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <h1>Ranking de Clientes con Más Pagos</h1>';

if (empty($ranking_clientes)) {
    $html .= '<p style="text-align: center; margin-top: 50px;">No hay pagos registrados para crear un ranking. 📊</p>';
} else {
    $html .= '
    <table>
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Nombre del Cliente</th>
                <th>Cédula</th>
                <th>Total de Pagos</th>
            </tr>
        </thead>
        <tbody>';

    $rank = 1;
    foreach ($ranking_clientes as $cliente) {
        // Usamos el operador ?? para manejar valores nulos y evitar errores
        $nombre = $cliente['nombre'] ?? '';
        $cedula = $cliente['cedula'] ?? '';
        $total_pagos = $cliente['total_pagos'] ?? 0;

        $html .= '
            <tr>
                <td>' . htmlspecialchars($rank) . '</td>
                <td>' . htmlspecialchars($nombre) . '</td>
                <td>' . htmlspecialchars($cedula) . '</td>
                <td>' . htmlspecialchars($total_pagos) . '</td>
            </tr>';
        $rank++;
    }

    $html .= '
        </tbody>
    </table>';
}

// 4. Escribir el HTML y generar el PDF
$mpdf->WriteHTML($html);

// 5. Salida del PDF al navegador
$mpdf->Output('reporte_clientes_con_mas_pagos.pdf', 'I');
exit;