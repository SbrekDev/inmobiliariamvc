document.addEventListener("DOMContentLoaded", function(){

    eventListeners()

    darkMode();

});


function darkMode(){

    const prefiereDarkMode = window.matchMedia("(prefers-color-scheme: dark)");

    if(prefiereDarkMode.matches){
        document.body.classList.add("dark-mode");
    } else {
        document.body.classList.remove("dark-mode");
    }

    prefiereDarkMode.addEventListener("change", function(){
        if(prefiereDarkMode.matches){
            document.body.classList.add("dark-mode");
        } else {
            document.body.classList.remove("dark-mode");
        }
    });

    const botonDarkMode = document.querySelector(".dark-mode-boton")

    botonDarkMode.addEventListener("click", function(){
        document.body.classList.toggle("dark-mode")
    });
}


function eventListeners() {
    const mobileMenu = document.querySelector(".mobile-menu");

    mobileMenu.addEventListener("click", navegacionResponsive)

    // muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]')

    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto))
};


function navegacionResponsive(){
    const navegacion = document.querySelector(".navegacion");

    if(navegacion.classList.contains("mostrar")) { // toggle hace todo de una - navegacion.classList.toggle("mostrar")
        navegacion.classList.remove("mostrar")
    } else {
        navegacion.classList.add("mostrar")
    }
}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');

    if(e.target.value === 'telefono'){
        contactoDiv.innerHTML = `
                <label for="telefono">Numero de telefono</label>
                <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]">

                <p>Eliga la fecha y la hora para ser contactado</p>

                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="contacto[fecha]">

                <label for="hora" >Hora:</label>
                <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
    } else {
        contactoDiv.innerHTML = `
        
                <label for="email">Correo</label>
                <input type="email" placeholder="Tu Correo" id="email" name="contacto[email]" required>
        `;
    }
}