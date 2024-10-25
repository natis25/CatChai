// Selecciona todas las secciones
const sections = document.querySelectorAll('section');

// Añade un evento de desplazamiento (scroll)
window.addEventListener('scroll', () => {
    const scrollPos = window.scrollY + window.innerHeight * 0.75;

    // Activa la animación cuando la sección entra en el viewport
    sections.forEach(section => {
        if (scrollPos > section.offsetTop) {
            section.classList.add('active');
        }
    });
});

document.getElementById('scrollToTop').addEventListener('click', function(e) {
    e.preventDefault(); // Evita el comportamiento predeterminado del enlace
    window.scrollTo({
        top: 0, // Desplazarse a la parte superior de la página
        behavior: 'smooth' // Desplazamiento suave
    });
});