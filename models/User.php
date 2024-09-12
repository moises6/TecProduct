<?php

declare(strict_types=1);

require_once '../config/config.php';

class User
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Obtiene un usuario por nombre de usuario
     *
     * @param string $nombre_usuario Nombre de usuario
     * @return array|null Datos del usuario o null si no se encuentra
     */
    public function getUserByUsername(string $nombre_usuario): ?array
    {
        try {
            $query = "SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':nombre_usuario' => $nombre_usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Error al obtener usuario: " . $e->getMessage());
            return null;
        }
    }
}
