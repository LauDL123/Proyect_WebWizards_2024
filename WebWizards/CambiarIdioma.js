var Boton = document.getElementById('CambiarIdioma');
var TextoATraducir1 = document.getElementById('info');
var TextoATraducir2 = document.getElementById('info2');
var TextoATraducir3 = document.getElementById('info3');

var EsEspañol = true;

Boton.addEventListener("click", () => {
    
    if(EsEspañol == true) {

        TextoATraducir1.textContent = 'We are a young software development company with a view to offering high quality products and services to companies and individuals.';
        TextoATraducir2.textContent = 'Our mission is to empower businesses and individuals to thrive in the digital age through innovative and technologically advanced web solutions.';
        TextoATraducir3.textContent = 'Your satisfaction is our biggest achievement.';
        Boton.textContent = 'Español';

        EsEspañol = false;

    } else {

        TextoATraducir1.textContent = 'Somos una joven empresa de desarrollo de software con vista en ofrecer productos y servicios de alta calidad a empresas y particulares.';
        TextoATraducir2.textContent = 'Nuestra misión es la de empoderar a empresas e individuos a prosperar en la era digital mediante soluciones web innovadoras y tecnológicamente avanzadas.';
        TextoATraducir3.textContent = 'Su satisfacción es nuestro mayor logro.';
        Boton.textContent = 'English';

        EsEspañol = true;

    }

})