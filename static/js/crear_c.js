function validarRegistro(event) {
    event.preventDefault();

    const formulario = event.target;

    const nombre = document.getElementById("nombre").value.trim();
    const apellido = document.getElementById("apellido").value.trim();
    const email = document.getElementById("email").value.trim();
    const telefono = document.getElementById("telefono").value.trim();
    const direccion = document.getElementById("direccion").value.trim();
    const password = document.getElementById("password").value;
    const confirmarPassword = document.getElementById("confirm-password").value;

    // Validar nombre
    if (nombre === "") {
        Swal.fire({
            icon: "warning",
            title: "Campo vacío",
            text: "Por favor ingresa tu nombre."
        });
        return;
    }

    // Validar apellido
    if (apellido === "") {
        Swal.fire({
            icon: "warning",
            title: "Campo vacío",
            text: "Por favor ingresa tu apellido."
        });
        return;
    }

    // Validar correo
    if (email === "") {
        Swal.fire({
            icon: "warning",
            title: "Campo vacío",
            text: "Por favor ingresa tu correo electrónico."
        });
        return;
    }

    // Validar teléfono
    if (telefono === "") {
        Swal.fire({
            icon: "warning",
            title: "Campo vacío",
            text: "Por favor ingresa tu teléfono."
        });
        return;
    }

    // Validar dirección
    if (direccion === "") {
        Swal.fire({
            icon: "warning",
            title: "Campo vacío",
            text: "Por favor ingresa tu dirección."
        });
        return;
    }

    // Validar contraseña
    if (password === "") {
        Swal.fire({
            icon: "warning",
            title: "Campo vacío",
            text: "Por favor ingresa una contraseña."
        });
        return;
    }

    // Confirmar contraseña
    if (confirmarPassword === "") {
        Swal.fire({
            icon: "warning",
            title: "Campo vacío",
            text: "Confirma tu contraseña."
        });
        return;
    }

    // Comprobar contraseñas
    if (password !== confirmarPassword) {
        Swal.fire({
            icon: "error",
            title: "Contraseñas diferentes",
            text: "Las contraseñas no coinciden."
        });
        return;
    }

    // Simulación de validación de correo existente (puedes cambiarlo a true para probar la alerta)
    const correoYaExiste = false; 

    if (correoYaExiste) {
        Swal.fire({
            icon: "error",
            title: "Correo ya registrado",
            text: "Este correo ya está en uso. Por favor, utiliza otro o inicia sesión."
        });
        return;
    }

    // Todo correcto: enviar el formulario a crear_c2.php
    formulario.submit();
}

function mostrarPassword(id, icono) {
    const input = document.getElementById(id);

    if (input.type === "password") {
        input.type = "text";
        icono.classList.remove("fa-eye");
        icono.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icono.classList.remove("fa-eye-slash");
        icono.classList.add("fa-eye");
    }
}