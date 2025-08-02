
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
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel Admin - Seguros</title>

  <!-- Bootstrap & Iconos -->
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
      <li class="nav-item mb-4 fs-4"><a href="#" class="nav-link text-white"><i class="bi bi-house-door me-2"></i>Inicio</a></li>
      <li class="mb-4 fs-4"><a href="/agregarseguro" class="nav-link text-white"><i class="bi bi-person me-2"></i>Registrar Seguro</a></li>
      <li class="mb-4 fs-4"><a href="/pagosCuotas" class="nav-link text-white"><i class="bi bi-cash me-2"></i>Pagos / Cuotas</a></li>
      <li class="mb-4 fs-5"><a href="/registros" class="nav-link text-white"><i class="bi bi-card-list me-2"></i>Todos los Registros</a></li>
      <li class="mb-4 fs-4"><a href="/tarifas" class="nav-link text-white"><i class="bi bi-card-list me-2"></i>Tarifas</a></li>
      <li class="mb-4 fs-4"><a href="/reportes" class="nav-link text-white"><i class="bi bi-gear me-2"></i>Reportes</a></li>
      <li class="mb-4 fs-4"><a href="login" class="nav-link text-white"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
    </ul>
  
  </div>

  
  <!-- Contenido Principal -->
   <div class="main-content">
    <h2 class="mb-4 d-flex justify-content-between align-items-center">
      Panel de Control
      <a href="/agregarseguro" class="btn btn-danger btn-sm btn-add fs-5"><i class="bi bi-plus-circle"></i> Agregar Seguro</a>
    </h2>

    <!-- Tarjetas -->
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="card text-center p-3">
          <h5 class="text-primary">Clientes</h5>
          <h3>152</h3>
          <p class="text-small text-muted">Registrados</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center p-3">
          <h5 class="text-success">Seguros Activos</h5>
          <h3>98</h3>
          <p class="text-small text-muted">Vigentes</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center p-3">
          <h5 class="text-danger">Pagos Pendientes</h5>
          <h3>27</h3>
          <p class="text-small text-muted">En mora</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center p-3">
          <h5 class="text-warning">Vencimientos Próximos</h5>
          <h3>15</h3>
          <p class="text-small text-muted">En los próximos 7 días</p>
        </div>
      </div>
    </div>

    <!-- Últimos seguros registrados -->
    <div class="card p-3 mb-4">
      <h5 class="mb-3">Últimos Seguros Registrados (30 días)</h5>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Cliente</th>
            <th>Vehículo</th>
            <th>Fecha</th>
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
            <td>
                <?php
                    $estado = strtolower($seguro['estado']);
                    $clase = $estado === 'pagado' ? 'bg-success' : ($estado === 'vencido' ? 'bg-danger' : 'bg-warning');
                ?>
                <span class="badge <?= $clase ?>"><?= ucfirst($estado) ?></span>
            </td>
            <td>
                <button class="btn btn-success btn-sm"><i class="bi bi-eye-fill"></i></button>
            </td>
        </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Gráfico de Pagos Mensuales -->
    <div class="card p-3 mb-4">
      <h5 class="text-center">Pagos Mensuales</h5>
      <canvas id="barChart" height="200"></canvas>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Bar Chart - Pagos por Mes
    new Chart(document.getElementById('barChart'), {
      type: 'bar',
      data: {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
        datasets: [{
          label: 'Pagos',
          data: [15, 22, 17, 30, 25, 29],
          backgroundColor: '#0dcaf0',
          borderRadius: 5
        }]
      },
      options: {
        scales: {
          x: { ticks: { color: '#333' } },
          y: { ticks: { color: '#333' }, beginAtZero: true }
        },
        plugins: {
          legend: { labels: { color: '#333' } }
        }
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
