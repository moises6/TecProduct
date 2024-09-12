<?php

declare(strict_types=1);

require_once '../config/config.php';

class Product
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Obtiene todos los productos con sus categorías asociadas
     *
     * @return array Lista de productos con información de categoría
     */
    public function getAllProducts(): array
    {
        try {
            $query = "SELECT p.*, c.nombre_categoria FROM productos p LEFT JOIN categorias c ON p.id_categoria = c.id_categoria";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener productos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Crea un nuevo producto
     *
     * @param string $nombre Nombre del producto
     * @param string $descripcion Descripción del producto
     * @param float $precio Precio del producto
     * @param int $id_categoria ID de la categoría asociada
     * @return void
     */
    public function createProduct(string $nombre, string $descripcion, float $precio, int $id_categoria): void
    {
        try {
            $query = "INSERT INTO productos (nombre_producto, descripcion, precio, id_categoria) VALUES (:nombre, :descripcion, :precio, :id_categoria)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':nombre' => $nombre,
                ':descripcion' => $descripcion,
                ':precio' => $precio,
                ':id_categoria' => $id_categoria
            ]);
        } catch (PDOException $e) {
            error_log("Error al crear producto: " . $e->getMessage());
        }
    }

    /**
     * Obtiene un producto por su ID
     *
     * @param int $id ID del producto
     * @return array|null Datos del producto o null si no se encuentra
     */
    public function getProductById(int $id): ?array
    {
        try {
            $query = "SELECT * FROM productos WHERE id_producto = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Error al obtener producto por ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Actualiza un producto existente
     *
     * @param int $id ID del producto
     * @param string $nombre Nombre del producto
     * @param string $descripcion Descripción del producto
     * @param float $precio Precio del producto
     * @param int $id_categoria ID de la categoría asociada
     * @return void
     */
    public function updateProduct(int $id, string $nombre, string $descripcion, float $precio, int $id_categoria): void
    {
        try {
            $query = "UPDATE productos SET nombre_producto = :nombre, descripcion = :descripcion, precio = :precio, id_categoria = :id_categoria WHERE id_producto = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':nombre' => $nombre,
                ':descripcion' => $descripcion,
                ':precio' => $precio,
                ':id_categoria' => $id_categoria,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error al actualizar producto: " . $e->getMessage());
        }
    }

    /**
     * Elimina un producto por su ID
     *
     * @param int $id ID del producto
     * @return void
     */
    public function deleteProduct(int $id): void
    {
        try {
            $query = "DELETE FROM productos WHERE id_producto = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
        }
    }
}
