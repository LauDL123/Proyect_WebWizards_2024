$(document).ready(function() {
    // Cargar mensajes al iniciar
    cargarMensajes();
    // Cargar mensajes cada 5 segundos
    setInterval(cargarMensajes, 5000);
});

function enviarMensaje() {
    var contenido = $("#mensaje").val();

    $.ajax({
        url: "../Backend/insertarMensaje.php",
        type: "POST",
        data: {
            contenido: contenido
        },
        success: function(response) {
            console.log(response); 
            cargarMensajes(); // Actualiza los mensajes después de enviar
            $("#mensaje").val(''); // Limpia el campo de texto
        }
    });
}

function cargarMensajes() {
    $.ajax({
        url: "../Backend/getMensajes.php",
        type: "GET",
        success: function(data) {
            $("#mensajes").html(data);
        }
    });
}
