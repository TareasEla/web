<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'docente') {
    header("Location: index.php");
    exit();
}


include('php/BDdocente.php');  
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="icon" href="img/escudo.png" type="image/png">
<title>Menú Principal - Enrique López Albújar</title>
<link rel="stylesheet" href="css/panel.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<div class="d-flex">
  <!-- Menú lateral -->
  <nav class="sidebar text-black p-3">
    <div class="text-center">
      <img src="../img/escudo.png" class="logo mb-2" alt="Logo Colegio">
      <h5 class="fw-bold">ENRIQUE LÓPEZ ALBÚJAR</h5>
      <h6 class="text-black mt-2">👤 Docente: <?php echo $_SESSION['nombre']; ?></h6>
    </div>

    <hr class="border-light">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="#" id="btn-inicio"><i class="bi bi-house-door me-2"></i>Página Principal</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" id="btn-registrar"><i class="bi bi-pencil-square me-2"></i>Registrar Tarea</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="php/historial.php" id="btn-historial"><i class="bi bi-clock-history me-2"></i>Historial</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-danger" href="php/logout.php">
          <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
        </a>
      </li>
    </ul>
    <div class="mt-auto text-center small text-secondary">
      © 2025 Adrian <br> Todos los derechos reservados
    </div>
  </nav>

  <!-- Contenido principal -->
  <main class="content flex-grow-1">
    <div class="encabezado">
      <img src="../img/fondo-aula.jpg" class="encabezado-img" alt="Encabezado Colegio">
    </div>
    <div class="container mt-4" id="contenido-principal">
      <h2 class="fw-bold">¡Bienvenido al Sistema de Envío de Tareas Online!</h2>
      <div class="bg-light p-4 rounded shadow-sm mt-3">
        <p class="mb-2">
          Este sistema permite a los estudiantes de la <strong>I.E. Enrique López Albújar</strong> entregar sus tareas a tiempo, promoviendo el aprendizaje y eficiente.
        </p>
        <p>
          Con esta plataforma podrás registrar tareas, revisar el historial y mejorar tu organización académica en un entorno amigable y seguro.
        </p>
      </div>
    </div>
  </main>
</div>

<script>
  const nombreDocente = "<?php echo $_SESSION['nombre']; ?>";
  var rolUsuario = "<?php echo $_SESSION['rol']; ?>"; 
  
  function cambiarTituloYActivo(titulo, idActivo) {
    document.title = titulo + " - Enrique López Albújar";
    document.querySelectorAll('.nav-link').forEach(link => {
      link.classList.remove('active');
    });
    const activo = document.getElementById(idActivo);
    if (activo) activo.classList.add('active');
  }

  // Botón Registrar Tarea

// Escucha click en el botón para cargar el formulario



document.getElementById('btn-registrar').addEventListener('click', function (e) {
  e.preventDefault();
  cambiarTituloYActivo("Registrar Tarea", "btn-registrar");

  fetch("php/obtener_cursos_y_contactos.php") 
    .then(res => res.json())
    .then(data => {
      const { cursosHTML, contactosHTML } = data;

      document.getElementById('contenido-principal').innerHTML = `
        <div class="container mt-4">
          <div class="card shadow-lg rounded-4">
            <div class="card-header bg-success text-white text-center rounded-top-4">
              <h4><i class="bi bi-pencil-square me-2"></i>Registrar Nueva Tarea</h4>
            </div>
            <div class="card-body p-4">
              <form id="form-tarea" class="row g-3">
                ${rolUsuario === 'docente' ? `
                <div class="col-12">
                  <label for="docente" class="form-label fw-bold"><i class="bi bi-person-fill me-2"></i>Docente</label>
                  <input type="text" class="form-control border border-secondary" id="docente" value="${nombreDocente}" readonly>
                </div>` : ''}

                <div class="col-md-6">
                  <label for="curso" class="form-label fw-bold"><i class="bi bi-journal-bookmark-fill me-2"></i>Curso</label>
                  <select id="curso" class="form-select border border-secondary" required>
                    <option value="">Seleccione un curso</option>
                    ${cursosHTML}
                  </select>
                </div>

                <div class="col-md-12">
                  <label for="contactos" class="form-label fw-bold"><i class="bi bi-people-fill me-2"></i>Contactos de los Padres</label>
                  <div class="form-text mb-2">
                    Puedes seleccionar múltiples contactos manteniendo presionada la tecla Ctrl (Windows) o Cmd (Mac).
                  </div>
                  <select id="contactos" class="form-select border border-secondary" multiple required size="6">
                    <option value="todos" class="fw-bold text-primary">Seleccionar a todos</option>
                    ${contactosHTML}
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="titulo" class="form-label fw-bold"><i class="bi bi-type me-2"></i>Título de la Tarea</label>
                  <input type="text" class="form-control border border-secondary" id="titulo" placeholder="Ej. Tarea de Matemática N°3" required>
                </div>

                <div class="col-md-12">
                  <label for="descripcion" class="form-label fw-bold"><i class="bi bi-card-text me-2"></i>Descripción de la Tarea</label>
                  <textarea class="form-control border border-secondary" id="descripcion" rows="4" placeholder="📝 Describe la tarea detalladamente..." required></textarea>
                </div>
                <div class="col-md-6">
                 <label for="fecha_entrega" class="form-label fw-bold">
                <i class="bi bi-calendar-event me-2"></i>Fecha de Entrega
                </label>
                <input type="date" class="form-control border border-secondary" id="fecha_entrega" required>
                </div>


                <div class="col-12 text-end mt-3">
                  <button type="submit" class="btn btn-success btn-lg rounded-pill px-4 me-2">
                    <i class="bi bi-send-fill me-2"></i>Enviar Tarea
             
                </div>
              </form>
            </div>
          </div>
        </div>
      `;
 // Listener para seleccionar todos los contactos
document.getElementById("contactos").addEventListener("change", function () {
  const opciones = Array.from(this.options);
  const seleccionados = Array.from(this.selectedOptions).map(o => o.value);

  if (seleccionados.includes("todos")) {
    this.selectedIndex = -1; // Deselecciona todo primero
    opciones.forEach(op => {
      if (op.value !== "todos") {
        op.selected = true;
      }
    });
  }
});

// Listener del formulario
document.getElementById("form-tarea").addEventListener("submit", function (e) {
  e.preventDefault();

  const cursoSelect = document.getElementById("curso");
  const curso = cursoSelect.value;
  const cursoNombre = cursoSelect.options[cursoSelect.selectedIndex].text;
  const titulo = document.getElementById("titulo").value.trim();
  const descripcion = document.getElementById("descripcion").value.trim();
  const fechaEntrega = document.getElementById("fecha_entrega").value.trim();

  const contactos = Array.from(document.getElementById("contactos").selectedOptions)
    .map(opt => opt.value)
    .filter(num => num !== "todos");

  if (!curso || !titulo || !descripcion || !fechaEntrega || contactos.length === 0) {
    alert("Por favor, complete todos los campos y seleccione al menos un contacto.");
    return;
  }

  const registros = contactos.map(num => ({
    nombre_docente: nombreDocente,
    nombre_curso: cursoNombre,
    nombre_padre: num,
    titulo,
    descripcion,
    fecha_entrega_tarea: fechaEntrega
  }));

  fetch("php/guardar_tarea.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(registros)
  })
    .then(res => res.json())
    .then(respuesta => {
      if (respuesta.success) {
        alert("✅ Tarea registrada y enviada por WhatsApp con éxito.");

        const mensaje = encodeURIComponent(
          `📚 *Nueva tarea asignada*\n\n📝 *Título:* _${titulo}_\n\n📄 *Descripción:* ${descripcion}\n\n👨‍🏫 *Docente:* _${nombreDocente}_\n\n📚 *Curso:* _${cursoNombre}_\n\n📅 *Fecha de entrega:* _${fechaEntrega}_`
        );

        // Enviar a cada contacto con un pequeño retraso para asegurar que se abran todas las ventanas
        contactos.forEach((num, index) => {
          setTimeout(() => {
            const url = `https://wa.me/51${num}?text=${mensaje}`;
            window.open(url, '_blank');
          }, index * 2000);  // Ajusta el tiempo para un pequeño retraso entre los envíos
        });

        document.getElementById("form-tarea").reset();
      } else {
        alert("❌ Error al guardar la tarea. Intenta nuevamente.");
        console.error(respuesta.error);
      }
    })
    .catch(error => {
      console.error("Error al guardar y enviar tarea:", error);
      alert("❌ Error al procesar la tarea. Intenta nuevamente.");
    });
});

});
});



  // Manejar botón Página Principal
  document.getElementById('btn-inicio').addEventListener('click', function (e) {
    e.preventDefault();
    cambiarTituloYActivo("Menú Principal", "btn-inicio");

    document.getElementById('contenido-principal').innerHTML = `
      <h2 class="fw-bold">¡Bienvenido al Sistema de Envío de Tareas Online!</h2>
      <div class="bg-light p-4 rounded shadow-sm mt-3">
        <p class="mb-2">
          Este sistema permite a los estudiantes de la <strong>I.E. Enrique López Albújar</strong> entregar sus tareas a tiempo, promoviendo el aprendizaje y eficiente.
        </p>
        <p>
          Con esta plataforma podrás registrar tareas, revisar el historial y mejorar tu organización académica en un entorno amigable y seguro.
        </p>
      </div>
    `;
  });
  document.getElementById('btn-historial').addEventListener('click', function (e) {
  e.preventDefault();
  cambiarTituloYActivo("Historial de Tareas", "btn-historial");

  fetch("php/obtener_historial.php")
    .then(res => res.json())
    .then(data => {
      if (!Array.isArray(data)) {
        throw new Error("Respuesta inválida");
      }

      let tablaHTML = `
        <div class="container mt-4">
          <div class="card shadow-lg rounded-4">
            <div class="card-header bg-primary text-white text-center rounded-top-4">
              <h4><i class="bi bi-clock-history me-2"></i>Historial de Tareas</h4>
            </div>
            <div class="card-body p-4 table-responsive">
              <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark">
                  <tr>
                    <th>ID</th>
                    <th>Curso</th>
                    <th>Padre</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha de Entrega</th>
                  </tr>
                </thead>
                <tbody>
      `;

      if (data.length === 0) {
        tablaHTML += `<tr><td colspan="6">No se encontraron tareas registradas.</td></tr>`;
      } else {
        data.forEach(registro => {
          tablaHTML += `
            <tr>
              <td>${registro.id_registro}</td>
              <td>${registro.nombre_curso}</td>
              <td>${registro.nombre_padre}</td>
              <td>${registro.titulo}</td>
              <td>${registro.descripcion}</td>
              <td>${registro.fecha_entrega_tarea}</td>
            </tr>
          `;
        });
      }

      tablaHTML += `
                </tbody>
              </table>
            </div>
          </div>
        </div>
      `;

      document.getElementById("contenido-principal").innerHTML = tablaHTML;
    })
    .catch(error => {
      console.error("Error al cargar historial:", error);
      alert("❌ Error al cargar historial.");
    });
});


</script>

</body>
</html>
