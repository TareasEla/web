<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require 'conexion.php'; // Asegúrate de que este archivo tenga la conexión a la base de datos

header('Content-Type: application/json');

// Verificar si la conexión fue exitosa
if (!$conexion) {
    echo json_encode(['error' => 'No se pudo establecer la conexión con la base de datos.']);
    exit;
}

try {
    // 1. Obtener cursos (de toda la tabla curso)
    $queryCursos = $conexion->query("SELECT id_curso, nombre_curso FROM curso");
    if (!$queryCursos) {
        throw new Exception("Error al ejecutar la consulta de cursos: " . $conexion->error);
    }
    $cursos = $queryCursos->fetch_all(MYSQLI_ASSOC);

    // 2. Obtener contactos de la tabla alumno
    $queryContactos = $conexion->query("SELECT nombre_estudiante, nombre_apoderado, telefono_apoderado FROM alumno");
    if (!$queryContactos) {
        throw new Exception("Error al ejecutar la consulta de contactos: " . $conexion->error);
    }
    $contactos = $queryContactos->fetch_all(MYSQLI_ASSOC);

    // 3. Armar HTML para cursos
    $cursosHTML = '';
    foreach ($cursos as $curso) {
        $id = htmlspecialchars($curso['id_curso']);
        $nombre = htmlspecialchars($curso['nombre_curso']);
        $cursosHTML .= "<option value='$id'>$nombre</option>";
    }

    // 4. Armar HTML para contactos
    $contactosHTML = '';
    foreach ($contactos as $c) {
        $tel = htmlspecialchars($c['telefono_apoderado']);
        $apod = htmlspecialchars($c['nombre_apoderado']);
        $estu = htmlspecialchars($c['nombre_estudiante']);
        $contactosHTML .= "<option value='$tel'>+51 $tel - $apod (Padre/Madre de $estu)</option>";
    }

    // 5. Enviar respuesta como JSON
    echo json_encode([
        'cursosHTML' => $cursosHTML,
        'contactosHTML' => $contactosHTML
    ]);
    exit;

} catch (Exception $e) {
    // Captura cualquier excepción que ocurra
    echo json_encode(['error' => 'Hubo un problema al procesar los datos: ' . $e->getMessage()]);
}
?>
