<?php include 'modules/layout/header.php'; ?>
    <title>Tarifas</title>
    

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
    <?php include 'modules/layout/sidebar.php'; ?>
  
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

<?php include 'modules/layout/footer.php'; ?>