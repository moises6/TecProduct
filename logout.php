<?php
// Iniciar la sesión
session_start();

// Destruir todas las sesiones
session_destroy();

// Redirigir al usuario al formulario de inicio de sesión
header(header: 'Location: views/users/login.php');
exit();
