function cerrarSesion(event) {

    event.preventDefault();

    Swal.fire({
        title: '🐾 ¿Quieres salir?',
        text: '¿Estás seguro de que quieres cerrar tu sesion?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si, salir',
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
                        <span>Tu mascota te espera 🐶🐱</span>
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