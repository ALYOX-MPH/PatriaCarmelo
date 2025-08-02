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
$seguroId = $data['seguro_id'];
$monto = $data['monto'];

// Verificar que los datos estén completos
if (!$seguroId || !$monto || $monto <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos.']);
    exit;
}

// 1. Insertar el pago
$stmtInsert = $conn->prepare("INSERT INTO pagos (seguro_id, monto) VALUES (?, ?)");
$stmtInsert->execute([$seguroId, $monto]);

// 2. Calcular la suma total de los pagos hechos
$stmtSuma = $conn->prepare("SELECT SUM(monto) as totalPagado FROM pagos WHERE seguro_id = ?");
$stmtSuma->execute([$seguroId]);
$totalPagado = $stmtSuma->fetch(PDO::FETCH_ASSOC)['totalPagado'] ?? 0;

// 3. Obtener el monto total del seguro
$stmtSeguro = $conn->prepare("SELECT montoSeguro FROM seguros WHERE id = ?");
$stmtSeguro->execute([$seguroId]);
$montoSeguro = $stmtSeguro->fetch(PDO::FETCH_ASSOC)['montoSeguro'] ?? 0;

// 4. Determinar el estado (Pagado o En proceso)
$estado = ($totalPagado >= $montoSeguro) ? 'Pagado' : 'En proceso';

// 5. Actualizar el seguro con nuevo montoInicial y estado
$stmtUpdate = $conn->prepare("UPDATE seguros SET montoInicial = ?, estado = ? WHERE id = ?");
$stmtUpdate->execute([$totalPagado, $estado, $seguroId]);

// 6. Devolver respuesta
echo json_encode([
    'mensaje' => 'Pago registrado con éxito',
    'totalPagado' => $totalPagado,
    'estado' => $estado
]);
