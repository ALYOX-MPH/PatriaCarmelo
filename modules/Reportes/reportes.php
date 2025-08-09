
    <title>Tarifas</title>
    
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

<?php include 'modules/layout/sidebar.php'; ?>
<!-- Tu contenido aquí -->

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

<?php include 'modules/layout/footer.php'; ?>