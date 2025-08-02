<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Creación de Seguros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      <li class="nav-item mb-4 fs-4"><a href="home" class="nav-link text-white"><i class="bi bi-house-door me-2"></i>Inicio</a></li>
      <li class="mb-4 fs-4"><a href="agregarseguro" class="nav-link text-white"><i class="bi bi-person me-2"></i>Registrar Seguro</a></li>
      <li class="mb-4 fs-4"><a href="pagoscuotas" class="nav-link text-white"><i class="bi bi-cash me-2"></i>Pagos / Cuotas</a></li>
      <li class="mb-4 fs-5"><a href="registros" class="nav-link text-white"><i class="bi bi-card-list me-2"></i>Todos los Registros</a></li>
      <li class="mb-4 fs-4"><a href="tarifas" class="nav-link text-white"><i class="bi bi-card-list me-2"></i>Tarifas</a></li>
      <li class="mb-4 fs-4"><a href="reportes" class="nav-link text-white"><i class="bi bi-gear me-2"></i>Reportes</a></li>
      <li class="mb-4 fs-4"><a href="login" class="nav-link text-white"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
    </ul>
  </div>

  <div class="container">
    <div class="main-content">
      <h1 class="mt-5">Crear Nuevo Seguro</h1>
      <form id="seguroForm" action="/agregarseguro" method="POST" class="mt-4">
        <input type="hidden" name="estado" id="estadoPago" value="En proceso">

        <!-- Datos personales -->
        <div class="row">
          <div class="col-9 mb-3">
            <label class="form-label">Nombre del Seguro</label>
            <input type="text" class="form-control" name="nombre" required>
          </div>
          <div class="col-3 mb-3">
            <label class="form-label">Num. poliza</label>
            <input type="text" class="form-control" name="poliza" value="CAW521" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Cédula</label>
            <input type="number" class="form-control" name="cedula" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Número</label>
            <input type="number" class="form-control" name="numero" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" class="form-control" name="direccion" required>
          </div>
        </div>

        <!-- Datos del vehículo -->
        <h4 class="mt-3 mb-4 border-bottom pb-2">Datos del vehículo</h4>
        <div class="row">
          <div class="col-3 mb-3">
            <label class="form-label">Tipo de vehículo</label>
            <select class="form-select" id="tipo_vehiculo" name="tipo_vehiculo" required>
              <option value="">Seleccione un tipo</option>
              <option value="moto">Motocicleta</option>
              <option value="automovilPrivado">Automóvil Privado</option>
              <option value="automovilPublico">Automovil Publico</option>
              <option value="jeepeta">Jeepeta o SUV</option>
              <option value="furgoneta">Furgoneta</option>
              <option value="minivan">Minivan o Minibus</option>
              <option value="minibus">Minibus Publico</option>
              <option value="camioneta">Camioneta</option>
              <option value="camionCaja">Camion de caja o cama</option>
              <option value="camionCaja">Camion de caja o cama</option>
              <option value="camionCaja">Camion de caja o cama</option>
              <option value="camionVolteo">Camion Volteo</option>
              <option value="camionCaja">Camion Cabezote</option>
              <option value="autobusPrivado">Autobus Privado</option>
              <option value="autobusPublico">Autobus Publico</option>
              <option value="maquinariaPesada">Maquinaria Pesada</option>
              <option value="cobertura">Cobertura</option>
              <option value="remolques">Remolques</option>
            </select>
          </div>
          <div class="col-3 mb-3">
            <label class="form-label">Servicio</label>
            <select class="form-select" name="servicio" required>
              <option value="privado">Privado</option>
              <option value="publico">Público</option>
              <option value="sin interes">Sin interés</option>
            </select>
          </div>
          <div class="col-3 mb-3">
            <label class="form-label">Marca</label>
            <input type="text" class="form-control" name="marca" required>
          </div>
          <div class="col-3 mb-3">
            <label class="form-label">Año</label>
            <input type="date" class="form-control" name="ano" required>
          </div>
          <div class="col-4 mb-3">
            <label class="form-label">Modelo</label>
            <input type="text" class="form-control" name="modelo" required>
          </div>
          <div class="col-4 mb-3">
            <label class="form-label">Chasis</label>
            <input type="text" class="form-control" name="chasisVehiculo" required>
          </div>
          <div class="col-4 mb-3">
            <label class="form-label">Placa</label>
            <input type="text" class="form-control" name="placa" required>
          </div>
          <div class="col-4 mb-3">
            <label class="form-label">Color</label>
            <input type="text" class="form-control" name="color" required>
          </div>
          <div class="col-4 mb-3">
            <label class="form-label">Ton/Cil</label>
            <input type="text" class="form-control" name="tonCilVehiculo" required>
          </div>
          <div class="col-4 mb-3">
            <label class="form-label">Pasajeros</label>
            <input type="number" class="form-control" name="pasajerosVehiculo" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <input type="text" class="form-control" name="observacionesVehiculo" required>
          </div>
        </div>

        <!-- Datos de pago -->
        <h4 class="mt-3 mb-4 border-bottom pb-2">Datos de pago</h4>
        <div class="row">
          <div class="col-6 mb-3">
            <label class="form-label">Tipo de Seguro</label>
            <select class="form-select" id="tipo" name="tipoSeguro" required>
              <option value="">Seleccione un tipo</option>
              <option value="elemental">Elemental</option>
              <option value="flexible">Flexible</option>
              <option value="superior">Superior</option>
              <option value="plus">Plus</option>
              <option value="elite">Elite</option>
            </select>
          </div>
          <div class="col-6 mb-3">
            <label class="form-label">Monto Por tipo de Seguro</label>
            <input type="number" class="form-control" id="montoSeguro" name="montoSeguro" value="0" required>
          </div>
          <div class="col-6 mb-3">
            <label class="form-label">Tipo de pago</label>
            <select class="form-select" name="tipo_pago" required>
              <option value="">Seleccione un tipo</option>
              <option value="efectivo">Efectivo</option>
              <option value="transferencia">Transferencia</option>
            </select>
          </div>
          <div class="col-6 mb-3">
            <label class="form-label">Monto inicial</label>
            <input type="number" class="form-control" name="montoInicial" required>
          </div>
        </div>

        <!-- Botones -->
        <div class="row">
          <div class="col-6">
            <a href="/home" class="btn btn-danger mt-3 w-100">Cancelar</a>
          </div>
          <div class="col-6">
            <button type="submit" class="btn btn-success mt-3 w-100">Crear Registro</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Script para cálculo automático -->
  <script>
    const tipoVehiculo = document.getElementById('tipo_vehiculo');
    const tipoSeguro = document.getElementById('tipo');
    const montoSeguroInput = document.getElementById('montoSeguro');

    const tarifas = {
        moto: {
            elemental: 500,
            flexible: 700,
            superior: 900,
            plus: 1100,
            elite: 1300
        },
        automovilPrivado: {
            elemental: 800,
            flexible: 1000,
            superior: 1200,
            plus: 1500,
            elite: 1800
        },
        autobusPrivado: {
            elemental: 1300,
            flexible: 1600,
            superior: 1900,
            plus: 2200,
            elite: 2500
        },
      jeepeta: {
        elemental: 1000,
        flexible: 1300,
        superior: 1600,
        plus: 1900,
        elite: 2200
      },
        camioneta: {
            elemental: 1200,
            flexible: 1500,
            superior: 1800,
            plus: 2100,
            elite: 2400
        },
        camionVolteo: {
            elemental: 1500,
            flexible: 1800,
            superior: 2100,
            plus: 2400,
            elite: 2700
        },
        maquinariaPesada: {
            elemental: 2000,
            flexible: 2500,
            superior: 3000,
            plus: 3500,
            elite: 4000
        },
        furgoneta: {
            elemental: 900,
            flexible: 1200,
            superior: 1500,
            plus: 1800,
            elite: 2100
        },
        minivan: {
            elemental: 950,
            flexible: 1250,
            superior: 1550,
            plus: 1850,
            elite: 2150
        },
        minibus: {
            elemental: 1100,
            flexible: 1400,
            superior: 1700,
            plus: 2000,
            elite: 2300
        },
        autobusPublico: {
            elemental: 1400,
            flexible: 1700,
            superior: 2000,
            plus: 2300,
            elite: 2600
        },
        remolques: {
            elemental: 600,
            flexible: 800,
            superior: 1000,
            plus: 1200,
            elite: 1400
        },
        cobertura: {
            elemental: 700,
            flexible: 900,
            superior: 1100,
            plus: 1300,
            elite: 1500
        }

    };

    function actualizarMonto() {
      const tipoV = tipoVehiculo.value;
      const tipoS = tipoSeguro.value;

      if (tarifas[tipoV] && tarifas[tipoV][tipoS]) {
        montoSeguroInput.value = tarifas[tipoV][tipoS];
      } else {
        montoSeguroInput.value = '';
      }
    }

    tipoVehiculo.addEventListener('change', actualizarMonto);
    tipoSeguro.addEventListener('change', actualizarMonto);
  </script>

 <!-- Script para cálculo del estado de pago -->
 <script>
  const montoInicialInput = document.querySelector('input[name="montoInicial"]');
  const estadoPagoInput = document.getElementById('estadoPago');
  const formulario = document.getElementById('seguroForm');

  formulario.addEventListener('submit', function (e) {
    const montoInicial = parseFloat(montoInicialInput.value);
    const montoSeguro = parseFloat(montoSeguroInput.value);

    if (isNaN(montoInicial) || isNaN(montoSeguro)) {
      estadoPagoInput.value = 'En proceso'; // valor por defecto
      return;
    }

    if (montoInicial < montoSeguro) {
      estadoPagoInput.value = 'En proceso';
    } else if (montoInicial === montoSeguro) {
      estadoPagoInput.value = 'Pagado';
    } else {
      // Opcional: si el monto es mayor al esperado (puedes ignorarlo o manejarlo distinto)
      estadoPagoInput.value = 'Pagado';
    }
  });
</script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
<?php
    define('ROOT', dirname(__DIR__, 2)); // dos niveles arriba
    require_once ROOT . '/Models/Model_DB.php';



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'nombre' => $_POST['nombre'] ?? '',
            'poliza' => $_POST['poliza'] ?? '',
            'cedula' => $_POST['cedula'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
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

        try {
            $db = new Model_DB();
            $conn = $db->connect();

            $sql = "INSERT INTO seguros (
        nombre, poliza, cedula, telefono, direccion,
        tipo_vehiculo, servicio, marca, ano, modelo, chasisVehiculo, placa, color, tonCilVehiculo,
        pasajerosVehiculo, observacionesVehiculo, tipoSeguro, tipo_pago, montoSeguro, montoInicial,
        estado
    )
    VALUES (
        :nombre, :poliza, :cedula, :telefono, :direccion,
        :tipo_vehiculo, :servicio, :marca, :ano, :modelo, :chasisVehiculo, :placa, :color,
        :tonCilVehiculo, :pasajerosVehiculo, :observacionesVehiculo, :tipoSeguro, :tipo_pago, :montoSeguro, :montoInicial,
        :estado
    )
    ";

            $stmt = $conn->prepare($sql);
            $stmt->execute($data);

            echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Registro exitoso!',
            text: 'El seguro fue registrado correctamente.',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = 'registros.php';
        });
    </script>
    ";
        } catch (PDOException $e) {
            echo "Error al insertar: " . $e->getMessage();
        }
    }
    ?>