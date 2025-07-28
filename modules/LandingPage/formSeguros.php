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
        <form id="seguroForm" class="mt-4">
            <div class="row">
            <div class="col-9 mb-3">
                <label for="nombre" class="form-label">Nombre del Seguro</label>
                <input type="text" class="form-control" id="nombre" required>
            </div>
            <div class="col-3 mb-3">
                <label for="nombre" class="form-label">Num. poliza</label>
                <input type="text" class="form-control" id="nombre" required>
            </div>
            <div class="mb-3">
                <label  class="form-label">Cedula</label>
                <input type="number" class="form-control" id="cedula" required>
            </div>
            <div class="mb-3">
                <label  class="form-label">Numero</label>
                <input type="number" class="form-control" id="numero" required>
            </div>
             <div class="mb-3">
                <label  class="form-label">Direccion</label>
                <input type="text" class="form-control" id="direccion" required>
            </div>
            <h4 class="mt-3 mb-4 border-bottom pb-2 ">Datos del vehículo</h4>
             <div class="col-3 mb-3">
                <label for="tipo" class="form-label">Tipo de vehículo</label>
                <select class="form-select" id="tipo" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="moto">Motocicleta</option>
                    <option value="automovilPrivado">Automovil Privado</option>
                    <option value="automovilPublico">Automovil Publico</option>
                    <option value="jeepeta">Jeepeta o Suv</option>
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
                <label for="tipo" class="form-label">Servicio</label>
                <select class="form-select" id="tipo" required>
                    <option value="">Privado</option>
                    <option value="carro">Publico</option>
                    <option value="moto">Sin interes</option>
                </select>
            </div>    
             <div class="col-3 mb-3">
                <label  class="form-label">Marca</label>
                <input type="text" class="form-control" id="marcaVehiculo" required>
            </div> 
             <div class="col-3 mb-3">
                <label  class="form-label">Año</label>
                <input type="date" class="form-control" id="anoVehiculo" required>
            </div>
             <div class="col-4 mb-3">
                <label  class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modeloVehiculo" required>
            </div> 
             <div class="col-4 mb-3">
                <label  class="form-label">Chasis</label>
                <input type="text" class="form-control" id="chasisVehiculo" required>
            </div>
              <div class="col-4 mb-3">
                <label  class="form-label">Placa</label>
                <input type="text" class="form-control" id="placaVehiculo" required>
            </div>
             <div class="col-4 mb-3">
                <label  class="form-label">Color</label>
                <input type="text" class="form-control" id="colorVehiculo" required>
            </div> 
             <div class="col-4 mb-3">
                <label  class="form-label">Ton/Cil</label>
                <input type="text" class="form-control" id="tonCilVehiculo" required>
            </div>
              <div class="col-4 mb-3">
                <label  class="form-label">Pasajeros</label>
                <input type="number" class="form-control" id="pasajerosVehiculo" required>
            </div>
             <div class="mb-3">
                <label  class="form-label">Observaciones</label>
                <input type="text" class="form-control" id="observacionesVehiculo" required>
            </div>
            
            <h4 class="mt-3 mb-4 border-bottom pb-2 ">Datos de pago</h4>
            <div class="col-6 mb-3">
                <label for="tipo" class="form-label">Tipo de Seguro</label>
                <select class="form-select" id="tipo" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="elemental">Elemental</option>
                    <option value="flexible">Flexible</option>
                    <option value="superior">Superior</option>
                    <option value="plus">Plus</option>
                    <option value="elite">Elite</option>
                </select>
            </div>     
            <div class="col-6 mb-3">
                <label for="montoSeguro" class="form-label">Monto Por tipo de Seguro</label>
                <input type="number" class="form-control" id="montoSeguro" value="200" required>
            </div> 

             <div class="col-6 mb-3">
                <label for="tipo" class="form-label">Tipo de pago</label>
                <select class="form-select" id="tipo" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>
             <div class="col-6 mb-3">
                <label  class="form-label">Monto inicial</label>
                <input type="number" class="form-control" id="montoInicial" required>
            </div>
            <div class="row">
            <div class="col-6">
                <a href="/extrenos" class="btn btn-danger mt-3 w-100">Cancelar</a>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-success mt-3 w-100">Crear Registro</button>
            </div>
            </div>
        </form>
        </div>
        </div>
        
    </body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>