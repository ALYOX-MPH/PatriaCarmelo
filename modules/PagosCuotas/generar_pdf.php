<?php
require_once __DIR__ . '/../../vendor/autoload.php';

define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

$mpdf = new Mpdf([
    'default_font' => 'dejavusans', // Fuente más legible
    'margin_top' => 20,
    'margin_bottom' => 20,
]);

$db = new Model_DB();
$conn = $db->connect();

// Obtener ID por GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Datos del seguro
$stmt = $conn->prepare("SELECT * FROM seguros WHERE id = ?");
$stmt->execute([$id]);
$seguro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$seguro) {
    die("No se encontró el registro.");
}

// Datos de pagos
$stmt = $conn->prepare("SELECT fecha, monto FROM pagos WHERE seguro_id = ?");
$stmt->execute([$id]);
$pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Logo y colores del negocio
$logo = __DIR__ . '/../img/LogoPatria.png';

$colorPrimario = "#B22222"; 
$colorSecundario = "#333333"; 
// Contenido HTML del PDF con diseño
$html = "
<style>
    body { font-family: 'DejaVu Sans', sans-serif; }
    .header { text-align: center; border-bottom: 3px solid $colorPrimario; padding-bottom: 10px; margin-bottom: 20px; }
    .header img { max-height: 80px; }
    .header h1 { color: $colorPrimario; margin: 0; }
    .section-title { color: $colorPrimario; font-size: 18px; margin-top: 20px; border-bottom: 1px solid $colorPrimario; padding-bottom: 5px; }
    .info p { margin: 4px 0; font-size: 14px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { background: $colorPrimario; color: white; padding: 8px; font-size: 14px; }
    td { border: 1px solid #ccc; padding: 8px; font-size: 13px; text-align: center; }
</style>

<div class='header'>
    <img src='$logo' alt='Logo' style='width:120px;'>
    <h1>Repuesto Carmelo</h1>
    <p>Resumen del Seguro</p>
</div>

<div class='info'>
    <p><strong>Cliente:</strong> " . htmlspecialchars($seguro["nombre"]) . "</p>
    <p><strong>Vehículo:</strong> " . htmlspecialchars($seguro["tipo_vehiculo"]) . " - " . htmlspecialchars($seguro["marca"]) . "</p>
    <p><strong>Fecha de Creación:</strong> " . htmlspecialchars($seguro["fecha_creacion"]) . "</p>
    <p><strong>Monto Inicial:</strong> RD$" . number_format($seguro["montoInicial"], 2) . "</p>
    <p><strong>Monto Total del Seguro:</strong> RD$" . number_format($seguro["montoSeguro"], 2) . "</p>
    <p><strong>Estado:</strong> " . htmlspecialchars($seguro["estado"]) . "</p>
</div>

<div class='section-title'>Historial de Pagos</div>
<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Monto</th>
            <th>Tipo de Pago</th>
        </tr>
    </thead>
    <tbody>";
        if ($pagos) {
            foreach ($pagos as $pago) {
                $html .= "
                <tr>
                    <td>" . htmlspecialchars($pago["fecha"]) . "</td>
                    <td>RD$" . number_format($pago["monto"], 2) . "</td>
                    <td>" . htmlspecialchars($seguro["tipo_pago"]) . "</td>
                </tr>";
            }
        } else {
            $html .= "<tr><td colspan='3'>No hay pagos registrados</td></tr>";
        }
$html .= "
    </tbody>
</table>
";

// Generar PDF en el navegador
$mpdf->WriteHTML($html);
$mpdf->Output('resumen_seguro_' . $id . '.pdf', 'I'); // 'I' lo abre en navegador
