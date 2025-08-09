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
 <!-- Sidebar -->
  <div class="sidebar text-white d-flex flex-column p-3">
    <div class="text-center mb-4">
      <img src="modules/img/user.png" alt="Usuario" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px;">
      <h5 class="mt-2">Carmelo Placencia</h5>
    </div>
    <ul class="nav nav-pills flex-column">
      <li class="nav-item mb-4 fs-4"><a href="/home" class="nav-link text-white"><i class="bi bi-house-door me-2"></i>Inicio</a></li>
      <li class="mb-4 fs-4"><a href="/agregarseguro" class="nav-link text-white"><i class="bi bi-person me-2"></i>Registrar Seguro</a></li>
      <li class="mb-4 fs-4"><a href="/pagosCuotas" class="nav-link text-white"><i class="bi bi-cash me-2"></i>Pagos / Cuotas</a></li>
      <li class="mb-4 fs-5"><a href="/registros" class="nav-link text-white"><i class="bi bi-card-list me-2"></i>Todos los Registros</a></li>
      <li class="mb-4 fs-4"><a href="/tarifas" class="nav-link text-white"><i class="bi bi-card-list me-2"></i>Tarifas</a></li>
      <li class="mb-4 fs-4"><a href="/reportes" class="nav-link text-white"><i class="bi bi-gear me-2"></i>Reportes</a></li>
      <li class="mb-4 fs-4"><a href="login" class="nav-link text-white"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
    </ul>
  
  </div>