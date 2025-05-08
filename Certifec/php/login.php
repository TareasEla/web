<?php
include('conexion.php');
session_start();

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

$stmt = $conexion->prepare("SELECT * FROM usuario WHERE usuario = ? AND contraseña = ? AND estado = 1");
$stmt->bind_param("ss", $usuario, $contrasena);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario_data = $resultado->fetch_assoc();

    $_SESSION['usuario'] = $usuario_data['usuario'];
    $_SESSION['nombre'] = $usuario_data['nombre'];
    $_SESSION['rol'] = $usuario_data['rol'];

    // Enviar el rol como respuesta
    echo $usuario_data['rol']; // 'admin' o 'docente'
} else {
    echo "error";
}
?>
