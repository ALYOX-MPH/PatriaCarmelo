<?php
// imprimir_recibo.php
require_once __DIR__ . '/../../vendor/autoload.php'; // ajustar si la ruta cambia
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

$mpdf = new Mpdf([
    'default_font' => 'dejavusans',
    'margin_top' => 18,
    'margin_bottom' => 18,
]);

$db = new Model_DB();
$conn = $db->connect();

// Obtener ID del seguro (seguro_id)
$seguro_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($seguro_id <= 0) {
    die("ID de seguro no válido.");
}

// Obtener datos del seguro
$stmt = $conn->prepare("SELECT id, nombre, poliza, cedula, tipo_vehiculo, marca, fecha_creacion, montoInicial, montoSeguro, estado, tipo_pago FROM seguros WHERE id = ?");
$stmt->execute([$seguro_id]);
$seguro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$seguro) {
    die("No se encontró el seguro solicitado.");
}

// Obtener ÚLTIMO pago para ese seguro
$stmt = $conn->prepare("SELECT id, monto, fecha FROM pagos WHERE seguro_id = ? ORDER BY fecha DESC LIMIT 1");
$stmt->execute([$seguro_id]);
$pago = $stmt->fetch(PDO::FETCH_ASSOC);

// Ruta del logo (ruta absoluta del sistema). Ajusta si tu logo está en otra carpeta.
$logoPath = __DIR__ . '/../img/LogoPatria.png';
if (!file_exists($logoPath)) {
    // Si no existe, opcionalmente define una URL pública o deja vacío
    $logoPath = '';
}

// preparar variables para insertar en HTML
$nombreCliente = htmlspecialchars($seguro['nombre']);
$poliza = htmlspecialchars($seguro['poliza'] ?? '');
$cedula = htmlspecialchars($seguro['cedula'] ?? '');
$vehiculo = htmlspecialchars(($seguro['tipo_vehiculo'] ?? '') . ' - ' . ($seguro['marca'] ?? ''));
$fechaCreacion = !empty($seguro['fecha_creacion']) ? date('d/m/Y', strtotime($seguro['fecha_creacion'])) : '';
$montoInicial = isset($seguro['montoInicial']) ? number_format($seguro['montoInicial'], 2) : '0.00';
$montoSeguro = isset($seguro['montoSeguro']) ? number_format($seguro['montoSeguro'], 2) : '0.00';
$estado = htmlspecialchars($seguro['estado'] ?? '');
$tipoPagoSeguro = htmlspecialchars($seguro['tipo_pago'] ?? '');

// último pago
if ($pago) {
    $pagoId = intval($pago['id']);
    $pagoMonto = number_format($pago['monto'], 2);
    $pagoFecha = !empty($pago['fecha']) ? date('d/m/Y', strtotime($pago['fecha'])) : '';
} else {
    $pagoId = null;
    $pagoMonto = '0.00';
    $pagoFecha = '';
}

// nombre archivo
$filename = "recibo_pago_{$seguro_id}";
if ($pagoId) $filename .= "_{$pagoId}";
$filename .= ".pdf";

// HTML del recibo (diseño formal y centrado)
$colorPrimario = "#B22222";
$colorSecundario = "#333333";

$html = <<<HTML
<style>
    body { font-family: 'DejaVu Sans', sans-serif; color: #222; }
    .container { max-width: 720px; margin: 0 auto; padding: 10px; }
    .header { text-align: center; border-bottom: 4px solid {$colorPrimario}; padding-bottom: 12px; margin-bottom: 12px; }
    .header img { max-height: 80px; display:block; margin: 0 auto 8px auto; }
    .company { font-size: 20px; font-weight:700; color: {$colorPrimario}; margin:0; }
    .subtitle { font-size: 12px; color: {$colorSecundario}; margin:4px 0 0 0; }
    .title { text-align:center; margin-top:14px; font-size:18px; font-weight:700; color:{$colorSecundario}; }
    .info { margin-top: 12px; font-size:13px; }
    .info .row { display:flex; justify-content:space-between; margin:6px 0; }
    .box { border:1px solid #e0e0e0; padding:10px; border-radius:6px; background:#fafafa; }
    .receipt-data { margin-top:12px; }
    table { width:100%; border-collapse: collapse; margin-top: 10px; }
    th { background: {$colorPrimario}; color:#fff; padding:8px; font-size:13px; text-align:left; }
    td { border:1px solid #e6e6e6; padding:10px; font-size:13px; vertical-align:top; }
    .right { text-align:right; }
    .signature { margin-top: 28px; display:flex; justify-content:space-between; align-items:center; }
    .firma-line { width:40%; text-align:center; border-top:1px solid #000; padding-top:6px; color:#444; }
    .small { font-size:11px; color:#666; }
</style>

<div class="container">
    <div class="header">
HTML;

if ($logoPath !== '') {
    // mPDF acepta rutas de sistema de archivos
    $html .= "<img src=\"{$logoPath}\" style=\"width:150px;\" alt=\"Logo\" />";
}

$html .= <<<HTML
        <div class="company">Repuesto Carmelo</div>
        <div class="subtitle">Comprobante de Pago - Recibo Oficial</div>
    </div>

    <div class="title">RECIBO DE PAGO</div>

    <div class="info">
        <div class="row">
            <div><strong>Cliente:</strong> {$nombreCliente}</div>
            <div><strong>Fecha:</strong> {$pagoFecha}</div>
        </div>
        <div class="row">
            <div><strong>Póliza:</strong> {$poliza}</div>
            <div><strong>Cédula:</strong> {$cedula}</div>
        </div>
        <div class="row">
            <div><strong>Vehículo:</strong> {$vehiculo}</div>
            <div><strong>Estado:</strong> {$estado}</div>
        </div>
    </div>

    <div class="receipt-data box">
        <table>
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th class="right">Monto (RD$)</th>
                </tr>
            </thead>
            <tbody>
HTML;

if ($pago) {
    $html .= "
                <tr>
                    <td>Pago recibido (ID: {$pagoId})</td>
                    <td class='right'>{$pagoMonto}</td>
                </tr>";
} else {
    $html .= "
                <tr>
                    <td colspan='2'>No se encontró registro de pagos para este seguro.</td>
                </tr>";
}

$html .= <<<HTML
            </tbody>
        </table>

        <div style="display:flex; justify-content:flex-end; margin-top:12px;">
            <div style="text-align:right;">
                <div class="small">Total</div>
                <div style="font-weight:700; font-size:16px;">RD$ {$pagoMonto}</div>
            </div>
        </div>
    </div>

    <div class="signature">
        <div class="firma-line">Recibido por</div>
        <div class="firma-line">Firma cliente</div>
    </div>

    <p class="small" style="margin-top:12px;">Este comprobante sirve como constancia de pago para los fines correspondientes. Guardar este recibo.</p>
</div>
HTML;

// Escribir y forzar impresión automática
$mpdf->WriteHTML($html);

// Forzar la apertura del diálogo de impresión automático (funciona si el visor soporta JS in PDF)
$mpdf->SetJS('this.print();');

// Mostrar inline en el navegador (si lo abres con target="_blank" se abrirá en nueva pestaña)
$mpdf->Output($filename, 'I');
exit;
