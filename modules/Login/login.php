<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - PatriaCarmelo</title>
  <?php include 'modules/layout/header.php'; ?>
  <style>
    body {
      background-color: #ffffffff;
      color: white;
    }
    .login-container {
      max-width: 400px;
      margin: 100px auto;
      background-color: #ffffffff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.66);
    }
  </style>
</head>
<body>

  <div class="login-container text-center">
    <!-- <img src="modules\img\LogoPatria.png" alt="logo" style="width: 100%; height: 100%;"> -->
    <img src="modules\img\carmelo.png" alt="logo" style="width: 100%; height: 100%;">
    <div class="form-group mb-3 text-start">
      <label for="usuario">Usuario</label>
      <input type="text" id="usuario" class="form-control" placeholder="admin">
    </div>
    <div class="form-group mb-4 text-start">
      <label for="clave">Contraseña</label>
      <input type="password" id="clave" class="form-control" placeholder="1234">
    </div>
    <button onclick="iniciarSesion()" class="btn w-100" style="background-color: #e11f1bff; color: white;">Iniciar sesión</button>
    <p id="mensaje" class="mt-3 text-danger"></p>
    <img src="modules\img\LogoPatria.png" alt="logo" style="width: 50%; height: 50%;">
  </div>

  <script>
    function iniciarSesion() {
      const user = document.getElementById("usuario").value.trim();
      const pass = document.getElementById("clave").value.trim();

      if (user === "admin" && pass === "1234") {
        window.location.href = "home"; // ← Aquí va tu panel
      } else {
        document.getElementById("mensaje").innerText = "Credenciales incorrectas.";
      }
    }
  </script>
</body>
</html>
