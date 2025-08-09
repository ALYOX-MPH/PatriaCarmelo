
  <title>Creación de Seguros</title>
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
</head>
<body>

  <!-- Sidebar -->
  <?php include 'modules/layout/sidebar.php'; ?>

  <!-- Contenido principal -->
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
              <option value="minivan">Minivan o Minibus Privado</option>
              <option value="minibus">Minibus Publico</option>
              <option value="camioneta">Camioneta</option>
              <option value="camionCaja">Camion de caja o cama</option>
              <option value="camionVolteo">Camion Volteo</option>
              <option value="camionCabezote">Camion Cabezote</option>
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
            <input type="text" class="form-control" name="ano" required>
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
            <input type="text" class="form-control" name="observacionesVehiculo">
          </div>
        </div>

        <!-- Datos de pago -->
        <h4 class="mt-3 mb-4 border-bottom pb-2">Datos de pago</h4>
        <div class="row">
          <div class="col-6 mb-3">
            <label class="form-label">Tipo de Seguro</label>
            <select class="form-select" id="tipo" name="tipoSeguro" required>
              <option value="">Seleccione un tipo</option>
              <option value="moto-ex">Moto EX</option>
              <option value="moto-premium">Moto Premium</option>
              <option value="moto-max">Moto Max</option>
              <option value="elemental">Elemental</option>
              <option value="flexible">Flexible</option>
              <option value="superior">Superior</option>
              <option value="plus">Plus</option>
              <option value="elite">Elite</option>
              <option value="max">Max</option>
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
        'moto-ex': 1666.92,
        'moto-premium':2092.79,
        'moto-max':2712.53
    },
         automovilPrivado: {
        elemental: 3600,
        flexible: 3874,
        superior: 4767,
        plus: 5492,
        elite: 6217
    },
         automovilPublico: {
            elemental: 6527,
            flexible: 6862,
            superior: 7877,
            plus: 9272,
            elite: 10667
        },
        autobusPrivado: {
            elemental: 1300,
            flexible: 1600,
            superior: 1900,
            plus: 2200,
            elite: 2500
        },
      jeepeta: {
        elemental: 4689,
        flexible: 4963,
        superior: 5856,
        plus: 6819,
        elite: 7801
      },
        camioneta: {
            elemental: 4720,
            flexible: 4832,
            superior: 5957,
            plus: 6953,
            elite: 7948
        },
        camionVolteo: {
            elemental: 17491,
            flexible: 20576,
            max: 23661,
        },
        maquinariaPesada: {
            elemental: 2000,
            flexible: 2500,
            superior: 3000,
            plus: 3500,
            elite: 4000
        },
        furgoneta: {
            elemental: 4689,
            flexible: 4963,
            superior:5856,
            plus: 6829,
            elite: 7801
        },
        minivan: {
            elemental:5750,
            flexible: 6030,
            superior: 6923,
            plus: 8138,
            elite: 9353
        },
        minibus: {
            elemental: 7920,
            flexible: 8210,
            superior: 9225,
            plus: 10926,
            elite: 12627
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
            elemental: 1000,
            flexible: 1500,
            max: 2000,
            
          
        },
        camionCaja:{
          elemental: 13856,
          flexible: 16430,
          max: 19000
        },
        camionCabezote:{
          elemental: 18026,
          flexible: 21186,
          max: 24346
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


  <?php include 'modules/layout/footer.php'; ?>
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