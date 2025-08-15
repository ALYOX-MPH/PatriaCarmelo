<?php
session_start();
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

$db = new Model_DB();
$conn = $db->connect();

// La lógica de búsqueda se manejará por DataTables en el lado del cliente
// Eliminamos el bloque if ($busqueda) ... else ...
$stmt = $conn->prepare("SELECT * FROM seguros WHERE deleted = 0 ORDER BY fecha_creacion DESC");
$stmt->execute();

$seguros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'modules/layout/header.php'; ?>
<title>Todos los Registros</title>

<!-- Incluir CSS de DataTables (Local) -->
<link rel="stylesheet" type="text/css" href="assets\libs\datatable\css\datatables.css"/>
<link rel="stylesheet" type="text/css" href="assets\libs\datatable\css\datatables.min.css"/>

<style>
    body { background-color: #f5f5f5; color: #333; }
    .sidebar { width: 280px; height: 100vh; position: fixed; background-color: #1c1f22ff; }
    .main-content { margin-left: 280px; padding: 20px; max-width: 1650px; }
    .card { background-color: #fff; border: none; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .text-small { font-size: 0.9rem; }
    .btn-group .dropdown-menu { min-width: auto; }
</style>

<body>
<!-- Sidebar -->
<?php include 'modules/layout/sidebar.php'; ?>

<div class="container-fluid main-content">
    <div class="card p-3 mb-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h5 class="mb-0">Todos los registros de seguros</h5>
                <p class="text-muted text-small">Verifica y edita los registros de seguros.</p>
            </div>
            <!-- Eliminamos el formulario de búsqueda PHP, DataTables lo proveerá -->
            <div class="col-md-6">
                <!-- DataTables generará su propia barra de búsqueda aquí -->
            </div>
        </div>
        
        <div class="table-responsive">
            <!-- Asignamos un ID a la tabla para DataTables -->
            <table id="tablaSeguros" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No.Seguro</th>
                        <th>Cliente</th>
                        <th>Cedula</th>
                        <th>Vehículo</th>
                        <th>Placa</th>
                        <th>Fecha</th>
                        <th>Total Cuota</th>
                        <th>Total A Pagar</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($seguros)): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted">No se encontraron registros.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($seguros as $seguro): ?>
                            <tr>
                                <td><?= htmlspecialchars($seguro['secuencia_seguro'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($seguro['nombre'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($seguro['cedula'] ?? 'N/A') ?></td>
                                <td><?= ucfirst($seguro['tipo_vehiculo'] ?? 'N/A') ?> - <?= htmlspecialchars($seguro['marca'] ?? 'N/A') ?> <?= htmlspecialchars($seguro['modelo'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($seguro['placa'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($seguro['fecha_creacion'] ?? 'N/A') ?></td>
                                <td>$<?= number_format($seguro['montoInicial'] ?? 0, 2) ?></td>
                                <td>$<?= number_format($seguro['montoSeguro'] ?? 0, 2) ?></td>
                                <td>
                                    <?php
                                        $estado = strtolower($seguro['estado'] ?? '');
                                        $clase = 'bg-secondary';
                                        if ($estado === 'pagado') {
                                            $clase = 'bg-success';
                                        } elseif ($estado === 'vencido') {
                                            $clase = 'bg-danger';
                                        } elseif ($estado === 'en proceso' || $estado === 'pendiente' || $estado === 'por vencer') {
                                            $clase = 'bg-warning';
                                        }
                                    ?>
                                    <span class="badge rounded-pill <?= $clase ?>"><?= ucfirst($estado) ?></span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button onclick="window.location.href='/mostrarregistros?id=<?= htmlspecialchars($seguro['id'] ?? '') ?>'" class="btn btn-success btn-sm">
                                            <i class="bi bi-eye-fill"></i>
                                       </button>
                                       
                                        <a href="/editarregistros?id=<?= htmlspecialchars($seguro['id'] ?? '') ?>" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-sm dropdown-toggle text-white" data-bs-toggle="dropdown" aria-expanded="false" title="Opciones de impresión">
                                                <i class="bi bi-printer-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="/modules/Registros/generar_pdf.php?id=<?= htmlspecialchars($seguro['id'] ?? '') ?>" target="_blank">
                                                        <i class="bi bi-file-earmark-pdf me-2"></i>Imprimir Registro
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="/modules/Registros/generar_ticket.php?id=<?= htmlspecialchars($seguro['id'] ?? '') ?>" target="_blank">
                                                        <i class="bi bi-credit-card me-2"></i>Imprimir Ticket
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <a href="javascript:void(0);" onclick="confirmarEliminar(<?= htmlspecialchars($seguro['id'] ?? '') ?>)" class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>

<?php include 'modules/layout/footer.php'; ?>

<!-- Incluir jQuery (DataTables lo necesita) -->

<!-- Incluir JS de DataTables (Local) -->
<script type="text/javascript" src="assets\libs\datatable\js\datatables.js"></script>
<script type="text/javascript" src="assets\libs\datatable\js\datatables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Inicializar DataTables en tu tabla
    $('#tablaSeguros').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' // Idioma español
        }
    });
});

function confirmarEliminar(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Este registro será marcado como eliminado.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('modules/Registros/eliminar_seguro.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: data.message
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al conectar con el servidor o procesar la respuesta'
                });
            });
        }
    });
}
<?php if (isset($_SESSION['message'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['message']['type'] ?>',
        title: '<?= $_SESSION['message']['text'] ?>',
        showConfirmButton: false, 
        timer: 2000 
    });
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>
</script>