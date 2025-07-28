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
      <li class="mb-4 fs-4"><a href="pagosCuotas" class="nav-link text-white"><i class="bi bi-cash me-2"></i>Pagos / Cuotas</a></li>
      <li class="mb-4 fs-5"><a href="registros" class="nav-link text-white"><i class="bi bi-card-list me-2"></i>Todos los Registros</a></li>
      <li class="mb-4 fs-4"><a href="tarifas" class="nav-link text-white"><i class="bi bi-card-list me-2"></i>Tarifas</a></li>
      <li class="mb-4 fs-4"><a href="reportes" class="nav-link text-white"><i class="bi bi-gear me-2"></i>Reportes</a></li>
      <li class="mb-4 fs-4"><a href="login" class="nav-link text-white"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
    </ul>
  
  </div>
    <div class="container-fluid main-content">
         <!-- Últimos seguros registrados -->
    <div class="card p-3 mb-4">
        <div class="row">
      <h5 class="col-6 mb-2">Todas los registros de seguros</h5>
      <form class="col-6 d-flex">
       <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
       <button class="btn btn-outline-success" type="submit">Buscar</button>
     </form>
     </div>
      <p class="mb-5">Verifica y edita los registros de seguros</p>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Cliente</th>
            <th>Vehículo</th>
            <th>Fecha</th>
            <th>Total Cuota</th>
            <th>Total A pagar</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Juan Pérez</td>
            <td>Carro - Toyota Corolla</td>
            <td>2025-07-25</td>
            <td>$150.00</td>
            <td>$300.00</td>
            <td><span class="badge badge-proceso bg-success">Pagado</span></td>
            <td>
              <button class="btn btn-secondary btn-sm btn-success"><i class="bi bi-eye-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
            </td>
          </tr>
          <tr>
            <td>Ana Gómez</td>
            <td>Motor - Honda C90</td>
            <td>2025-07-20</td>
            <td>$100.00</td>
            <td>$200.00</td>
            <td><span class="badge badge-proceso bg-warning">En proceso</span></td>
            <td>
              
              <button class="btn btn-secondary btn-sm btn-success"><i class="bi bi-eye-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
            </td>
          </tr>
          <tr>
            <td>Mario Ruiz</td>
            <td>Carro - Kia Rio</td>
            <td>2025-07-18</td>
            <td>$120.00</td>
            <td>$240.00</td>
            <td><span class="badge badge-pendiente bg-danger">Vencido</span></td>
            <td>

              <button class="btn btn-secondary btn-sm btn-success"><i class="bi bi-eye-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
            </td>
          </tr>
          <tr>
            <td>Laura Díaz</td>
            <td>Motor - AX100</td>
            <td>2025-07-16</td>
            <td>$80.00</td>
            <td>$160.00</td>
            <td><span class="badge badge-proceso bg-warning">En proceso</span></td>
            <td>
            <button class="btn btn-secondary btn-sm btn-success"><i class="bi bi-eye-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
            </td>

            <tr>
            <td>Juan Pérez</td>
            <td>Carro - Toyota Corolla</td>
            <td>2025-07-25</td>
            <td>$150.00</td>
            <td>$300.00</td>
            <td><span class="badge badge-proceso bg-success">Pagado</span></td>
            <td>
              <button class="btn btn-secondary btn-sm btn-success"><i class="bi bi-eye-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
            </td>
          </tr>

          <tr>
            <td>Juan Pérez</td>
            <td>Carro - Toyota Corolla</td>
            <td>2025-07-25</td>
            <td>$150.00</td>
            <td>$300.00</td>
            <td><span class="badge badge-proceso bg-success">Pagado</span></td>
            <td>
              <button class="btn btn-secondary btn-sm btn-success"><i class="bi bi-eye-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
            </td>
          </tr>

          <tr>
            <td>Juan Pérez</td>
            <td>Carro - Toyota Corolla</td>
            <td>2025-07-25</td>
            <td>$150.00</td>
            <td>$300.00</td>
            <td><span class="badge badge-proceso bg-success">Pagado</span></td>
            <td>
              <button class="btn btn-secondary btn-sm btn-success"><i class="bi bi-eye-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
            </td>
          </tr>

          <tr>
            <td>Juan Pérez</td>
            <td>Carro - Toyota Corolla</td>
            <td>2025-07-25</td>
            <td>$150.00</td>
            <td>$300.00</td>
            <td><span class="badge badge-proceso bg-success">Pagado</span></td>
            <td>
              <button class="btn btn-secondary btn-sm btn-success"><i class="bi bi-eye-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
            </td>
          </tr>

          <tr>
            <td>Juan Pérez</td>
            <td>Carro - Toyota Corolla</td>
            <td>2025-07-25</td>
            <td>$150.00</td>
            <td>$300.00</td>
            <td><span class="badge badge-proceso bg-success">Pagado</span></td>
            <td>
              <button class="btn btn-secondary btn-sm btn-success"><i class="bi bi-eye-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
            </td>
          </tr>

          <tr>
            <td>Juan Pérez</td>
            <td>Carro - Toyota Corolla</td>
            <td>2025-07-25</td>
            <td>$150.00</td>
            <td>$300.00</td>
            <td><span class="badge badge-proceso bg-success">Pagado</span></td>
            <td>
              <button class="btn btn-secondary btn-sm btn-success"><i class="bi bi-eye-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
            </td>
          </tr>
          </tr>
        </tbody>
      </table>
    </div>
        </div>
        
    </body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>