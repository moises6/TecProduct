<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Producto</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Editar Producto</h2>
                    </div>
                    <div class="card-body">
                        <form action="../../controllers/ProductController.php?action=edit&id=<?php echo $producto['id_producto']; ?>" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" name="nombre" value="<?php echo $producto['nombre_producto']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" required><?php echo $producto['descripcion']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" step="0.01" class="form-control" name="precio" value="<?php echo $producto['precio']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_categoria" class="form-label">Categoría</label>
                                <select class="form-select" name="id_categoria" required>
                                    <option value="1" <?php echo ($producto['id_categoria'] == 1) ? 'selected' : ''; ?>>Electrónica</option>
                                    <option value="2" <?php echo ($producto['id_categoria'] == 2) ? 'selected' : ''; ?>>Ropa</option>
                                    <option value="3" <?php echo ($producto['id_categoria'] == 3) ? 'selected' : ''; ?>>Alimentos</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning">Actualizar Producto</button>
                            <a href="index.php" class="btn btn-secondary">Volver</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>