document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;

    // Validación de credenciales
    if (username === 'admin' && password === 'admin123') {
        sessionStorage.setItem('loggedIn', true);
        sessionStorage.setItem('role', 'admin');
        window.location.href = './modulos/modulos.html';  // Redirigir al módulo de productos
    } else if (username === 'usuario' && password === 'usuario123') {
        sessionStorage.setItem('loggedIn', true);
        sessionStorage.setItem('role', 'user');
        window.location.href = './pedidos/indexPedidos.php';  // Redirigir al módulo de productos
    } else {
        alert('Credenciales incorrectas');
    }
});


document.getElementById('showRegister').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('registerForm').style.display = 'block';
});

document.getElementById('showLogin').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('registerForm').style.display = 'none';
    document.getElementById('loginForm').style.display = 'block';
});

document.addEventListener("DOMContentLoaded", function() {
    const togglePassword = document.getElementById("togglePassword");
    const toggleNewPassword = document.getElementById("toggleNewPassword");
    
    togglePassword.addEventListener("click", function() {
        const passwordInput = document.getElementById("password");
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        this.textContent = type === "password" ? "👁️" : "🙈"; // Cambiar ícono
    });

    toggleNewPassword.addEventListener("click", function() {
        const newPasswordInput = document.getElementById("newPassword");
        const type = newPasswordInput.getAttribute("type") === "password" ? "text" : "password";
        newPasswordInput.setAttribute("type", type);
        this.textContent = type === "password" ? "👁️" : "🙈"; // Cambiar ícono
    });
});
