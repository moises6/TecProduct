<?php
include_once '../models/Product.php';

class ProductController
{
    public function index(): void
    {
        $productModel = new Product();
        $productos = $productModel->getAllProducts();
        include '../views/products/index.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $id_categoria = $_POST['id_categoria'];

            $productModel = new Product();
            $productModel->createProduct(nombre: $nombre, descripcion: $descripcion, precio: $precio, id_categoria: $id_categoria);

            header(header: 'Location: ../views/products/index.php');
        } else {
            include '../views/products/create.php';
        }
    }

    public function edit($id): void
    {
        $productModel = new Product();
        $producto = $productModel->getProductById(id: $id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $id_categoria = $_POST['id_categoria'];

            $productModel->updateProduct(id: $id, nombre: $nombre, descripcion: $descripcion, precio: $precio, id_categoria: $id_categoria);
            header('Location: ../views/products/index.php');
        } else {
            include '../views/products/edit.php';
        }
    }

    public function delete($id): void
    {
        $productModel = new Product();
        $productModel->deleteProduct(id: $id);
        header(header: 'Location: ../views/products/index.php');
    }
}
