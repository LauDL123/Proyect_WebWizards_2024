document.addEventListener("DOMContentLoaded", function() {
    const loginContainer = document.getElementById("login-container");

    function checkUserLogin() {
        fetch('get_user_info.php')
            .then(response => response.text())  // Lee la respuesta como texto primero
            .then(text => {
                return JSON.parse(text);  // Analiza el texto como JSON
            })
            .then(data => {
                if (data.loggedIn) {
                    loginContainer.innerHTML = `
                        <div class="user-info" onclick="toggleUserMenu()">
                            <img src="${data.userPhoto}" alt="User Photo">
                            <span>${data.userName}</span>
                        </div>
                        <div class="user-menu" id="user-menu">
                            <a href="personalizar.php">Personalizar</a>
                            <a href="logout.php">Cerrar Sesión</a>
                        </div>
                    `;
                } else {
                    loginContainer.innerHTML = `
                        <i class="fa-solid fa-circle-user" id="iniciar"></i><a href="Login_P.php">Iniciar Sesión</a>
                    `;
                }
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
                loginContainer.innerHTML = `<p>Error: ${error.message}</p>`;
            });
    }

    window.toggleUserMenu = function() {
        const userMenu = document.getElementById("user-menu");
        userMenu.style.display = userMenu.style.display === "block" ? "none" : "block";
    }

    checkUserLogin();
});
