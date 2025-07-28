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
      <h5 class="mb-2">Todas los registros con cuotas</h5>
      <p class="mb-3">Realiza los pagos de cada cliente</p>
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
            <td><span class="badge badge-proceso bg-warning">En proceso</span></td>
            <td>              
              <button class="btn btn-secondary btn-sm btn-success aplicarPago"
              data-cuota="$150.00" data-total="$300.00">Aplicar Pago</button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
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
              
             <button class="btn btn-secondary btn-sm btn-success aplicarPago"
              data-cuota="$150.00" data-total="$300.00">Aplicar Pago</button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
            </td>
          </tr>
          <tr>
            <td>Mario Ruiz</td>
            <td>Carro - Kia Rio</td>
            <td>2025-07-18</td>
            <td>$120.00</td>
            <td>$240.00</td>
            <td><span class="badge badge-proceso bg-warning">En proceso</span></td>
            <td>

              <button class="btn btn-secondary btn-sm btn-success aplicarPago"
              data-cuota="$150.00" data-total="$300.00">Aplicar Pago</button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
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
              <button class="btn btn-secondary btn-sm btn-success aplicarPago"
              data-cuota="$150.00" data-total="$300.00">Aplicar Pago</button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-download"></i></button>
              <button class="btn btn-secondary btn-sm btn-danger"><i class="bi bi-printer-fill"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
        </div>

    <!-- modal -->
     <!-- Modal Aplicar Pago -->
<div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="modalPagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPagoLabel">Aplicar Pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Monto a pagar:</strong> <span id="montoPagarModal"></span></p>
        <p><strong>Total del seguro:</strong> <span id="totalSeguroModal"></span></p>
        <input type="number" class="form-control mt-3" placeholder="Ingrese el monto a pagar">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Confirmar Pago</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.querySelectorAll('.aplicarPago').forEach(btn => {
    btn.addEventListener('click', function () {
      const monto = this.getAttribute('data-cuota');
      const total = this.getAttribute('data-total');
      
      document.getElementById('montoPagarModal').textContent = monto;
      document.getElementById('totalSeguroModal').textContent = total;
      
      const modal = new bootstrap.Modal(document.getElementById('modalPago'));
      modal.show();
    });
  });
</script>

        
    </body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>