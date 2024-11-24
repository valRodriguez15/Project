
    // Verificamos si el usuario está logueado
if (sessionStorage.getItem('loggedIn') !== 'true') {  // Comparamos con 'true' como string
    alert('Debe iniciar sesión primero');
    window.location.href = '../index.html';  // Redirigir al login si no está logueado
} else {
    // Si el usuario está logueado, obtenemos el rol
    let role = sessionStorage.getItem('role');
    console.log('Rol del usuario:', role);  // Para debug

    // Mostramos contenido dependiendo del rol
    if (role === 'admin') {
        document.getElementById('adminContent').style.display = 'block'; // Vista para administradores
    } else if (role === 'user') {
        document.getElementById('userContent').style.display = 'block'; // Vista para usuarios
    } else {
        alert('Error en la identificación del rol del usuario');
        window.location.href = '../index.html'; // Redirigir si hay error en el rol
    }
}

// Lógica para cerrar sesión
document.getElementById('logoutBtn').addEventListener('click', function() {
    sessionStorage.removeItem('loggedIn');
    sessionStorage.removeItem('role');
    window.location.href = '../index.html';  // Asegúrate que este sea el nombre correcto del archivo de login
});

// Lógica para mostrar el formulario de pedido
document.getElementById('makeOrderBtn').addEventListener('click', function() {
    document.getElementById('orderForm').style.display = 'block'; // Mostrar formulario de pedido
});

// Lógica para cancelar el pedido
document.getElementById('cancelOrderBtn').addEventListener('click', function() {
    document.getElementById('orderForm').style.display = 'none'; // Ocultar formulario de pedido
});

// Manejo del envío del formulario
document.getElementById('orderForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Evitar el envío del formulario por defecto

    // Captura de datos del formulario
    const fullName = document.getElementById('fullName').value;
    const address = document.getElementById('address').value;
    const product = document.getElementById('product').value;
    const quantity = document.getElementById('quantity').value;
    const city = document.getElementById('city').value;
    const date = document.getElementById('date').value;

    // Mostrar una alerta con los datos del pedido
    alert(`Pedido realizado:\nNombre: ${fullName}\nDirección: ${address}\nProducto: ${product}\nCantidad: ${quantity}\nCiudad: ${city}\nFecha: ${date}`);
    
    // Limpiar el formulario
    document.getElementById('orderForm').reset();
    document.getElementById('orderForm').style.display = 'none'; // Ocultar formulario después de enviar
});
