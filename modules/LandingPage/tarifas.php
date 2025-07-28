<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
      margin-left: 80px;
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
        <div class="container main-content">
  <h3 class="mb-4">Tarifas por Tipo de Vehículo</h3>
     <div class="row" id="contenedor-tarifas">
    <!-- Aquí van las tarjetas por tipo de vehículo -->
  </div>
</div>

      </div>  
  <script>
  const tarifas = [
    {
      nombre: "Motocicleta",
      value: "moto",
      icono: "bi-bicycle",
      planes: ["Elemental", "Flexible", "Superior", "Plus"]
    },
    {
      nombre: "Automóvil Privado",
      value: "automovilPrivado",
      icono: "bi-car-front",
      planes: ["Básico", "Premium", "Full Cobertura"]
    },
    {
      nombre: "Automóvil Público",
      value: "automovilPublico",
      icono: "bi-taxi-front",
      planes: ["Público Básico", "Con Chofer", "Con Pasajeros"]
    },
    {
      nombre: "Jeepeta o SUV",
      value: "jeepeta",
      icono: "bi-car-front-fill",
      planes: ["Flexible", "Superior", "Familiar"]
    },
    {
      nombre: "Furgoneta",
      value: "furgoneta",
      icono: "bi-truck",
      planes: ["Cargo Básico", "Carga Plus", "Full"]
    },
    {
      nombre: "Minivan o Minibús",
      value: "minivan",
      icono: "bi-bus-front",
      planes: ["Escolar", "Familiar", "Premium"]
    },
    {
      nombre: "Minibús Público",
      value: "minibus",
      icono: "bi-bus-front-fill",
      planes: ["Ruta Básica", "Ruta Flexible", "Ruta Plus"]
    },
    {
      nombre: "Camioneta",
      value: "camioneta",
      icono: "bi-truck-front",
      planes: ["Carga Liviana", "Plus", "Full Cargo"]
    },
    {
      nombre: "Camión de Caja o Cama",
      value: "camionCaja",
      icono: "bi-truck-flatbed",
      planes: ["Carga Básica", "Carga Extendida", "Caja Pro"]
    },
    {
      nombre: "Camión Volteo",
      value: "camionVolteo",
      icono: "bi-truck",
      planes: ["Volteo Estándar", "Volteo Pro"]
    },
    {
      nombre: "Camión Cabezote",
      value: "camionCabezote",
      icono: "bi-truck-front-fill",
      planes: ["Cabeza Básica", "Cabeza Premium"]
    },
    {
      nombre: "Autobús Privado",
      value: "autobusPrivado",
      icono: "bi-bus-front",
      planes: ["Privado Básico", "Viajes Especiales"]
    },
    {
      nombre: "Autobús Público",
      value: "autobusPublico",
      icono: "bi-bus-front-fill",
      planes: ["Público Básico", "Ruta Extendida"]
    },
    {
      nombre: "Maquinaria Pesada",
      value: "maquinariaPesada",
      icono: "bi-gear-wide-connected",
      planes: ["Industrial", "Pesado Plus"]
    },
    {
      nombre: "Cobertura Extra",
      value: "cobertura",
      icono: "bi-shield-check",
      planes: ["Robo", "Daños a terceros", "Todo Riesgo"]
    },
    {
      nombre: "Remolques",
      value: "remolques",
      icono: "bi-truck-flatbed",
      planes: ["Remolque Básico", "Remolque Plus"]
    }
  ];

  const contenedor = document.getElementById("contenedor-tarifas");

  tarifas.forEach(vehiculo => {
    const card = document.createElement("div");
    card.className = "col-md-4 mb-4";
    card.innerHTML = `
      <div class="card shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi ${vehiculo.icono} fs-1 text-primary mb-3"></i>
          <h5 class="card-title">${vehiculo.nombre}</h5>
          <ul class="list-group list-group-flush mt-3">
            ${vehiculo.planes.map(plan => `<li class="list-group-item">${plan}</li>`).join("")}
          </ul>
        </div>
      </div>
    `;
    contenedor.appendChild(card);
  });
</script>

    </body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>