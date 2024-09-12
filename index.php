<?php

declare(strict_types=1);

session_start([
    'cookie_lifetime' => 0,
    'use_strict_mode' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict',
]);

// Función para redirigir de manera segura
function secureRedirect(string $url): void
{
    header('Location: ' . htmlspecialchars($url));
    exit();
}

// Verificar si el usuario está autenticado
if (isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])) {
    // Si el usuario está autenticado, lo redirigimos al panel principal
    secureRedirect('../views/products/index.php');
} else {
    // Si no está autenticado, lo redirigimos al formulario de inicio de sesión
    secureRedirect('../views/users/login.php');
}
