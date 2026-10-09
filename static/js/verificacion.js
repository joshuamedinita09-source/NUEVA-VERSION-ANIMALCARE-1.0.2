document.addEventListener("DOMContentLoaded", function () {

    const inputs = document.querySelectorAll(".otp-input");

    const form = document.querySelector("formVerificacion");

    const resend = document.querySelector(".resend-link a");


    /* =====================================
       ESCRIBIR NÚMEROS AUTOMÁTICAMENTE
    ===================================== */

    inputs.forEach(function (input, index) {

        input.addEventListener("input", function () {

            // Solo permite números
            input.value = input.value.replace(/\D/g, "");


            // Pasar al siguiente campo
            if (
                input.value !== "" &&
                index < inputs.length - 1
            ) {
                inputs[index + 1].focus();
            }

        });


        /* =================================
           BACKSPACE
        ================================= */

        input.addEventListener("keydown", function (event) {

            if (
                event.key === "Backspace" &&
                input.value === "" &&
                index > 0
            ) {

                inputs[index - 1].focus();

            }

        });

    });


    /* =====================================
       VERIFICAR CÓDIGO
    ===================================== */

    form.addEventListener("submit", function (event) {

        event.preventDefault();

        let camposLlenos = 0;


        inputs.forEach(function (input) {

            if (input.value.trim() !== "") {

                camposLlenos++;

            }

        });


        /* =================================
           CAMPOS VACÍOS
        ================================= */

        if (camposLlenos === 0) {

            Swal.fire({

                html: `
                    <div class="animalcare-alert-content">

                        <div class="alert-icon">
                            📋
                        </div>

                        <h2>
                            Campos obligatorios
                        </h2>

                        <p>
                            Debes completar los campos
                            del código de verificación.
                        </p>

                        <span>
                            Todos los campos son obligatorios.
                        </span>

                    </div>
                `,

                confirmButtonText: "Completar campos",

                confirmButtonColor: "#0080ff",

                customClass: {

                    popup: "animalcare-alert",

                    confirmButton: "animalcare-button"

                }

            });

            return;
        }


        /* =================================
           CÓDIGO INCOMPLETO
        ================================= */

        if (camposLlenos < 4) {

            const faltan = 4 - camposLlenos;


            Swal.fire({

                html: `
                    <div class="animalcare-alert-content">

                        <div class="alert-icon">
                            ⚠️
                        </div>

                        <h2>
                            ¡Código incompleto!
                        </h2>

                        <p>
                            Has ingresado
                            ${camposLlenos} de 4 números.
                        </p>

                        <span>
                            Te faltan
                            <strong>${faltan}</strong>
                            número${faltan > 1 ? "s" : ""}.
                        </span>

                    </div>
                `,

                confirmButtonText: "Completar código",

                confirmButtonColor: "#0080ff",

                customClass: {

                    popup: "animalcare-alert",

                    confirmButton: "animalcare-button"

                }

            });

            return;
        }


        /* =================================
           CÓDIGO COMPLETO
        ================================= */

        Swal.fire({

            html: `
                <div class="animalcare-alert-content">

                    <div class="alert-icon">
                        🐾
                    </div>

                    <h2>
                        ¡Email verificado!
                    </h2>

                    <p>
                        Tu correo electrónico fue
                        verificado correctamente.
                    </p>

                    <span>
                        ¡Bienvenido a
                        <strong>AnimalCare</strong>!
                    </span>

                </div>
            `,

            confirmButtonText: "Iniciar Sesión",

            confirmButtonColor: "#0080ff",

            customClass: {

                popup: "animalcare-alert",

                confirmButton: "animalcare-button"

            }

        }).then(function () {

            window.location.href = "iniciar_s.html";

        });

    });


    /* =====================================
       REENVIAR CÓDIGO
    ===================================== */

    if (resend) {

        resend.addEventListener("click", function (event) {

            event.preventDefault();

            Swal.fire({

                html: `
                    <div class="animalcare-alert-content">

                        <div class="alert-icon">
                            📧
                        </div>

                        <h2>
                            ¡Código reenviado!
                        </h2>

                        <p>
                            Hemos enviado un nuevo código
                            de verificación a tu correo.
                        </p>

                        <span>
                            Revisa tu bandeja de entrada.
                        </span>

                    </div>
                `,

                confirmButtonText: "Entendido",

                confirmButtonColor: "#0080ff",

                customClass: {

                    popup: "animalcare-alert",

                    confirmButton: "animalcare-button"

                }

            });

        });

    }

});


/* =====================================
   FUNCIÓN REENVIAR CÓDIGO
===================================== */

function reenviarCodigo(event) {

    event.preventDefault();

    Swal.fire({

        html: `
            <div class="animalcare-alert-content">

                <div class="alert-icon">
                    📧
                </div>

                <h2>
                    ¡Código reenviado!
                </h2>

                <p>
                    Hemos enviado un nuevo código
                    de verificación a tu correo.
                </p>

                <span>
                    Revisa tu bandeja de entrada.
                </span>

            </div>
        `,

        confirmButtonText: "Entendido",

        confirmButtonColor: "#0080ff",

        customClass: {

            popup: "animalcare-alert",

            confirmButton: "animalcare-button"

        }

    });

}