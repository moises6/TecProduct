<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'dbproduct';
$username = 'root';
$password = '';

// Intentar establecer la conexión
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Loggear el error en un archivo
    error_log("Error de conexión: " . $e->getMessage(), 0);

    // Mostrar un mensaje genérico al usuario
    echo "Lo sentimos, ha ocurrido un error al conectar con la base de datos.";

    // Terminar la ejecución del script
    exit();
}

// Función para cerrar la conexión cuando se termine de usar
function closeConnection()
{
    global $conn;
    if ($conn) {
        $conn = null;
    }
}

// Registrar la función de cierre como callback cuando el script termine
register_shutdown_function('closeConnection');
