document.addEventListener("DOMContentLoaded", function () {

    

    /* =================================
       VER DETALLES
    ================================= */

    document.querySelectorAll(".btn-action.primary")
        .forEach(function (boton) {

            boton.addEventListener("click", function (event) {

                event.preventDefault();

                Swal.fire({
                    html: `
                        <div class="animalcare-alert-content">

                            <div class="alert-icon"></div>

                            <h2>Detalles de la cita</h2>

                            <p>
                                Aquí podrás consultar toda
                                la información de tu cita.
                            </p>

                            <span>
                                Fecha, hora, veterinario y clínica.
                            </span>

                        </div>
                    `,

                    confirmButtonText: "Cerrar",
                    confirmButtonColor: "#0080ff",

                    customClass: {
                        popup: "animalcare-alert",
                        confirmButton: "animalcare-button"
                    }
                });

            });

        });


    /* =================================
       REAGENDAR
    ================================= */

    document.querySelectorAll(".btn-action.secondary")
        .forEach(function (boton) {

            boton.addEventListener("click", function (event) {

                event.preventDefault();

                Swal.fire({
                    html: `
                        <div class="animalcare-alert-content">

                            <div class="alert-icon">🗓️</div>

                            <h2>Reagendar cita</h2>

                            <p>
                                Puedes cambiar la fecha y hora
                                de tu cita.
                            </p>

                            <span>
                                La función de reagendamiento estará
                                disponible próximamente.
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

        });


    /* =================================
       VER PERFIL DEL VETERINARIO
    ================================= */

    document.querySelectorAll(".profile-link")
        .forEach(function (boton) {

            boton.addEventListener("click", function (event) {

                event.preventDefault();

                const veterinario =
                    this.parentElement.querySelector("h4").textContent;

                const especialidad =
                    this.parentElement.querySelector(".specialty").textContent;

                Swal.fire({
                    html: `
                        <div class="animalcare-alert-content">

                            <div class="alert-icon"></div>

                            <h2>${veterinario}</h2>

                            <p>
                                Especialidad:
                                <strong>${especialidad}</strong>
                            </p>

                            <span>
                                Información del perfil del veterinario.
                            </span>

                        </div>
                    `,

                    confirmButtonText: "Cerrar",
                    confirmButtonColor: "#0080ff",

                    customClass: {
                        popup: "animalcare-alert",
                        confirmButton: "animalcare-button"
                    }
                });

            });

        });


    /* =================================
       VER RESUMEN
    ================================= */

    document.querySelectorAll(".summary-link")
        .forEach(function (boton) {

            boton.addEventListener("click", function (event) {

                event.preventDefault();

                Swal.fire({
                    html: `
                        <div class="animalcare-alert-content">

                            <div class="alert-icon">🐾</div>

                            <h2>Resumen de la cita</h2>

                            <p>
                                Aquí podrás consultar el resumen
                                de la atención veterinaria.
                            </p>

                            <span>
                                Diagnóstico, recomendaciones y tratamiento.
                            </span>

                        </div>
                    `,

                    confirmButtonText: "Cerrar",
                    confirmButtonColor: "#0080ff",

                    customClass: {
                        popup: "animalcare-alert",
                        confirmButton: "animalcare-button"
                    }
                });

            });

        });

});
function cerrarSesion(event) {

    event.preventDefault();

    Swal.fire({
        title: '🐾 ¿Quieres salir?',
        text: '¿Estás seguro de que quieres cerrar tu sesión?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, salir',
        cancelButtonText: 'Quedarme',
        confirmButtonColor: '#0080ff',
        cancelButtonColor: '#e0e0e0',
        customClass: {
            popup: 'animalcare-alert',
            title: 'animalcare-title',
            cancelButton: 'animalcare-cancel'
        }
    }).then((resultado) => {

        if (resultado.isConfirmed) {

            Swal.fire({
                html: `
                    <div class="despedida-animalcare">
                        <div class="huella">🐾</div>
                        <h2>¡Hasta pronto!</h2>
                        <p>Gracias por confiar en <strong>AnimalCare</strong>.</p>
                        <span>Tu mascota te espera !</span>
                    </div>
                `,
                showConfirmButton: false,
                timer: 2200,
                timerProgressBar: true,
                customClass: {
                    popup: 'animalcare-despedida'
                }
            }).then(() => {

                window.location.href = 'index.html';

            });

        }

    });
}
