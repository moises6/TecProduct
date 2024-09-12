<?php

declare(strict_types=1);

require_once '../models/User.php';
require_once '../config/config.php';

class UserController
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Método para iniciar sesión
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToLogin();
        }

        $username = filter_input(INPUT_POST, 'nombre_usuario', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'contraseña', FILTER_SANITIZE_STRING);

        error_log("Intento de inicio de sesión: Usuario = {$username}");

        $user = $this->userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user['contraseña'])) {
            $this->startSecureSession($user);
            $this->redirectToDashboard();
        } else {
            error_log("Inicio de sesión fallido");
            $this->redirectToLogin();
        }
    }

    /**
     * Método para cerrar sesión
     */
    public function logout(): void
    {
        $this->destroySession();
        $this->redirectToLogin();
    }

    /**
     * Inicia una sesión segura
     */
    private function startSecureSession(array $user): void
    {
        session_start([
            'cookie_lifetime' => 0,
            'use_strict_mode' => true,
            'cookie_secure' => true,
            'cookie_httponly' => true,
            'cookie_samesite' => 'Strict',
        ]);

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['username'] = $user['nombre_usuario'];

        error_log("Sesión iniciada correctamente para el usuario {$user['nombre_usuario']}");
    }

    /**
     * Destruye la sesión actual
     */
    private function destroySession(): void
    {
        session_start();
        session_unset();
        session_destroy();

        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

        error_log("Sesión destruida");
    }

    /**
     * Redirige al usuario a la página de login
     */
    private function redirectToLogin(): void
    {
        header('Location: http://localhost:8080/DWSL-Parcial1/TecProduct/views/users/login.php');
        exit();
    }

    /**
     * Redirige al usuario al dashboard
     */
    private function redirectToDashboard(): void
    {
        header('Location: http://localhost:8080/DWSL-Parcial1/TecProduct/views/products/index.php');
        exit();
    }
}
