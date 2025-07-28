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
      margin-left: 380px;
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
   
  <div class="container main-content">
  <h3 class="mb-4">Reportes del Sistema</h3>
  <div class="row" id="contenedor-reportes">
    <!-- Se insertan desde JS -->
  </div>
</div>


<script>
  const reportes = [
    { titulo: "Todos los Clientes", descripcion: "Ver todos los clientes registrados en el sistema.", icono: "bi-person-lines-fill" },
    { titulo: "Todos los Pagos", descripcion: "Lista de todos los pagos realizados hasta la fecha.", icono: "bi-cash-coin" },
    { titulo: "Pagos por Cliente", descripcion: "Filtra los pagos realizados por cliente específico.", icono: "bi-person-check" },
    { titulo: "Pagos Pendientes", descripcion: "Ver los clientes con cuotas aún por pagar.", icono: "bi-exclamation-circle" },
    { titulo: "Seguros Activos", descripcion: "Seguros vigentes en este momento.", icono: "bi-shield-check" },
    { titulo: "Seguros Vencidos", descripcion: "Lista de seguros cuyo vencimiento ya pasó.", icono: "bi-shield-x" },
    { titulo: "Seguros por Vencer", descripcion: "Ver seguros que vencen en los próximos días.", icono: "bi-calendar-event" },
    { titulo: "Clientes con Más Pagos", descripcion: "Ranking de los clientes más constantes en sus pagos.", icono: "bi-trophy" },
    { titulo: "Ingresos Mensuales", descripcion: "Ver los ingresos mes por mes en el sistema.", icono: "bi-graph-up-arrow" },
    { titulo: "Por Tipo de Vehículo", descripcion: "Cantidad de seguros por cada tipo de vehículo.", icono: "bi-truck-front" },
    { titulo: "Clientes Inactivos", descripcion: "Clientes que no han hecho ningún pago.", icono: "bi-slash-circle" },
    { titulo: "Reporte General", descripcion: "Todo en un solo reporte: clientes, pagos, fechas y más.", icono: "bi-collection" }
  ];

  const contenedor = document.getElementById("contenedor-reportes");

  reportes.forEach(r => {
    const card = document.createElement("div");
    card.className = "col-md-4 mb-4";
    card.innerHTML = `
      <div class="card shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi ${r.icono} fs-1 text-primary mb-3"></i>
          <h5 class="card-title">${r.titulo}</h5>
          <p class="card-text">${r.descripcion}</p>
          <button class="btn btn-outline-primary btn-sm mt-2">Ver reporte</button>
        </div>
      </div>
    `;
    contenedor.appendChild(card);
  });
</script>

 </body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>