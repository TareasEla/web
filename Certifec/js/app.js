new Vue({
  el: "#app",
  data: {
    usuario: "",
    contrasena: ""
  },
  methods: {
    login() {
      fetch("php/login.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `usuario=${encodeURIComponent(this.usuario)}&contrasena=${encodeURIComponent(this.contrasena)}`
      })
      .then(response => response.text())
      .then(data => {
        const cleanedData = data.trim().toLowerCase(); // Limpiar y convertir a minúsculas por seguridad
        console.log("Rol recibido:", cleanedData);
        
        if (cleanedData === "admin") {
          window.location.href = "Menuu.php";
        } else if (cleanedData === "docente") {
          window.location.href = "Menudocente.php";
        } else {
          alert("Credenciales incorrectas o usuario inactivo.");
        }
      })
      .catch(error => {
        alert("Error de conexión con el servidor.");
        console.error(error);
      });
    }
  }
});
