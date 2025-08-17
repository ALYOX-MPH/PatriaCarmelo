<?php
require_once __DIR__ . '/../../vendor/autoload.php';
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

use Mpdf\Mpdf;

if (!isset($_GET['id'])) {
    die("ID de seguro no especificado.");
}

$id_seguro = $_GET['id'];

// Obtener datos del seguro
$db = new Model_DB();
$conn = $db->connect();
$stmt = $conn->prepare("SELECT * FROM seguros WHERE id = :id AND deleted = 0");
$stmt->execute(['id' => $id_seguro]);
$seguro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$seguro) {
    die("Seguro no encontrado o ha sido eliminado.");
}

// Convertir fecha de creación a objeto de fecha para el cálculo de vigencia
$fecha_creacion = new DateTime($seguro['fecha_creacion'] ?? 'now');
$fecha_vencimiento = clone $fecha_creacion;
$fecha_vencimiento->modify('+1 year -1 day');

// Formatear las fechas para la impresión
$vigencia_inicio = $fecha_creacion->format('d/m/Y');
$vigencia_fin = $fecha_vencimiento->format('d/m/Y');

// Configuración de mPDF para el tamaño de una tarjeta (cédula)
// Dimensiones: 85.6mm x 53.98mm
$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => [85.6, 63.98],
    'margin_left' => 3,
    'margin_right' => 3,
    'margin_top' => 3,
    'margin_bottom' => 3,
]);

$logo = __DIR__ . '/../img/LogoPatria.png';
// Estilo del ticket para que se parezca a la imagen
$html = '
    <style>
        body { font-family: sans-serif; font-size: 8px; margin: 0; padding: 0; }
        .ticket {
            width: 100%;
            height: 100%;
            border: 1px solid #000000ff;
            border-radius: 5px;
            padding: 5px;
            box-sizing: border-box;
            background-color: #f7f7f7;
            position: relative;
            display: flex;
            flex-direction: column;
            padding-left: 10px;
        }
        .header-logo {
            text-align: left;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 5px;
        }
        .header-logo img {
            height: 15px; 
        }
        .data-grid {
            display: grid;
            grid-template-columns: 1fr 1fr ;
            gap: 5px;
            width: 100%;
        }
        .data-item {
            margin-bottom: 2px;
            display: flex;
            flex-direction: column;
        }
        .label {
            font-weight: bold;
            color: #000000ff;
            text-transform: uppercase;
            font-size: 10px;
            
        }
        .value {
            font-size: 10px;
            font-weight: normal;
        }
    </style>
    <div class="ticket">
        <div class="header-logo">
            <img src="' . $logo . '" style="max-height: 30px;" alt="Logo de PATRIA">
        </div>
        <div class="data-grid">
            <div class="data-item">
                <span class="label">Cliente:</span>
                <span class="value">' . htmlspecialchars($seguro['nombre'] ?? '') . '</span>
            </div>
            <div class="data-item">
                <span class="label">Servicio:</span>
                <span class="value">' . htmlspecialchars($seguro['servicio'] ?? '') . '</span>
            </div>
            <div class="data-item">
                <span class="label">Póliza:</span>
                <span class="value">' . htmlspecialchars($seguro['poliza'] ?? '') . '</span>
            </div>
            <div class="data-item">
                <span class="label">Marca:</span>
                <span class="value">' . htmlspecialchars($seguro['marca'] ?? '') . '</span>
            </div>
            <div class="data-item">
                <span class="label">Tipo:</span>
                <span class="value">' . htmlspecialchars($seguro['tipo_vehiculo'] ?? '') . '</span>
            </div>
            <div class="data-item">
                <span class="label">Año:</span>
                <span class="value">' . htmlspecialchars($seguro['ano'] ?? '') . '</span>
            </div>
            <div class="data-item">
                <span class="label">Chasis:</span>
                <span class="value">' . htmlspecialchars($seguro['chasisVehiculo'] ?? '') . '</span>
            </div>
            <div class="data-item">
                <span class="label">Intermediario:</span>
                <span class="value">Carmelo Plazencia Acosta</span>
            </div>
            <div class="data-item">
                <span class="label">Placa:    </span>
                <span class="value">' . htmlspecialchars($seguro['placa'] ?? '') . '</span>
            </div>
            <div class="data-item">
                <span class="label">Vigencia:</span>
                <span class="value">' . $vigencia_inicio . ' – ' . $vigencia_fin . '</span>
            </div>

            <div class="data-item">
                <span class="label">Observacion:</span>
                <span class="value"></span>
            </div>
        </div>
    </div>';

$mpdf->WriteHTML($html);
$mpdf->Output('ticket_' . $id_seguro . '.pdf', 'I');
exit;