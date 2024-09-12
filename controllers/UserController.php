<?php
include_once '../models/User.php';

// Activar la visualización de errores
ini_set(option: 'display_errors', value: 1);
ini_set(option: 'display_startup_errors', value: 1);
error_reporting(error_level: E_ALL);

class UserController
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre_usuario = $_POST['nombre_usuario'];
            $contraseña = $_POST['contraseña'];

            // Mensajes de depuración (para asegurar que el código está corriendo)
            echo "Datos recibidos del formulario: Nombre de usuario = $nombre_usuario, Contraseña = $contraseña <br>";

            // Crear instancia del modelo User
            $userModel = new User();

            // Obtener el usuario por nombre de usuario
            $usuario = $userModel->getUserByUsername(nombre_usuario: $nombre_usuario);

            // Verificar si se encontró el usuario y si la contraseña es válida
            if ($usuario && password_verify(password: $contraseña, hash: $usuario['contraseña'])) {
                // Iniciar la sesión
                session_start();
                $_SESSION['id_usuario'] = $usuario['id_usuario'];

                // Mensaje de éxito para depuración
                echo "Sesión iniciada correctamente. Redirigiendo...<br>";

                // Asegurar la redirección con una ruta absoluta
                header(header: 'Location: http://localhost:8080/DWSL-Parcial1/TecProduct/views/products/index.php');
                exit(); // Asegurar que el script termina aquí
            } else {
                // Mostrar mensaje de error si la autenticación falla
                echo "Usuario o contraseña incorrectos.";
            }
        }
    }

    public function logout(): void
    {
        // Iniciar la sesión si no está iniciada
        session_start();

        // Destruir la sesión actual
        session_destroy();

        // Redirigir al formulario de inicio de sesión
        header(header: 'Location: http://localhost:8080/DWSL-Parcial1/TecProduct/views/users/login.php');
        exit(); // Terminar el script después de la redirección
    }
}
