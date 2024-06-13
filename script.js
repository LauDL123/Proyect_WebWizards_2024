function mostrarFormulario() {
    var formulario = document.getElementById("mensaje_formulario");
    formulario.style.display = "block";
}
 // Main carousel
 $(".carousel .owl-carousel").owlCarousel({
    autoplay: true,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    items: 1,
    smartSpeed: 300,
    dots: false,
    loop: true,
    nav : false
});
