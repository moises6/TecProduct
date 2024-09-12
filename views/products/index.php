<?php
// Verificar si el usuario ha iniciado sesión
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../users/login.php');
    exit;
}

// Configuración de errores para desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión segura a la base de datos
$dsn = 'mysql:host=localhost;dbproduct';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error al conectar con la base de datos: ' . $e->getMessage();
    exit;
}

// Función para obtener todos los productos
function getAllProducts($pdo)
{
    $stmt = $pdo->prepare("SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio, c.nombre_categoria 
                           FROM productos p 
                           JOIN categorias c ON p.id_categoria = c.id_categoria");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener todos los productos
$productos = getAllProducts($pdo);

// Cerrar la conexión
$pdo = null;
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
                            <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre_categoria']); ?></td>
                            <td>
                                <a href="edit.php?id_producto=<?php echo htmlspecialchars($producto['id_producto']); ?>" class="btn btn-warning btn-sm">Editar</a>
                                <form action="../../controllers/ProductController.php?action=delete" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($producto['id_producto']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
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