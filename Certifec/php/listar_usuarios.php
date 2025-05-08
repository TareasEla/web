<?php
include("conexion.php");

$sql = "SELECT id_usuario, nombre, usuario, rol, estado FROM usuario";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    echo '<table class="table table-striped table-bordered align-middle text-center">';
    echo '<thead class="table-dark">';
    echo '<tr><th>ID</th><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Estado</th></tr>';
    echo '</thead><tbody>';
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$fila['id_usuario']}</td>
                <td>{$fila['nombre']}</td>
                <td>{$fila['usuario']}</td>
                <td><span class='badge bg-info text-dark'>{$fila['rol']}</span></td>
                <td>" . ($fila['estado'] == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-secondary'>Inactivo</span>") . "</td>
              </tr>";
    }
    echo '</tbody></table>';
} else {
    echo '<p class="text-muted">No hay usuarios registrados.</p>';
}

$conexion->close();
?>
