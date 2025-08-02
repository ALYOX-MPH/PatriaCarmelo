
<?php
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

$db = new Model_DB();
$conn = $db->connect();

$busqueda = $_GET['buscar'] ?? '';

if ($busqueda) {
    $stmt = $conn->prepare("SELECT * FROM seguros WHERE nombre LIKE :buscar OR modelo LIKE :buscar OR marca LIKE :buscar");
    $stmt->execute(['buscar' => "%$busqueda%"]);
} else {
    $stmt = $conn->prepare("SELECT * FROM seguros");
    $stmt->execute();
}

$seguros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creacion de Seguros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

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
</head>
<body>
    <!-- Sidebar -->
  <div class="sidebar text-white d-flex flex-column p-3">
    <div class="text-center mb-4">
      <img src="modules/img/user.png" alt="Usuario" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px;">
      <h5 class="mt-2">Carmelo Placencia</h5>
    </div>
    <ul class="nav nav-pills flex-column">
      <li class="nav-item mb-4 fs-4"><a href="home" class="nav-link text-white"><i class="bi bi-house-door me-2"></i>Inicio</a></li>
      <li class="mb-4 fs-4"><a href="agregarseguro" class="nav-link text-white"><i class="bi bi-person me-2"></i>Registrar Seguro</a></li>
      <li class="mb-4 fs-4"><a href="pagosCuotas" class="nav-link text-white"><i class="bi bi-cash me-2"></i>Pagos / Cuotas</a></li>
      <li class="mb-4 fs-5"><a href="registros" class="nav-link text-white"><i class="bi bi-card-list me-2"></i>Todos los Registros</a></li>
      <li class="mb-4 fs-4"><a href="tarifas" class="nav-link text-white"><i class="bi bi-card-list me-2"></i>Tarifas</a></li>
      <li class="mb-4 fs-4"><a href="reportes" class="nav-link text-white"><i class="bi bi-gear me-2"></i>Reportes</a></li>
      <li class="mb-4 fs-4"><a href="login" class="nav-link text-white"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
    </ul>
  
  </div>
    <div class="container-fluid main-content">
         <!-- Últimos seguros registrados -->
    <div class="card p-3 mb-4">
        <div class="row">
      <h5 class="col-6 mb-2">Todas los registros de seguros</h5>
      <form class="col-6 d-flex" method="GET" action="">
  <input class="form-control me-2" type="search" name="buscar" placeholder="Buscar por cliente, modelo o marca">
  <button class="btn btn-outline-success" type="submit">Buscar</button>
</form>
     </div>
      <p class="mb-5">Verifica y edita los registros de seguros</p>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Cliente</th>
            <th>Vehículo</th>
            <th>Fecha</th>
            <th>Total Cuota</th>
            <th>Total A pagar</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
         <?php foreach ($seguros as $seguro): ?>
          <tr>
            <td><?= htmlspecialchars($seguro['nombre']) ?></td>
            <td><?= ucfirst($seguro['tipo_vehiculo']) ?> - <?= htmlspecialchars($seguro['marca']) ?> <?= htmlspecialchars($seguro['modelo']) ?></td>
            <td><?= htmlspecialchars($seguro['fecha_creacion'] ?? 'N/A') ?></td>
            <td>$<?= number_format($seguro['montoInicial'], 2) ?></td>
            <td>$<?= number_format($seguro['montoSeguro'], 2) ?></td>
            <td>
                <?php
                    $estado = strtolower($seguro['estado']);
                    $clase = $estado === 'pagado' ? 'bg-success' : ($estado === 'vencido' ? 'bg-danger' : 'bg-warning');
                ?>
                <span class="badge <?= $clase ?>"><?= ucfirst($estado) ?></span>
            </td>
            <td>
                <button class="btn btn-success btn-sm"><i class="bi bi-eye-fill"></i></button>
                <button class="btn btn-danger btn-sm"><i class="bi bi-download"></i></button>
                <button class="btn btn-danger btn-sm"><i class="bi bi-printer-fill"></i></button>
                <button class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></button>
            </td>
        </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
        </div>
        
    </body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>
