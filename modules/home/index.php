<?php
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

$db = new Model_DB();
$conn = $db->connect();

$busqueda = $_GET['buscar'] ?? '';



/// esto no es Ia coño





// Consulta para la tabla de últimos seguros registrados
if ($busqueda) {
    $stmt = $conn->prepare("SELECT * FROM seguros WHERE deleted = 0 AND (nombre LIKE :buscar OR poliza LIKE :buscar OR cedula LIKE :buscar OR secuencia_seguro LIKE :buscar) ORDER BY fecha_creacion DESC LIMIT 5");
    $stmt->execute(['buscar' => "%$busqueda%"]);
} else {
    // Ultimos 5 seguros registrados en los últimos 30 días
    $stmt = $conn->prepare("SELECT * FROM seguros WHERE deleted = 0 AND fecha_creacion >= DATE_SUB(NOW(), INTERVAL 30 DAY) ORDER BY fecha_creacion DESC LIMIT 5");
    $stmt->execute();
}

$seguros = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Total de Clientes (se considera un cliente por cada seguro único, si tienen la misma cédula) porque la sedula polque es la mejor forma de referenciar y porqueyo lo digo 
$stmt_total_clientes = $conn->prepare("SELECT COUNT(DISTINCT cedula) AS count FROM seguros WHERE deleted = 0");
$stmt_total_clientes->execute();
$total_clientes = $stmt_total_clientes->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

// Seguros Activos
$stmt_seguros_activos = $conn->prepare("SELECT COUNT(id) AS count FROM seguros WHERE estado != 'Vencido' AND estado != 'Cancelado' AND deleted = 0");
$stmt_seguros_activos->execute();
$seguros_activos = $stmt_seguros_activos->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

// Pagos Pendientes
$stmt_pagos_pendientes = $conn->prepare("SELECT COUNT(id) AS count FROM seguros WHERE (estado = 'En proceso' OR estado = 'Pendiente') AND deleted = 0");
$stmt_pagos_pendientes->execute();
$pagos_pendientes = $stmt_pagos_pendientes->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

// Vencimientos Próximos (usando el estado 'Por Vencer' y que no estén borrados lógicamente)
$stmt_vencimientos_proximos = $conn->prepare("SELECT COUNT(id) AS count FROM seguros WHERE estado = 'Por Vencer' AND deleted = 0");
$stmt_vencimientos_proximos->execute();
$vencimientos_proximos = $stmt_vencimientos_proximos->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

// Datos para el gráfico de Pagos Mensuales (últimos 6 meses)
$stmt_pagos_mensuales = $conn->prepare("
    SELECT
        DATE_FORMAT(fecha, '%Y-%m') AS mes_anio,
        SUM(monto) AS total_monto
    FROM pagos
    WHERE fecha >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY mes_anio
    ORDER BY mes_anio ASC
");
$stmt_pagos_mensuales->execute();
$pagos_mensuales_data = $stmt_pagos_mensuales->fetchAll(PDO::FETCH_ASSOC);

$labels_grafico = [];
$data_grafico = [];
$meses_es = [
    '01' => 'Ene', '02' => 'Feb', '03' => 'Mar', '04' => 'Abr',
    '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago',
    '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dic'
];

foreach ($pagos_mensuales_data as $item) {
    $mes_numero = substr($item['mes_anio'], 5, 2);
    $labels_grafico[] = $meses_es[$mes_numero] . ' ' . substr($item['mes_anio'], 2, 2); // Ene 24
    $data_grafico[] = $item['total_monto'];
}
?>

<?php include 'modules/layout/header.php'; ?>
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

<!-- Sidebar -->
<?php include 'modules/layout/sidebar.php'; ?>

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
                <h3><?= htmlspecialchars($total_clientes) ?></h3>
                <p class="text-small text-muted">Registrados</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5 class="text-success">Seguros Activos</h5>
                <h3><?= htmlspecialchars($seguros_activos) ?></h3>
                <p class="text-small text-muted">Vigentes</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5 class="text-danger">Pagos Pendientes</h5>
                <h3><?= htmlspecialchars($pagos_pendientes) ?></h3>
                <p class="text-small text-muted">En mora</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5 class="text-warning">Vencimientos Próximos</h5>
                <h3><?= htmlspecialchars($vencimientos_proximos) ?></h3>
                <p class="text-small text-muted">Que vencerán pronto</p>
            </div>
        </div>
    </div>

    <!-- Últimos seguros registrados -->
    <div class="card p-3 mb-4">
        <h5 class="mb-3">Últimos Seguros Registrados (30 días)</h5>
        <div class="table-responsive">
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
                    <?php if (empty($seguros)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No hay seguros recientes.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($seguros as $seguro): ?>
                        <tr>
                            <td><?= htmlspecialchars($seguro['nombre'] ?? 'N/A') ?></td>
                            <td><?= ucfirst($seguro['tipo_vehiculo'] ?? 'N/A') ?> - <?= htmlspecialchars($seguro['marca'] ?? 'N/A') ?> <?= htmlspecialchars($seguro['modelo'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y', strtotime($seguro['fecha_creacion'] ?? '')) ?: 'N/A') ?></td>
                            <td>
                                <?php
                                    $estado = strtolower($seguro['estado'] ?? '');
                                    $clase = '';
                                    switch ($estado) {
                                        case 'pagado':
                                            $clase = 'bg-success';
                                            break;
                                        case 'vencido':
                                            $clase = 'bg-danger';
                                            break;
                                        case 'en proceso':
                                        case 'pendiente':
                                        case 'por vencer':
                                            $clase = 'bg-warning';
                                            break;
                                        default:
                                            $clase = 'bg-secondary'; // Para otros estados no definidos
                                            break;
                                    }
                                ?>
                                <span class="badge <?= $clase ?>"><?= ucfirst($estado) ?></span>
                            </td>
                            <td>
                                <button onclick="window.location.href='/mostrarregistros?id=<?= htmlspecialchars($seguro['id'] ?? '') ?>'" class="btn btn-success btn-sm">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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
            // Datos inyectados desde PHP
            labels: <?= json_encode($labels_grafico) ?>,
            datasets: [{
                label: 'Pagos',
                data: <?= json_encode($data_grafico) ?>,
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

<?php include 'modules/layout/footer.php'; ?>