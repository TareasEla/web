<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['nombre'], $_POST['usuario'], $_POST['contraseña'], $_POST['rol'], $_POST['estado']) &&
        !empty($_POST['nombre']) &&
        !empty($_POST['usuario']) &&
        !empty($_POST['contraseña']) &&
        !empty($_POST['rol']) &&
        !empty($_POST['estado'])
    ) {
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contraseña']; // SIN password_hash
        $rol = $_POST['rol'];
        $estado = $_POST['estado'];

        include("conexion.php");

        $sql = $conexion->prepare("INSERT INTO usuario (nombre, usuario, contraseña, rol, estado) 
                                   VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("ssssi", $nombre, $usuario, $contrasena, $rol, $estado);

        if ($sql->execute()) {
            echo "Usuario registrado correctamente.";
        } else {
            echo "Error al registrar: " . $conexion->error;
        }

        $sql->close();
        $conexion->close();
    } else {
        echo "Faltan datos.";
    }
} else {
    echo "Acceso no permitido.";
}
?>
