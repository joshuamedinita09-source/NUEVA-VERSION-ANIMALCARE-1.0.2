function irCrearCuenta(event) {

    event.preventDefault();

    Swal.fire({
        html: `
            <div class="animalcare-alert-content">

                <div class="alert-icon">🐾</div>

                <h2>Crear cuenta</h2>

                <p>
                    ¡Excelente decisión!
                </p>

                <span>
                    Vamos a crear tu cuenta de <strong>AnimalCare</strong>.
                </span>

            </div>
        `,

        confirmButtonText: "Continuar",
        confirmButtonColor: "#0080ff",

        customClass: {
            popup: "animalcare-alert"
        }

    }).then(() => {

        window.location.href = "crear_c.html";

    });
}


function irIniciarSesion(event) {

    event.preventDefault();

    Swal.fire({
        html: `
            <div class="animalcare-alert-content">

                <div class="alert-icon"></div>

                <h2>Iniciar sesión</h2>

                <p>
                    ¡Bienvenido nuevamente a AnimalCare!
                </p>

                <span>
                    Ingresa a tu cuenta para continuar.
                </span>

            </div>
        `,

        confirmButtonText: "Continuar",
        confirmButtonColor: "#0080ff",

        customClass: {
            popup: "animalcare-alert"
        }

    }).then(() => {

        window.location.href = "iniciar_s.html";

    });
}


function comenzarAhora(event) {

    event.preventDefault();

    Swal.fire({
        html: `
            <div class="animalcare-alert-content">

                <div class="alert-icon">🐾</div>

                <h2>¡Vamos a comenzar!</h2>

                <p>
                    Empieza a cuidar la salud y bienestar
                    de tus mascotas.
                </p>

                <span>
                    Crea tu cuenta en <strong>AnimalCare</strong>.
                </span>

            </div>
        `,

        confirmButtonText: "Crear mi cuenta",
        confirmButtonColor: "#0080ff",

        customClass: {
            popup: "animalcare-alert"
        }

    }).then(() => {

        window.location.href = "crear_c.html";

    });
}