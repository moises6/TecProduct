<?php
include_once '../config/config.php';




class Product
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function getAllProducts(): array
    {
        $query = "SELECT p.*, c.nombre_categoria FROM productos p LEFT JOIN categorias c ON p.id_categoria = c.id_categoria";
        $stmt = $this->conn->prepare(query: $query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProduct($nombre, $descripcion, $precio, $id_categoria): void
    {
        $query = "INSERT INTO productos (nombre_producto, descripcion, precio, id_categoria) 
                  VALUES (:nombre, :descripcion, :precio, :id_categoria)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre',  $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->execute();
    }

    public function getProductById($id): mixed
    {
        $query = "SELECT * FROM productos WHERE id_producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProduct($id, $nombre, $descripcion, $precio, $id_categoria)
    {
        $query = "UPDATE productos SET nombre_producto = :nombre, descripcion = :descripcion, precio = :precio, id_categoria = :id_categoria WHERE id_producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteProduct($id): void
    {
        $query = "DELETE FROM productos WHERE id_producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
