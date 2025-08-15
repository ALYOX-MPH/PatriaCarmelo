<?php
// No se necesita session_start() aquí si la alerta se muestra en la misma página
// session_start(); 
define('ROOT', dirname(__DIR__, 2));
require_once ROOT . '/Models/Model_DB.php';

$db = new Model_DB();
$conn = $db->connect();

$alertScript = ''; // Variable para almacenar el script de SweetAlert

// --- Función para generar la siguiente secuencia ---
function getNextSequenceSeguro($conn) {
    // Obtener la última secuencia de seguro
    $stmt = $conn->prepare("SELECT secuencia_seguro FROM seguros ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $lastSequence = $stmt->fetchColumn();

    $nextNumber = 1;
    if ($lastSequence) {
        // Extraer el número de la última secuencia (ej. de SG0001 a 1)
        $lastNumber = (int) substr($lastSequence, 2); // 'SG' tiene 2 caracteres
        $nextNumber = $lastNumber + 1;
    }

    // Formatear el nuevo número a 'SG' + ceros a la izquierda (ej. SG0001)
    return 'SG' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
}


// --- Manejo de la solicitud POST para agregar un nuevo seguro ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generar la secuencia dentro del bloque POST, justo antes de guardar en la DB
    $data = [
        'nombre' => $_POST['nombre'] ?? '',
        'poliza' => $_POST['poliza'] ?? '',
        'cedula' => $_POST['cedula'] ?? '',
        'telefono' => $_POST['numero'] ?? '', // Se mapea 'numero' a 'telefono'
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
        // Aquí está la corrección: ya no se toma la secuencia del formulario,
        // sino que se genera justo antes de la inserción.
        'secuencia_seguro' => getNextSequenceSeguro($conn), 
        'fecha_creacion' => date('Y-m-d H:i:s')
    ];

    try {
        $sql = "INSERT INTO seguros (
            nombre, poliza, cedula, telefono, direccion,
            tipo_vehiculo, servicio, marca, ano, modelo, chasisVehiculo, placa, color, tonCilVehiculo,
            pasajerosVehiculo, observacionesVehiculo, tipoSeguro, tipo_pago, montoSeguro, montoInicial,
            estado, secuencia_seguro, fecha_creacion
        )
        VALUES (
            :nombre, :poliza, :cedula, :telefono, :direccion,
            :tipo_vehiculo, :servicio, :marca, :ano, :modelo, :chasisVehiculo, :placa, :color,
            :tonCilVehiculo, :pasajerosVehiculo, :observacionesVehiculo, :tipoSeguro, :tipo_pago, :montoSeguro, :montoInicial,
            :estado, :secuencia_seguro, :fecha_creacion
        )";

        $stmt = $conn->prepare($sql);
        $stmt->execute($data);

        // Genera el script de SweetAlert para éxito
        $alertScript = "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Registro exitoso!',
                    text: 'El seguro fue registrado correctamente.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Opcional: limpiar el formulario o recargar para mostrar una nueva secuencia
                    window.location.href = window.location.pathname; // Recargar la misma página para una nueva secuencia
                });
            </script>";

    } catch (PDOException $e) {
        // Genera el script de SweetAlert para error
        $alertScript = "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error al registrar',
                    text: 'Hubo un problema: " . htmlspecialchars($e->getMessage()) . "',
                    confirmButtonText: 'Aceptar'
                });
            </script>";
    }
}

// Ahora, la secuencia para el campo del formulario SÓLO se genera si NO es un POST.
// Esto asegura que el campo se muestre vacío o con el primer número cuando la página carga por primera vez,
// y se mantenga así hasta que se recargue después de un registro exitoso.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $nextSeguroSequence = getNextSequenceSeguro($conn);
} else {
    // Si es un POST, el valor del campo no importa porque se generará y se insertará el correcto en la DB.
    // Podrías dejarlo vacío o con el valor que se envió para no romper la UX.
    // En este caso, lo mejor es dejar que la página se recargue y genere la nueva.
    $nextSeguroSequence = ''; // O un valor de placeholder si no quieres que el campo se vea vacío.
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación de Seguros</title>
    <?php include 'modules/layout/header.php'; // Asumo que este header incluye Bootstrap y CSS ?>
    <style>
        /* ... Estilos CSS ... */
    </style>
</head>
<body>

    <?php include 'modules/layout/sidebar.php'; ?>

    <div class="container">
        <div class="main-content">
          <form id="seguroForm" action="/agregarseguro" method="POST" class="mt-4">
            <input type="hidden" name="estado" id="estadoPago" value="En proceso">
            
            <div class="row">
              <h1 class="col-8 mt-5 mb-4">Crear Nuevo Seguro</h1>
                    <div class="col-4 mt-5 mb-4">
                        <label class="form-label fw-bold fs-3">Número de Seguro</label>
                        <input type="text" class="form-control" aria-label="Número de Seguro" name="secuencia_seguro" value="<?= htmlspecialchars($nextSeguroSequence) ?>" readonly required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-9 mb-3">
                        <label class="form-label">Nombre del Cliente</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="col-3 mb-3">
                        <label class="form-label">Num. póliza</label>
                        <input type="text" class="form-control" name="poliza" value="A0159" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cédula</label>
                        <input type="number" class="form-control" name="cedula" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número de Teléfono</label>
                        <input type="number" class="form-control" name="numero" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text" class="form-control" name="direccion" required>
                    </div>
                </div>

                <h4 class="mt-3 mb-4 border-bottom pb-2">Datos del vehículo</h4>
                <div class="row">
                    <div class="col-3 mb-3">
                        <label class="form-label">Tipo de vehículo</label>
                        <select class="form-select" id="tipo_vehiculo" name="tipo_vehiculo" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="moto">Motocicleta</option>
                            <option value="automovilPrivado">Automóvil Privado</option>
                            <option value="automovilPublico">Automóvil Público</option>
                            <option value="jeepeta">Jeepeta o SUV</option>
                            <option value="furgoneta">Furgoneta</option>
                            <option value="minivan">Minivan o Minibús Privado</option>
                            <option value="minibus">Minibús Público</option>
                            <option value="camioneta">Camioneta</option>
                            <option value="camionCaja">Camión de caja o cama</option>
                            <option value="camionVolteo">Camión Volteo</option>
                            <option value="camionCabezote">Camión Cabezote</option>
                            <option value="autobusPrivado">Autobús Privado</option>
                            <option value="autobusPublico">Autobús Público</option>
                            <option value="maquinariaPesada">Maquinaria Pesada</option>
                            <option value="cobertura">Cobertura</option>
                            <option value="remolques">Remolques</option>
                        </select>
                    </div>
                    <div class="col-3 mb-3">
                        <label class="form-label">Servicio</label>
                        <select class="form-select" id="servicioSelect" name="servicio" required>
                            <option value="privado">Privado</option>
                            <option value="publico">Público</option>
                            <option value="sin interes">Sin interés</option>
                            <option value="otros">Otros</option>
                        </select>
                        <input type="text" class="form-control mt-2" id="otroServicioInput" name="servicio" style="display: none;" placeholder="Especifique el servicio" required disabled>
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
                        <input type="number" id="montoSeguro" class="form-control" name="montoSeguro" value="0" required>
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
                        <input type="number" id="montoInicial" class="form-control" name="montoInicial" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <a href="/home" class="btn btn-danger mt-3 w-100">Cancelar</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" id="submitButton" class="btn btn-success mt-3 w-100">Crear Registro</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal de descuento  -->
     <div class="modal fade" id="descuentoModal" tabindex="-1" aria-labelledby="descuentoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="descuentoModalLabel">Aplicar Descuento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Deseas aplicar un descuento?</p>
                <div class="mb-3">
                <label for="descuentoPorcentaje" class="form-label">Porcentaje de Descuento (%)</label>
                <input type="number" class="form-control" id="descuentoPorcentaje" min="0" max="100" value="0">
                </div>
                <p>Monto con descuento: <span id="montoConDescuento" class="fw-bold">0.00</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelarDescuentoButton">Cancelar</button>
                <button type="button" class="btn btn-primary" id="totalizarButton">Totalizar</button>
            </div>
            </div>
        </div>
        </div>
    <script>
        const tipoVehiculoSelect = document.getElementById('tipo_vehiculo');
        const tipoSeguroSelect = document.getElementById('tipo');
        const montoSeguroInput = document.getElementById('montoSeguro');

        const tarifas = {
            moto: {
                'moto-ex': 1666,
                'moto-premium': 2092,
                'moto-max': 2712
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
                superior: 5856,
                plus: 6829,
                elite: 7801
            },
            minivan: {
                elemental: 5750,
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
            camionCaja: {
                elemental: 13856,
                flexible: 16430,
                max: 19000
            },
            camionCabezote: {
                elemental: 18026,
                flexible: 21186,
                max: 24346
            }
        };

        function actualizarMonto() {
            const tipoV = tipoVehiculoSelect.value;
            const tipoS = tipoSeguroSelect.value;

            if (tarifas[tipoV] && tarifas[tipoV][tipoS]) {
                montoSeguroInput.value = tarifas[tipoV][tipoS];
            } else {
                montoSeguroInput.value = ''; // Vaciar si no hay tarifa
            }
        }

        tipoVehiculoSelect.addEventListener('change', actualizarMonto);
        tipoSeguroSelect.addEventListener('change', actualizarMonto);

        // Llamar a la función al cargar la página para establecer el monto inicial si hay valores preseleccionados
        document.addEventListener('DOMContentLoaded', actualizarMonto);
    </script>

    <script>
        const montoInicialInput = document.querySelector('input[name="montoInicial"]');
        const montoSeguroCalculate = document.getElementById('montoSeguro');
        const estadoPagoInput = document.getElementById('estadoPago');
        const formulario = document.getElementById('seguroForm');

        formulario.addEventListener('submit', function (e) {
            const montoInicial = parseFloat(montoInicialInput.value);
            const montoSeguro = parseFloat(montoSeguroCalculate.value);

            if (isNaN(montoInicial) || isNaN(montoSeguro)) {
                estadoPagoInput.value = 'En proceso';
                return;
            }

            if (montoInicial < montoSeguro) {
                estadoPagoInput.value = 'En proceso';
            } else if (montoInicial >= montoSeguro) {
                estadoPagoInput.value = 'Pagado';
            }
        });
    </script>

    <?php include 'modules/layout/footer.php'; ?>

    <?= $alertScript ?>

    <script>
    const servicioSelect = document.getElementById('servicioSelect');
    const otroServicioInput = document.getElementById('otroServicioInput');
    

    servicioSelect.addEventListener('change', function() {
        if (this.value === 'otros') {
            // Cuando se selecciona "Otros", oculta el select y muestra el input de texto
            this.style.display = 'none';
            this.disabled = true; // Deshabilita el select para que no se envíe

            otroServicioInput.style.display = 'block';
            otroServicioInput.disabled = false; // Habilita el input de texto y lo hace requerido
        }
    });

    // Añadir lógica para que si el usuario escribe en el input, 
    // se pueda volver a ocultar si se borra el texto o si se recarga la página
    otroServicioInput.addEventListener('blur', function() {
        if (this.value === '') {
            this.style.display = 'none';
            this.disabled = true;

            servicioSelect.style.display = 'block';
            servicioSelect.disabled = false;
        }
    });
</script>


<script>
    const button = document.getElementById('submitButton');
    const inicial = document.getElementById('montoInicial');
    const monto = document.getElementById('montoSeguro');
    const descuentoInput = document.getElementById('descuentoPorcentaje');
    const montoConDescuentoSpan = document.getElementById('montoConDescuento');
    const totalizarButton = document.getElementById('totalizarButton');
    const cancelarDescuentoButton = document.getElementById('cancelarDescuentoButton');
    const modalDescuento = new bootstrap.Modal(document.getElementById('descuentoModal'));
    const seguroForm = document.getElementById('seguroForm');
    

    function condicion(event) {
        // Evita que el formulario se envíe automáticamente
        event.preventDefault(); 

        if (parseFloat(monto.value) === parseFloat(inicial.value)) {
            // Si los montos son iguales, muestra el modal
            modalDescuento.show();
            
        } else {
            // Si no son iguales, envía el formulario
            seguroForm.submit();
        }
    }

    // Calcular el monto con descuento en tiempo real
    descuentoInput.addEventListener('input', () => {
        const montoBase = parseFloat(monto.value);
        const descuentoPorcentaje = parseFloat(descuentoInput.value);

        if (!isNaN(montoBase) && !isNaN(descuentoPorcentaje)) {
            const montoFinal = montoBase - (montoBase * (descuentoPorcentaje / 100));
            montoConDescuentoSpan.textContent = montoFinal.toFixed(2);
        } else {
            montoConDescuentoSpan.textContent = '0.00';
        }
    });

    // Lógica para el botón de "Totalizar" del modal
    totalizarButton.addEventListener('click', () => {
        // Actualiza el monto inicial con el monto descontado
        inicial.value = montoConDescuentoSpan.textContent;
        // Oculta el modal
        modalDescuento.hide();
        // Envía el formulario
        seguroForm.submit();
    });

    // Lógica para el botón de "Cancelar" del modal
    cancelarDescuentoButton.addEventListener('click', () => {
        // Simplemente oculta el modal
        modalDescuento.hide();
    });

    // Asigna la función al clic del botón del formulario
    button.addEventListener('click', condicion);
</script>
</body>
</html>