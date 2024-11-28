<?php
session_start();

// Verificar si el usuario está logueado y si es el admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: index.html");  // Redirigir si no está logueado o no es admin
    exit;
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "tienda");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener todos los productos
$productos_sql = "SELECT * FROM productos";
$productos_result = $conn->query($productos_sql);

// Consulta para obtener todos los pedidos
$pedidos_sql = "SELECT * FROM pedidos";
$pedidos_result = $conn->query($pedidos_sql);

// Consulta para obtener todos los usuarios
$usuarios_sql = "SELECT * FROM usuarios";
$usuarios_result = $conn->query($usuarios_sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de Administrador</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <h1>Bienvenido al Área de Administrador</h1>
    </header>

    <section>
        <h2>Gestión de Productos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = $productos_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $producto['id']; ?></td>
                    <td><?php echo $producto['producto_nombre']; ?></td>
                    <td><?php echo $producto['producto_precio']; ?></td>
                    <td>
                        <a href="eliminar_producto2.php?id=<?php echo $producto['id']; ?>">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Añadir un Producto</h3>
        <form action="añadir_producto.php" method="REQUEST">

            <label for="nombre">Nombre del Producto:</label>
            <input type="text" name="producto_nombre" required><br>
            <label for="precio">Precio:</label>
            <input type="number" name="producto_precio" required><br>
            <input type="submit" value="Añadir Producto">
        </form>

        <h2>Gestión de Pedidos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = $pedidos_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $pedido['id']; ?></td>
                    <td><?php echo $pedido['estado']; ?></td>
                    <td>
                        <a href="modificar_estado_pedido.php?id=<?php echo $pedido['id']; ?>">Modificar Estado</a> | 
                        <a href="eliminar_pedido.php?id=<?php echo $pedido['id']; ?>">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Gestión de Usuarios</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>Nombre de Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $usuarios_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['username']; ?></td>
                    <td>
                        <a href="eliminar_usuario.php?id=<?php echo $usuario['id']; ?>">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
    
    <footer>
        <p>&copy; 2024 Tu Tienda</p>
    </footer>
</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>
