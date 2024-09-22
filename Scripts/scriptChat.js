$(document).ready(function() {
    cargarMensajes();
    setInterval(cargarMensajes, 5000);
});

function enviarMensaje() {
    var contenido = $("#mensaje").val();

    if (contenido.trim() === '') {
        alert('No puedes enviar un mensaje vacío.');
        return;
    }

    $.ajax({
        url: "../Backend/enviarMensaje.php",
        type: "POST",
        data: {
            contenido: contenido,
            id_usuario: id_usuario
        },
        success: function(response) {
            console.log('Mensaje enviado:', response);
            cargarMensajes();
            $("#mensaje").val('');
        },
        error: function(xhr, status, error) {
            console.error('Error al enviar el mensaje:', error);
        }
    });
}

function cargarMensajes() {
    fetch('../Backend/cargarMensajes.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('La respuesta de la red no fue correcta');
        }
        return response.json();
    })
    .then(data => {
        const mensajesContainer = document.getElementById('mensajes');
        mensajesContainer.innerHTML = '';
        data.forEach(mensaje => {
            const mensajeDiv = document.createElement('div');
            const clase = mensaje.id === 1 ? 'admin' : 'user';
            mensajeDiv.classList.add('message', clase);
            mensajeDiv.textContent = `${mensaje.username}: ${mensaje.mensaje} (${new Date(mensaje.timestamp).toLocaleString()})`;
            mensajesContainer.appendChild(mensajeDiv);
        });
        mensajesContainer.scrollTop = mensajesContainer.scrollHeight;
    })
    .catch(error => {
        console.error('Error al cargar los mensajes:', error);
    });
}
