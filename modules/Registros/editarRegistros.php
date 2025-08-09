<?php
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

$db = new Model_DB();
$conn = $db->connect();

$seguro = [];
$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM seguros WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $seguro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$seguro) {
        echo "Seguro no encontrado.";
        exit;
    }
}

// Actualizar datos si se envía por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id' => $id,
        'nombre' => $_POST['nombre'] ?? '',
        'poliza' => $_POST['poliza'] ?? '',
        'cedula' => $_POST['cedula'] ?? '',
        'telefono' => $_POST['numero'] ?? '',
        'direccion' => $_POST['direccion'] ?? '',
        'tipo_vehiculo' => $_POST['tipo_vehiculo'] ?? '',
        'servicio' => $_POST['servicio'] ?? '',
        'marca' => $_POST['marca'] ?? '',
        'ano' => $_POST['ano'] ?? '',
        'modelo' => $_POST['modelo'] ?? '',
        'chasisVehiculo' => $_POST['chasisVehiculo'] ?? '',
        'placa' => $_POST['placa'] ?? '',
        'color' => $_POST['color'] ?? '',
        'tonCilVehiculo' => $_POST['tonCilVehiculo'] ?? '',
        'pasajerosVehiculo' => $_POST['pasajerosVehiculo'] ?? 0,
        'observacionesVehiculo' => $_POST['observacionesVehiculo'] ?? '',
        'tipoSeguro' => $_POST['tipoSeguro'] ?? '',
        'tipo_pago' => $_POST['tipo_pago'] ?? '',
        'montoSeguro' => $_POST['montoSeguro'] ?? 0,
        'montoInicial' => $_POST['montoInicial'] ?? 0,
        'estado' => $_POST['estado'] ?? '',
    ];

    $sql = "UPDATE seguros SET
        nombre = :nombre,
        poliza = :poliza,
        cedula = :cedula,
        telefono = :telefono,
        direccion = :direccion,
        tipo_vehiculo = :tipo_vehiculo,
        servicio = :servicio,
        marca = :marca,
        ano = :ano,
        modelo = :modelo,
        chasisVehiculo = :chasisVehiculo,
        placa = :placa,
        color = :color,
        tonCilVehiculo = :tonCilVehiculo,
        pasajerosVehiculo = :pasajerosVehiculo,
        observacionesVehiculo = :observacionesVehiculo,
        tipoSeguro = :tipoSeguro,
        tipo_pago = :tipo_pago,
        montoSeguro = :montoSeguro,
        montoInicial = :montoInicial,
        estado = :estado
        WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->execute($data);

    echo " <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Registro actualizado!',
            text: 'El seguro fue editado correctamente.',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = 'registros.php';
        });
    </script>
    ";
    exit;
}
?>

<?php include 'modules/layout/header.php'; ?>

<title>Editar Seguro</title>
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
<?php include 'modules/layout/sidebar.php'; ?>
<!-- Formulario de edición -->
<div class="container">
  <div class="main-content">
    <h1 class="mt-5">Editar Seguro</h1>
    <form id="seguroForm" method="POST" class="mt-4">
      <input type="hidden" name="estado" id="estadoPago" value="<?= htmlspecialchars($seguro['estado'] ?? 'En proceso') ?>">

      <!-- Datos personales -->
      <div class="row">
        <div class="col-9 mb-3">
          <label class="form-label">Nombre del Seguro</label>
          <input type="text" class="form-control" name="nombre" required value="<?= htmlspecialchars($seguro['nombre']) ?>">
        </div>
        <div class="col-3 mb-3">
          <label class="form-label">Num. poliza</label>
          <input type="text" class="form-control" name="poliza" required value="<?= htmlspecialchars($seguro['poliza']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Cédula</label>
          <input type="number" class="form-control" name="cedula" required value="<?= htmlspecialchars($seguro['cedula']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Número</label>
          <input type="number" class="form-control" name="numero" required value="<?= htmlspecialchars($seguro['telefono']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Dirección</label>
          <input type="text" class="form-control" name="direccion" required value="<?= htmlspecialchars($seguro['direccion']) ?>">
        </div>
      </div>

      <!-- Datos del vehículo -->
      <h4 class="mt-3 mb-4 border-bottom pb-2">Datos del vehículo</h4>
      <div class="row">
        <div class="col-3 mb-3">
          <label class="form-label">Tipo de vehículo</label>
          <select class="form-select" name="tipo_vehiculo" required>
            <?php
            $tipos = ["moto","automovilPrivado","automovilPublico","jeepeta","furgoneta","minivan","minibus","camioneta","camionCaja","camionVolteo","autobusPrivado","autobusPublico","maquinariaPesada","cobertura","remolques"];
            foreach ($tipos as $tipo) {
              $selected = ($seguro['tipo_vehiculo'] == $tipo) ? 'selected' : '';
              echo "<option value='$tipo' $selected>$tipo</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-3 mb-3">
          <label class="form-label">Servicio</label>
          <select class="form-select" name="servicio" required>
            <option value="privado" <?= $seguro['servicio'] == 'privado' ? 'selected' : '' ?>>Privado</option>
            <option value="publico" <?= $seguro['servicio'] == 'publico' ? 'selected' : '' ?>>Público</option>
            <option value="sin interes" <?= $seguro['servicio'] == 'sin interes' ? 'selected' : '' ?>>Sin interés</option>
          </select>
        </div>
        <div class="col-3 mb-3">
          <label class="form-label">Marca</label>
          <input type="text" class="form-control" name="marca" required value="<?= htmlspecialchars($seguro['marca']) ?>">
        </div>
        <div class="col-3 mb-3">
          <label class="form-label">Año</label>
          <input type="text" class="form-control" name="ano" required value="<?= htmlspecialchars($seguro['ano']) ?>">
        </div>
        <div class="col-4 mb-3">
          <label class="form-label">Modelo</label>
          <input type="text" class="form-control" name="modelo" required value="<?= htmlspecialchars($seguro['modelo']) ?>">
        </div>
        <div class="col-4 mb-3">
          <label class="form-label">Chasis</label>
          <input type="text" class="form-control" name="chasisVehiculo" required value="<?= htmlspecialchars($seguro['chasisVehiculo']) ?>">
        </div>
        <div class="col-4 mb-3">
          <label class="form-label">Placa</label>
          <input type="text" class="form-control" name="placa" required value="<?= htmlspecialchars($seguro['placa']) ?>">
        </div>
        <div class="col-4 mb-3">
          <label class="form-label">Color</label>
          <input type="text" class="form-control" name="color" required value="<?= htmlspecialchars($seguro['color']) ?>">
        </div>
        <div class="col-4 mb-3">
          <label class="form-label">Ton/Cil</label>
          <input type="text" class="form-control" name="tonCilVehiculo" required value="<?= htmlspecialchars($seguro['tonCilVehiculo']) ?>">
        </div>
        <div class="col-4 mb-3">
          <label class="form-label">Pasajeros</label>
          <input type="number" class="form-control" name="pasajerosVehiculo" required value="<?= htmlspecialchars($seguro['pasajerosVehiculo']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Observaciones</label>
          <input type="text" class="form-control" name="observacionesVehiculo" value="<?= htmlspecialchars($seguro['observacionesVehiculo']) ?>">
        </div>
      </div>

      <!-- Datos de pago -->
      <h4 class="mt-3 mb-4 border-bottom pb-2">Datos de pago</h4>
      <div class="row">
        <div class="col-6 mb-3">
          <label class="form-label">Tipo de Seguro</label>
          <select class="form-select" name="tipoSeguro" required>
            <?php
            $tiposSeguro = ["elemental","flexible","superior","plus","elite"];
            foreach ($tiposSeguro as $tipo) {
              $selected = ($seguro['tipoSeguro'] == $tipo) ? 'selected' : '';
              echo "<option value='$tipo' $selected>$tipo</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-6 mb-3">
          <label class="form-label">Monto por tipo de Seguro</label>
          <input type="number" class="form-control" name="montoSeguro" id="montoSeguro" value="<?= htmlspecialchars($seguro['montoSeguro']) ?>" required>
        </div>
        <div class="col-6 mb-3">
          <label class="form-label">Tipo de pago</label>
          <select class="form-select" name="tipo_pago" required>
            <option value="efectivo" <?= $seguro['tipo_pago'] == 'efectivo' ? 'selected' : '' ?>>Efectivo</option>
            <option value="transferencia" <?= $seguro['tipo_pago'] == 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
          </select>
        </div>
        <div class="col-6 mb-3">
          <label class="form-label">Monto inicial</label>
          <input type="number" class="form-control" name="montoInicial" required value="<?= htmlspecialchars($seguro['montoInicial']) ?>">
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <a href="/home" class="btn btn-danger mt-3 w-100">Cancelar</a>
        </div>
        <div class="col-6">
          <button type="submit" class="btn btn-primary mt-3 w-100">Guardar Cambios</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Aquí puedes mantener tus scripts JS para calcular valores dinámicos -->
<script>
  // igual que antes: actualización de monto según tipo
</script>


<?php include 'modules/layout/footer.php'; ?>
