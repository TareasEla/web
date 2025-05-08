<?php
// Incluir el archivo de conexión
include 'conexion.php';  // Asegúrate de que la ruta al archivo 'conexion.php' sea correcta

// Consulta para obtener los datos de los padres
$sql = "SELECT nombre_estudiante, nombre_apoderado, telefono_apoderado FROM alumno";
$result = $conexion->query($sql);

// Crear un array para almacenar los resultados
$contactos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contactos[] = [
            'nombre_estudiante' => $row['nombre_estudiante'],
            'nombre_apoderado' => $row['nombre_apoderado'] ?: "Apoderado no disponible",
            'telefono_apoderado' => $row['telefono_apoderado']
        ];
    }
}

// Consulta para obtener los cursos disponibles
$sql = "SELECT id_curso, nombre_curso FROM curso";
$result = $conexion->query($sql);

// Generar las opciones para el select
$options = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['id_curso']}'>{$row['nombre_curso']}</option>";
    }
}

// Cerrar la conexión
$conexion->close();
?>
