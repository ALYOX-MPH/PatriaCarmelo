<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // ajustar si la ruta cambia
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php'; // Asegúrate de tener tu archivo de conexión

use Mpdf\Mpdf;

// 1. Obtener datos de la base de datos
$db = new Model_DB();
$conn = $db->connect();
$stmt = $conn->prepare("SELECT * FROM seguros ORDER BY nombre ASC");
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <h1>Reporte de Clientes</h1>
    <table>
        <thead>
            <tr>
                <th>No.Seguro</th>
                <th>Nombre</th>
                <th>Póliza</th>
                <th>Cédula</th>
                <th>Telefono</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody>';

foreach ($clientes as $cliente) {
    $id = $cliente['id'] ?? '';
    $nombre = $cliente['nombre'] ?? '';
    $poliza = $cliente['poliza'] ?? '';
    $cedula = $cliente['cedula'] ?? '';
    $telefono = $cliente['telefono'] ?? '';
    $direccion = $cliente['direccion'] ?? '';
    $secuencia_seguro = $cliente['secuencia_seguro'] ?? '';
    
    $html .= '
        <tr>
            <td>' . htmlspecialchars($secuencia_seguro) . '</td>   
            <td>' . htmlspecialchars($nombre) . '</td>
            <td>' . htmlspecialchars($poliza) . '</td>
            <td>' . htmlspecialchars($cedula) . '</td>
            <td>' . htmlspecialchars($telefono) . '</td>
            <td>' . htmlspecialchars($direccion) . '</td>
        </tr>';
}

$html .= '
        </tbody>
    </table>';

// 4. Escribir el HTML y generar el PDF
$mpdf->WriteHTML($html);

// 5. Salida del PDF al navegador
$mpdf->Output('reporte_de_clientes.pdf', 'I'); // 'I' significa que se mostrará en el navegador
exit;