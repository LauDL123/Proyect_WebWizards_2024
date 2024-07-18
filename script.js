document.addEventListener("DOMContentLoaded", function() {
    const loginContainer = document.getElementById("login-container");

    // Función para verificar si el usuario está logueado
    function checkUserLogin() {
        fetch('get_user_info.php')
            .then(response => response.json())
            .then(data => {
                if (data.loggedIn) {
                    loginContainer.innerHTML = `
                        <div class="user-info" onclick="toggleUserMenu()">
                            <img src="${data.userPhoto}" alt="User Photo">
                            <span>${data.userName}</span>
                        </div>
                        <div class="user-menu" id="user-menu">
                            <a href="personalizar.html">Personalizar</a>
                            <a href="logout.php">Cerrar Sesión</a>
                        </div>
                    `;
                } else {
                    loginContainer.innerHTML = `
                        <i class="fa-solid fa-circle-user" id="iniciar"></i><a href="login.html">Iniciar Sesión</a>
                    `;
                }
            });
    }

    // Función para mostrar/ocultar el menú del usuario
    window.toggleUserMenu = function() {
        const userMenu = document.getElementById("user-menu");
        userMenu.style.display = userMenu.style.display === "block" ? "none" : "block";
    }


    // Llama a la función para verificar si el usuario está logueado
    checkUserLogin();
});



function mostrarFormulario() {
    var formulario = document.getElementById("mensaje_formulario");
    formulario.style.display = "block";
}
