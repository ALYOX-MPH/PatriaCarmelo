<?php
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

$db = new Model_DB();
$conn = $db->connect();

// Obtener solo los seguros que no estén pagados
// $stmt = $conn->prepare("SELECT * FROM seguros WHERE estado != 'Pagado' AND deleted =0 AND (nombre LIKE :buscar OR modelo LIKE :buscar OR marca LIKE :buscar)  ");
// $stmt->execute();

$busqueda = $_GET['buscar'] ?? '';

// 1. Construir la consulta base
$sql = "SELECT * FROM seguros WHERE estado != 'Pagado' AND deleted = 0";

$params = [];

// 2. Añadir la condición de búsqueda solo si existe
if ($busqueda) {
    $sql .= " AND (nombre LIKE :buscar OR modelo LIKE :buscar OR marca LIKE :buscar OR cedula LIKE :buscar OR secuencia_seguro LIKE :buscar)";
    $params['buscar'] = "%$busqueda%";
}

// 3. Preparar y ejecutar la consulta una sola vez
$stmt = $conn->prepare($sql);
$stmt->execute($params);

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
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .text-small {
      font-size: 0.9rem;
    }
  </style>
<link rel="stylesheet" type="text/css" href="/public/assets/datatables/css/dataTables.bootstrap5.min.css"/>



<body>
  <!-- Sidebar -->
  <?php include 'modules/layout/sidebar.php'; ?>
  <div class="container-fluid main-content">
    <!-- Últimos seguros registrados -->
    <div class="card p-3 mb-4">
      <h5 class="mb-2">Todas los registros con cuotas</h5>
      <p class="mb-3">Realiza los pagos de cada cliente</p>
       <form class="col-6 d-flex" method="GET" action="">

<input class="form-control me-2" type="search" name="buscar" placeholder="Buscar por cliente, modelo o marca">

<button class="btn btn-outline-success" type="submit">Buscar</button>

</form>
      <table id="tablaSeguros" class="table table-hover">
        <thead>
          <tr>
            <th>No.Seguro</th>
            <th>Cliente</th>
            <th>Vehículo</th>
            <th>Cedula</th>
            <th>Fecha</th>
            <th>Total Pagado</th>
            <th>Total Cuota</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($seguros as $seguro): ?>
            <tr>
              <td><?= htmlspecialchars($seguro['secuencia_seguro']) ?></td>
              <td><?= htmlspecialchars($seguro['nombre']) ?></td>
              <td><?= htmlspecialchars($seguro['tipo_vehiculo']) ?> - <?= htmlspecialchars($seguro['marca']) ?></td>
              <td><?= htmlspecialchars($seguro['cedula']) ?></td>
              <td><?= htmlspecialchars($seguro['fecha_creacion']) ?></td>
              <td>$<?= number_format($seguro['montoInicial'], 2) ?></td>
              <td>$<?= number_format($seguro['montoSeguro'], 2) ?></td>
              <!-- FRANK: Para obtener el id del seguro mediante php de una forma rapida -->
              <td>
                <span class="badge <?= $seguro['estado'] === 'En proceso' ? 'bg-warning' : 'bg-success' ?>">
                  <?= htmlspecialchars($seguro['estado']) ?>
                </span>
              </td>
              <td>
                <button
                class="btn btn-secondary btn-sm btn-success aplicarPago"
                data-id="<?= $seguro['id'] ?>"
                data-cuota="<?= $seguro['montoInicial'] ?>"
                data-total="<?= $seguro['montoSeguro'] ?>">
                Aplicar Pago
              </button>
              <button onclick="window.location.href='/mostrarpagos?id=<?= $seguro['id'] ?>'" class="btn btn-success btn-sm"><i class="bi bi-eye-fill"></i></button>

              <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Descargas
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/imprimirrecibo?id=<?php echo $seguro['id']; ?>">Imprimir recibo de pago</a></li>
                        <li><a class="dropdown-item" href="/modules/PagosCuotas/generar_pdf.php?id=<?= $seguro['id'] ?>" target="_blank">Descargar Pdf</a></li>
                    </ul>
                </div>


              <button onclick="window.location.href='/descargarpdf?id=<?= $seguro['id'] ?>'" class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
            </td>
            <td> <input id="ID_Seguro" type="hidden" value="<?= htmlspecialchars($seguro['id']) ?>"> </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- modal -->
  <!-- Modal Aplicar Pago -->
  <div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="modalPagoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPagoLabel">Aplicar Pago</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p><strong>Total Pagado:</strong> <span id="montoPagarModal"></span></p>
          <p><strong>Total del seguro:</strong> <span id="totalSeguroModal"></span></p>
          <input type="number" class="form-control mt-3" placeholder="Ingrese el monto a pagar">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Confirmar Pago</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="/public/assets/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/public/assets/datatables/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

   $(document).ready(function() {
        $('#tablaSeguros').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });
    });
  // FRANK: Como tal no es necesario que al principio la variable se declare en null
  let seguroId = null;

    document.querySelectorAll('.aplicarPago').forEach(btn => {
      btn.addEventListener('click', function() {
        // asignacion del id a la variable seguroID que eventualmente mandas por el fetch ademas de convertilo a int
        seguroId = parseInt(this.getAttribute('data-id'));
        // seguroId = Number.parseInt(document.getElementById("ID_Seguro").value);
        const monto = this.getAttribute('data-cuota');
        const total = this.getAttribute('data-total');
        idSeguroSeleccionado = this.getAttribute('data-id'); // asegúrate que esté como data-id en el botón

        document.getElementById('montoPagarModal').textContent = monto;
        document.getElementById('totalSeguroModal').textContent = total;

        const modal = new bootstrap.Modal(document.getElementById('modalPago'));
        modal.show();
      });
    });

    document.querySelector('#modalPago .btn-primary').addEventListener('click', function() {
      const input = document.querySelector('#modalPago input');
      const monto = parseFloat(input.value);

      if (!monto || monto <= 0) {
        alert("Por favor ingrese un monto válido.");
        return;
      }

      fetch('modules/PagosCuotas/guardarPago.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            seguro_id: seguroId,
            monto: monto
          })
        })
        .then(res => res.json())
.then(data => {
  Swal.fire({
    title: 'Pago exitoso',
    text: 'El estado del registro esta: ' + data.estado,
    icon: 'success',
    confirmButtonText: 'Aceptar'
  }).then(() => {
    location.reload(); // Refresca la tabla para mostrar el nuevo estado
  });
})
        .catch(err => {
          // alert("Error al guardar el pago");
          // window.location.href = "modules/LandingPage/pruebaFrank.php";
          console.error(err);
        });
    });
  </script>




</body>


<?php include 'modules/layout/footer.php'; ?>
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</html>