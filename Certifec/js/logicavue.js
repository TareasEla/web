new Vue({
    el: '#menuApp',
    data: {
      seccionActiva: 'registrar',
      tarea: {
        curso: '',
        docente: '',
        titulo: '',
        descripcion: '',
        telefono: ''
      }
    },
    methods: {
      mostrarSeccion(seccion) {
        this.seccionActiva = seccion;
      },
      registrarTarea() {
        alert(`Tarea registrada y enviada a ${this.tarea.telefono}`);
        this.tarea = {
          curso: '',
          docente: '',
          titulo: '',
          descripcion: '',
          telefono: ''
        };
      },
      cerrarSesion() {
        alert("Cerrando sesión...");
        window.location.href = "../index.html";
      }
    }
  });
  