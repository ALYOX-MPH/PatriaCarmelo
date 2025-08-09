<?php 
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // <--- ESTA LÍNEA ES CLAVE

define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

$db = new Model_DB();
$conn = $db->connect();

// Recibir los datos en formato JSON
$data = json_decode(file_get_contents('php://input'), true);
// var_dump($data);
$seguroId =  isset($data['seguro_id']) ? $data['seguro_id'] : 0;
$monto = $data['monto'];
$montoInicial = $data['montoInicial'] ?? 0; // Si no se envía, se asume 0

// Verificar que los datos estén completos
if (!$seguroId || !$monto || $monto <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos.']);
    exit;
}

// 1. Insertar el nuevo pago
$stmtInsert = $conn->prepare("INSERT INTO pagos (seguro_id, monto) VALUES (?, ?)");
$stmtInsert->execute([$seguroId, $monto]);

// 2. Obtener el montoInicial actual del seguro
$stmtActual = $conn->prepare("SELECT montoInicial, montoSeguro FROM seguros WHERE id = ?");
$stmtActual->execute([$seguroId]);
$seguro = $stmtActual->fetch(PDO::FETCH_ASSOC);

$montoInicialActual = $seguro['montoInicial'] ?? 0;
$montoSeguro = $seguro['montoSeguro'] ?? 0;

// 3. Sumar el nuevo pago al montoInicial
$nuevoMontoInicial = $montoInicialActual + $monto;

// 4. Determinar el estado según el nuevo monto total pagado
$estado = ($nuevoMontoInicial >= $montoSeguro) ? 'Pagado' : 'En proceso';

// 5. Actualizar el seguro con el nuevo montoInicial y estado
$stmtUpdate = $conn->prepare("UPDATE seguros SET montoInicial = ?, estado = ? WHERE id = ?");
$stmtUpdate->execute([$nuevoMontoInicial, $estado, $seguroId]);

// 6. Respuesta
echo json_encode([
    'mensaje' => 'Pago registrado con éxito',
    'totalPagado' => $nuevoMontoInicial,
    'estado' => $estado
]);
