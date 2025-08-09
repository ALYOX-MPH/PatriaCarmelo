<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../Models/Model_DB.php';

$db = new Model_DB();
$conn = $db->connect();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("UPDATE seguros SET deleted = 1 WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Registro eliminado correctamente'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID inválido'
    ]);
}
