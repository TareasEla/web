<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'docente') {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

include 'conexion.php';

$nombre_docente = $_SESSION['nombre'];

$sql = "SELECT id_registro, nombre_curso, nombre_padre, titulo, descripcion, fecha_entrega_tarea 
        FROM registros 
        WHERE nombre_docente = ? 
        ORDER BY id_registro ASC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $nombre_docente);
$stmt->execute();
$result = $stmt->get_result();

$historial = [];

while ($row = $result->fetch_assoc()) {
    $historial[] = $row;
}

echo json_encode($historial);

$stmt->close();
$conexion->close();
