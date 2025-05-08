<?php
require 'conexion.php';

$datos = json_decode(file_get_contents("php://input"), true);

if (!$datos || !is_array($datos)) {
    echo json_encode(['error' => 'Datos inválidos.']);
    exit;
}

$errores = [];
$exitos = [];

foreach ($datos as $registro) {
    $nombre_docente = $registro['nombre_docente'] ?? '';
    $nombre_curso = $registro['nombre_curso'] ?? '';
    $nombre_padre = $registro['nombre_padre'] ?? '';
    $titulo = $registro['titulo'] ?? '';
    $descripcion = $registro['descripcion'] ?? '';
    $fecha_entrega = $registro['fecha_entrega_tarea'] ?? null;

    if (!$nombre_docente || !$nombre_curso || !$nombre_padre || !$titulo || !$descripcion || !$fecha_entrega) {
        $errores[] = "Faltan campos obligatorios para uno de los registros.";
        continue;
    }

    $stmt = $conexion->prepare("INSERT INTO registros (nombre_docente, nombre_curso, nombre_padre, titulo, descripcion, fecha_entrega_tarea)
                                 VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre_docente, $nombre_curso, $nombre_padre, $titulo, $descripcion, $fecha_entrega);

    if ($stmt->execute()) {
        $exitos[] = $nombre_padre;
    } else {
        $errores[] = "Error al insertar para $nombre_padre: " . $stmt->error;
    }

    $stmt->close();
}

if (count($errores) > 0) {
    echo json_encode(['error' => $errores]);
} else {
    echo json_encode(['success' => true]);
}
?>
