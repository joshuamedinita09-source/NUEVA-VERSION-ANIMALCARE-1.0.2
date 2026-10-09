document.addEventListener("DOMContentLoaded", function () {

    const monthTitle = document.querySelector(".month-navigation h2");
    const daysGrid = document.querySelector(".days-grid");
    const buttons = document.querySelectorAll(".nav-arrow");

    let fechaActual = new Date();

    const meses = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    function crearCalendario() {

        const año = fechaActual.getFullYear();
        const mes = fechaActual.getMonth();

        monthTitle.textContent = meses[mes];

        daysGrid.innerHTML = "";

        // Primer día del mes
        const primerDia = new Date(año, mes, 1).getDay();

        // Cantidad de días del mes
        const cantidadDias = new Date(año, mes + 1, 0).getDate();

        // Espacios antes del día 1
        for (let i = 0; i < primerDia; i++) {
            const espacio = document.createElement("div");
            espacio.classList.add("day-cell", "empty");
            daysGrid.appendChild(espacio);
        }

        // Crear días
        for (let dia = 1; dia <= cantidadDias; dia++) {

            const celda = document.createElement("div");
            celda.classList.add("day-cell");

            const numero = document.createElement("span");
            numero.textContent = dia;
            celda.appendChild(numero);

            // Formatear el día actual del bucle en formato YYYY-MM-DD
            const mesFormat = String(mes + 1).padStart(2, '0');
            const diaFormat = String(dia).padStart(2, '0');
            const fechaCeldaStr = `${año}-${mesFormat}-${diaFormat}`;

            // Verificar si hay citas en esta fecha usando la variable global 'citasUsuario'
            if (typeof citasUsuario !== 'undefined' && Array.isArray(citasUsuario)) {
                citasUsuario.forEach(cita => {
                    const fechaCitaSoloDia = cita.fecha_hora.split(' ')[0];

                    if (fechaCitaSoloDia === fechaCeldaStr) {
                        celda.classList.add("tiene-cita");
                        const indicador = document.createElement("div");
                        indicador.classList.add("cita-indicador");
                        indicador.style.fontSize = "10px";
                        indicador.style.background = "#0080ff";
                        indicador.style.color = "white";
                        indicador.style.padding = "2px 6px";
                        indicador.style.borderRadius = "10px";
                        indicador.style.marginTop = "4px";
                        indicador.style.width = "100%";         // <--- ¡Asegura el ancho del contenedor!
                        indicador.style.maxWidth = "100%";
                        indicador.style.overflow = "hidden";
                        indicador.style.textOverflow = "ellipsis";
                        indicador.style.whiteSpace = "nowrap";
                        indicador.style.boxSizing = "border-box";
                        indicador.textContent = `${cita.nombre_m}: ${cita.motivo}`;
                        
                        celda.appendChild(indicador);
                    }

                });
            }

            // Marcar el día actual del sistema
            const hoy = new Date();
            if (
                dia === hoy.getDate() &&
                mes === hoy.getMonth() &&
                año === hoy.getFullYear()
            ) {
                celda.classList.add("hoy");
            }

            // Seleccionar / quitar selección
            celda.addEventListener("click", function () {
                if (celda.classList.contains("seleccionado")) {
                    celda.classList.remove("seleccionado");
                    return;
                }

                document.querySelectorAll(".day-cell.seleccionado")
                    .forEach(function (elemento) {
                        elemento.classList.remove("seleccionado");
                    });

                celda.classList.add("seleccionado");
            });

            daysGrid.appendChild(celda);
        }
    }

    // Botón anterior
    buttons[0].addEventListener("click", function () {
        fechaActual.setMonth(fechaActual.getMonth() - 1);
        crearCalendario();
    });

    // Botón siguiente
    buttons[1].addEventListener("click", function () {
        fechaActual.setMonth(fechaActual.getMonth() + 1);
        crearCalendario();
    });

    // Cargar calendario
    crearCalendario();

});