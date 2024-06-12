document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("electrodomesticoForm");
    const nombreInput = document.getElementById("nombre");
    const pesoInput = document.getElementById("peso");
    const nombreError = document.getElementById("nombreError");
    const pesoError = document.getElementById("pesoError");

    form.addEventListener("submit", function(event) {
        let valid = true;

        // Validar que el nombre solo contenga letras
        const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        if (!nombreRegex.test(nombreInput.value)) {
            nombreError.classList.remove("hidden");
            valid = false;
        } else {
            nombreError.classList.add("hidden");
        }

        // Validar que el peso solo contenga números
        if (isNaN(pesoInput.value) || pesoInput.value <= 0) {
            pesoError.classList.remove("hidden");
            valid = false;
        } else {
            pesoError.classList.add("hidden");
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    // Opcional: Validar en tiempo real mientras el usuario escribe
    nombreInput.addEventListener("input", function() {
        if (!nombreRegex.test(nombreInput.value)) {
            nombreError.classList.remove("hidden");
        } else {
            nombreError.classList.add("hidden");
        }
    });

    pesoInput.addEventListener("input", function() {
        if (isNaN(pesoInput.value) || pesoInput.value <= 0) {
            pesoError.classList.remove("hidden");
        } else {
            pesoError.classList.add("hidden");
        }
    });
});
