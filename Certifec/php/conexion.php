<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "plataforma_tareas";

$conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
