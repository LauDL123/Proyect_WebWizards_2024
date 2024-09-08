document.addEventListener("DOMContentLoaded", () => {
    const slider = document.querySelector(".slider-frame ul"); // Seleccionamos el UL dentro del slider
    const speed = 4; // Tiempo de cambio en segundos
    let index = 0;
    let timer1;
    let timer2;

    if (!slider) return;

    slider.appendChild(slider.children[0].cloneNode(true)); // Clona el primer hijo

    function show(element) {
        slider.style.transition = "transform 0.5s ease";
        slider.style.transform = `translateX(${-index * slider.parentElement.offsetWidth}px)`; // Desplaza las imágenes
        index = element;
    }

    function next() {
        index++;
        show(index);
        if (index >= slider.children.length - 1) {
            index = 0;
            timer2 = setTimeout(() => {
                slider.style.transition = 'none';
                slider.style.transform = `translateX(${+index * slider.parentElement.offsetWidth}px)`;
            }, 500);
        }
    }

    // Pausar la animación al interactuar
    slider.addEventListener("mouseenter", () => {
        clearInterval(timer1);
        clearInterval(timer2);
    });

    slider.addEventListener("mouseleave", () => {
        timer1 = setInterval(next, speed * 1000);
    });

    // Para dispositivos móviles (touch)
    slider.addEventListener("touchstart", () => {
        clearInterval(timer1);
        clearInterval(timer2);
    });

    slider.addEventListener("touchend", () => {
        timer1 = setInterval(next, speed * 1000);
    });

    timer1 = setInterval(next, speed * 1000);
    show(index);
});
