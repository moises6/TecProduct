<?php
session_start();

// Si el usuario ya está autenticado, lo redirigimos al panel principal
if (isset($_SESSION['id_usuario'])) {
    header(header: 'Location: views/products/index.php');
    exit();
} else {
    // Si no está autenticado, lo redirigimos al formulario de inicio de sesión
    header(header: 'Location: views/users/login.php');
    exit();
}
