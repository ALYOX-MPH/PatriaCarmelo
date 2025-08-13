<?php
session_start(); // inicia secion para poder ditar
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

$db = new Model_DB();
$conn = $db->connect();

$busqueda = $_GET['buscar'] ?? '';

if ($busqueda) {
    // eliminar ocea se pone a uno
    $stmt = $conn->prepare("SELECT * FROM seguros WHERE (nombre LIKE :buscar OR modelo LIKE :buscar OR marca LIKE :buscar) AND deleted = 0");
    $stmt->execute(['buscar' => "%$busqueda%"]);
} else {
    $stmt = $conn->prepare("SELECT * FROM seguros WHERE deleted = 0");
    $stmt->execute();
}

$seguros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include 'modules/layout/header.php'; ?>
    
    <title>Creacion de Seguros</title>

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
               <button onclick="window.location.href='/mostrarregistros?id=<?= htmlspecialchars($seguro['id']) ?>'" class="btn btn-success btn-sm">
                 <i class="bi bi-eye-fill"></i>
                </button>

                <button onclick="window.location.href='/editarregistros?id=<?= htmlspecialchars($seguro['id']) ?>'" class="btn btn-warning btn-sm">
                 <i class="bi bi-pencil-square"></i>
                </button>

                <a href="/modules/Registros/generar_pdf.php?id=<?= htmlspecialchars($seguro['id']) ?>" target="_blank" class="btn btn-secondary btn-sm btn-info me-1">
                 <i class="bi bi-download " ></i>
                </a>
                
                    <button onclick="window.location.href='/descargarpdf?id=<?= htmlspecialchars($seguro['id']) ?>'" class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>

                    <a href="javascript:void(0);" 
                       onclick="confirmarEliminar(<?= htmlspecialchars($seguro['id']) ?>)"
                       class="btn btn-danger btn-sm">
                       <i class="fa fa-trash"></i> Eliminar
                    </a>

            </td>
        </tr>
           <?php endforeach; ?>

        </tbody>
      </table>
    </div>
        </div>
        
    </body>


<?php include 'modules/layout/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
            .catch((error) => { //esto es para error 
                console.error('Error en la petición:', error); // Para depuración
                Swal.fire({
                    icon: 'error',
                    title: 'Error al conectar con el servidor o procesar la respuesta'
                });
            });
        }
    });
}

// --- Muestra SweetAlert si hay un mensaje en la sesión ---
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
