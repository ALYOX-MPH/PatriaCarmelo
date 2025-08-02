<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Error 404 - CineMovies Bonao</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      color: white;
    }
    .card {
      background-color: #1e1e1e;
    }
    .navbar, .footer {
      background-color: #000;
    }
    .carousel-caption {
      background-color: rgba(0, 0, 0, 0.5);
      padding: 1rem;
      border-radius: 10px;
    }
    .error {
    font-size: 30rem;
    font-weight: bold;
    background: url('./modules/img/avenger.jpg') no-repeat center center  ;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin: 0;
    line-height: 1;
    
}
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark " >
  <div class="container ">
    <!-- Logo -->
    <a class="navbar-brand " href="#">  
      <img src="modules\img\logo.png" alt="Logo" width="250px" height="90px" class="me-2">
    </a>
    </div>
</nav>
<!-- error 404 -->
  <div class="container d-flex align-items-center justify-content-center  mt-5" style="height: 65vh; width: 100%;">
    <div class="row">
        <h1 class="error col-12 text-center" >404</h1>
        <p class="col-12 text-center fs-4 ">La página que buscas no existe.</p>
        <div class="col d-flex align-items-center justify-content-center">
        <a href="/home" class="btn btn-danger fs-5">Volver al inicio</a>   
        </div>
    </div> 
  </div>
   
<!-- Footer -->
  <footer class="footer text-center py-4 mt-5 text-white">
    <p>&copy; 2025 CineMovies Bonao. Todos los derechos reservados.</p>
    <p><small>Ubicación: Bonao, República Dominicana</small></p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
