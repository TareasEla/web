<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="img/escudo.png" type="image/png">
<title>Login - TAREAS</title>
  <link rel="stylesheet" href="css/estilos.css">
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>
<body>

<div id="app" class="background">
  <div class="overlay">
    <div class="login-container">
      
      <!-- Columna izquierda: Formulario -->
      <div class="login-box">
        <img src="img/escudo.png" alt="Logo" class="logo">
        <h2>INSTITUCIÓN EDUCATIVA<br>ENRIQUE LÓPEZ ALBÚJAR</h2>
        <form @submit.prevent="login">
          <input type="text" v-model="usuario" placeholder="Nombre de usuario" required>
          <input type="password" v-model="contrasena" placeholder="Contraseña" required>
          <button type="submit">Iniciar sesión</button>
          <a href="#" class="forgot-password"></a>
        </form>
      </div>

      <!-- Columna derecha: Mensaje inferior -->
      <div class="info-box">
        <div class="info-footer">
          © 2025 ELA. Todos los derechos reservados.
        </div>
      </div>

    </div>
  </div>
</div>
<script src="js/app.js"></script>

</body>
</html>
