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
$(document).ready(function () {
    if (es_admin) {
        cargarClientes();
    }

    // Cargar clientes activos si el usuario es administrador
    function cargarClientes() {
        $.ajax({
            url: 'Backend/obtenerClientes.php',
            method: 'GET',
            success: function (data) {
                const clientes = JSON.parse(data);
                const clientesLista = $('#clientes-activos');
                clientesLista.empty();

                clientes.forEach(cliente => {
                    clientesLista.append(
                        `<li onclick="cargarMensajesCliente(${cliente.id})">${cliente.nombre}</li>`
                    );
                });
            }
        });
    }

    // Cargar mensajes del cliente seleccionado
    window.cargarMensajesCliente = function (clienteId) {
        $.ajax({
            url: 'Backend/obtenerMensajes.php',
            method: 'POST',
            data: { clienteId: clienteId },
            success: function (data) {
                const mensajes = JSON.parse(data);
                $('#mensajes').empty();

                mensajes.forEach(mensaje => {
                    $('#mensajes').append(`<p>${mensaje.texto}</p>`);
                });
            }
        });
    };
});