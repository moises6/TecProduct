<?php
// Verificar si el usuario ha iniciado sesión
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header(header: 'Location: ../users/login.php');
    exit;
}

ini_set(option: 'display_errors', value: 1);
ini_set(option: 'display_startup_errors', value: 1);
error_reporting(error_level: E_ALL);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Lista de Productos</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Lista de Productos</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="create.php" class="btn btn-success">Agregar nuevo producto</a>
            <a href="../../controllers/UserController.php?action=logout" class="btn btn-danger">Cerrar Sesión</a>
        </div>

        <?php if (!empty($productos)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo $producto['nombre_producto']; ?></td>
                            <td><?php echo $producto['descripcion']; ?></td>
                            <td><?php echo $producto['precio']; ?></td>
                            <td><?php echo $producto['nombre_categoria']; ?></td>
                            <td>
                                <a href="edit.php?id_producto=<?php echo $producto['id_producto']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="../../controllers/ProductController.php?action=delete&id=<?php echo $producto['id_producto']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No hay productos disponibles.</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>