<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "tienda");

$user_id = $_SESSION['user_id'];

// Obtener los productos del carrito del usuario
$sql = "SELECT * FROM carrito WHERE user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Carrito de Compras</h1>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['producto_id']; ?></td>
                    <td><?php echo $row['producto_nombre']; ?></td>
                    <td><?php echo $row['producto_precio']; ?></td>
                    <td><?php echo $row['cantidad']; ?></td>
                    <td><?php echo $row['producto_precio'] * $row['cantidad']; ?></td>
                    <td>
                        <a href="eliminar_producto.php?producto_id=<?php echo $row['producto_id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <a href="vaciar_carrito.php">Vaciar Carrito</a>
        <br><br>
        <a href="realizar_pedido.php">Finalizar Compra</a>
    <?php else: ?>
        <p>El carrito está vacío.</p>
        <a href="area_personal.php">Seguir Comprando</a>
    <?php endif; ?>

    <br>
    <a href="index.html">Cerrar Sesión</a>
</body>
</html>
