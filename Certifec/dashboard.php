<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<div class="container">
  <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h2>
  <p>Esta es la plataforma de tareas diarias.</p>
</div>
</body>
</html>
