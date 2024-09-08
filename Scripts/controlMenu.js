//función para mostrar u ocultar el menú del usuario
function toggleUserMenu() {
    const userMenu = document.getElementById('userMenu');
    userMenu.classList.toggle('show');
}

//cerrar el menú si se hace clic fuera de él
document.addEventListener('click', function(event) {
    const userMenu = document.getElementById('userMenu');
    const userInfo = document.querySelector('.user-info');
    if (!userInfo.contains(event.target)) {
        userMenu.classList.remove('show');
    }
});
