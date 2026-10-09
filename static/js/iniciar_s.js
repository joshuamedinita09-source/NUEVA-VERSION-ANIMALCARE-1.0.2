document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("login-Form");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const forgot = document.querySelector(".forgot-link a");

   // INICIAR SESIÓN
    if (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            const correo = email.value.trim();
            const clave = password.value.trim();

            if (correo === "" && clave === "") {
                Swal.fire({
                    html: '<div class="animalcare-alert-content"><div class="alert-icon">📋</div><h2>Campos obligatorios</h2><p>Debes ingresar tu correo electrónico y contraseña.</p></div>',
                    confirmButtonText: "Completar campos",
                    confirmButtonColor: "#0080ff"
                });
                return;
            }

            if (correo === "") {
                Swal.fire({
                    html: '<div class="animalcare-alert-content"><div class="alert-icon">📧</div><h2>Correo obligatorio</h2><p>Debes ingresar tu correo electrónico.</p></div>',
                    confirmButtonText: "Ingresar correo",
                    confirmButtonColor: "#0080ff"
                });
                email.focus();
                return;
            }

            if (clave === "") {
                Swal.fire({
                    html: '<div class="animalcare-alert-content"><div class="alert-icon">🔐</div><h2>Contraseña obligatoria</h2><p>Debes ingresar tu contraseña.</p></div>',
                    confirmButtonText: "Ingresar contraseña",
                    confirmButtonColor: "#0080ff"
                });
                password.focus();
                return;
            }

            // Si las validaciones básicas pasan, muestra la alerta y envía a PHP
            Swal.fire({
                html: '<div class="animalcare-alert-content"><div class="alert-icon">🐾</div><h2>¡Bienvenido a AnimalCare!</h2><p>Verificando credenciales...</p></div>',
                confirmButtonText: "Continuar",
                confirmButtonColor: "#0080ff"
            }).then(function () {
                // Envía el formulario al procesador de PHP
                form.submit();
            });
        });
    }

    // OLVIDÉ MI CONTRASEÑA
    if (forgot) {
        forgot.addEventListener("click", function (event) {
            event.preventDefault();
            Swal.fire({
                html: '<div class="animalcare-alert-content"><div class="alert-icon">🔑</div><h2>¿Olvidaste tu contraseña?</h2><p>Próximamente podrás restablecerla desde aquí.</p></div>',
                confirmButtonText: "Entendido",
                confirmButtonColor: "#0080ff"
            });
        });
    }

});

