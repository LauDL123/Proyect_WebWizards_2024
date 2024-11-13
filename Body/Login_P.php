<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/css_Login.css">
</head>
<body>

  <div class="container">
    <!-- Formulario de Inicio de Sesión -->
    <div class="Login_Duenio_container">
      <?php
        // Verificar si hay un mensaje de registro exitoso
        if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso') {
          echo "<p class='Verde'>Registro exitoso</p>";
        }
        ?>
      <h2>Iniciar Sesión 🔒</h2>
          <form action="../Backend/backend_Login.php" method="POST">
            <div class="input-group">
              <label for="login_username">Usuario 🔓</label>
              <input type="text" id="login_username" name="username" required>
            </div>
              <div class="input-group">
                <label for="login_password">Contraseña 🔑</label>
                <input type="password" id="login_password" name="password" required>
              </div>
              <button type="submit">Ingresar</button>
          </form>
          <p>¿No estás registrado? <a href="Register.html">Hazlo aquí</a></p>
          <p>¿Quieres volver al incio? <a href="index.php">Vuelve aquí</a></p>
      </div>
  </div>

</body>
</html>
