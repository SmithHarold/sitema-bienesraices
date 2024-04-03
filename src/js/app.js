// mostrar y ocultar un menu de hamburguesa
document.addEventListener('DOMContentLoaded', function() {
    eventListeners();

    darkMode();
});

function darkMode() {
    // inicio codigo para que de acuerdo a la configuracion del sistema se ponga en oscuro o claro
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    
    }) //fin codigo de acuerdo a la conf del sistema del usuario

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    })
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);

    // muestra capos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');

    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));

}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');
//  hay dos formas de hacerlo con un if y con un toggle
    // if(navegacion.classList.contains('mostrar')){
    //     navegacion.classList.remove('mostrar');

    // } else {
    //     navegacion.classList.add('mostrar')
    // }

    navegacion.classList.toggle('mostrar')


}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');

    if(e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
        
            <label for="telefono">Número Telefónico</label>
            <input type="tel" placeholder="Tu telefono" id="telefono" name="contacto[telefono]">

            <p>Elija la fecha y la hora para la llamada</p>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">


        `;
    } else {
        contactoDiv.innerHTML = `
        
            <label for="email">E-mail</label>
            <input type="email" placeholder="Tu email" id="email" name="contacto[email]">
        `;
    }
    

}