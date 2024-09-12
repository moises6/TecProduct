<?php

declare(strict_types=1);

require_once '../models/Product.php';

class ProductController
{
    private Product $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    /**
     * Muestra la lista de productos
     */
    public function index(): void
    {
        try {
            $productos = $this->productModel->getAllProducts();
            $this->renderView('products/index', ['productos' => $productos]);
        } catch (Exception $e) {
            error_log("Error en el índice de productos: " . $e->getMessage());
            $this->renderView('error', ['message' => 'Error al cargar los productos']);
        }
    }

    /**
     * Crea un nuevo producto
     */
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
                $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
                $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
                $id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);

                if ($nombre && $descripcion && $precio !== false && $id_categoria !== false) {
                    $this->productModel->createProduct($nombre, $descripcion, $precio, $id_categoria);
                    header('Location: ../views/products/index.php');
                    exit();
                } else {
                    throw new Exception('Datos inválidos');
                }
            } catch (Exception $e) {
                error_log("Error al crear producto: " . $e->getMessage());
                $this->renderView('products/create', ['error' => 'Error al crear el producto']);
            }
        } else {
            $this->renderView('products/create');
        }
    }

    /**
     * Edita un producto existente
     *
     * @param int $id ID del producto
     */
    public function edit(int $id): void
    {
        try {
            $producto = $this->productModel->getProductById($id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
                $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
                $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
                $id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);

                if ($nombre && $descripcion && $precio !== false && $id_categoria !== false) {
                    $this->productModel->updateProduct($id, $nombre, $descripcion, $precio, $id_categoria);
                    header('Location: ../views/products/index.php');
                    exit();
                } else {
                    throw new Exception('Datos inválidos');
                }
            }

            $this->renderView('products/edit', ['producto' => $producto]);
        } catch (Exception $e) {
            error_log("Error al editar producto: " . $e->getMessage());
            $this->renderView('error', ['message' => 'Error al editar el producto']);
        }
    }

    /**
     * Elimina un producto por su ID
     *
     * @param int $id ID del producto
     */
    public function delete(int $id): void
    {
        try {
            $this->productModel->deleteProduct($id);
            header('Location: ../views/products/index.php');
            exit();
        } catch (Exception $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            $this->renderView('error', ['message' => 'Error al eliminar el producto']);
        }
    }

    /**
     * Renderiza una vista con los datos proporcionados
     *
     * @param string $view Nombre de la vista
     * @param array $data Datos para pasar a la vista
     */
    private function renderView(string $view, array $data = []): void
    {
        extract($data);
        require_once "../views/products/{$view}.php";
    }
}
