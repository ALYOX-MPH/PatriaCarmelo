<?php
define('ROOT', dirname(__DIR__,2));
require_once ROOT . '/Models/Model_DB.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID no válido.";
    exit;
}

$db = new Model_DB();
$conn = $db->connect();

// Obtener datos del cliente
$stmt = $conn->prepare("SELECT * FROM seguros WHERE id = :id");
$stmt->execute(['id' => $id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    echo "Cliente no encontrado.";
    exit;
}

// Obtener pagos del cliente
$stmtPagos = $conn->prepare("SELECT * FROM pagos WHERE seguro_id = :id");
$stmtPagos->execute(['id' => $id]);
$pagos = $stmtPagos->fetchAll(PDO::FETCH_ASSOC);


?>
<?php include 'modules/layout/header.php'; ?>
    <title>Detalles del Cliente</title>
<style>
         body {
      background-color: #f5f5f5;
      color: #333;
    }

    .sidebar {
      width: 280px;
      height: 100vh;
      position: fixed;
      background-color: #1c1f22ff;
    }

    .main-content {
      margin-left: 280px;
      padding: 20px;
      max-width: 1650px;
    }

    .card {
      background-color: #fff;
      border: none;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .text-small {
      font-size: 0.9rem;
    }
    </style>
<body>
    <!-- Sidebar -->
     <?php include 'modules/layout/sidebar.php'; ?>
    <div class="">
    
        
    <div class="main-content">
        <div class="row">
            <h2 class="col-9 fs-1">Detalles del Cliente</h2>
            <a href="registros.php" class=" col-3 btn btn-danger mb-4">Volver a registros</a></div>

    <div class="card p-4 mb-4">
        <h1>Información de Seguro</h1>
        <p class="fs-4"><strong>Tipo de Seguro:</strong> <?= $cliente['tipoSeguro'] ?></p>
        <p class="fs-4"><strong>Monto Total:</strong> RD$<?= number_format($cliente['montoSeguro'], 2) ?></p>
        <p class="fs-4"><strong>Monto Inicial:</strong> RD$<?= number_format($cliente['montoInicial'], 2) ?></p>
        <p class="fs-4"><strong>Tipo de Pago:</strong> <?= $cliente['tipo_pago'] ?></p>
        <p class="fs-4"><strong>Estado:</strong> <?= $cliente['estado'] ?></p>
    </div>

    <div class="card p-4">
        <h1>Historial de Pagos</h1>
        <?php if (count($pagos) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="fs-4">Fecha</th>
                        <th class="fs-4">Monto</th>
                        <th class="fs-4">Tipo de pago</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pagos as $pago): ?>
                        <tr>
                            <td><?= $pago['fecha'] ?></td>
                            <td>RD$<?= number_format($pago['monto'], 2) ?></td>
                            <td><?= $cliente['tipo_pago'] ?></td>   
                        </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay pagos registrados.</p>
        <?php endif; ?>
    </div>

    
</div>
</div>
</body>
<?php include 'modules/layout/footer.php'; ?>
