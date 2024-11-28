<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html"); // Redirigir al login si no está logueado
    exit;
}

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "tienda");

// Obtener el ID del usuario logueado
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];  // Nombre de usuario


// Verificar si el usuario es admin (se hace por nombre de usuario)
$is_admin = ($username === 'admin');

// Si es admin, se obtienen todos los pedidos
if ($is_admin) {
    $sql_pedidos = "SELECT p.id, p.total, p.estado, p.fecha, u.username 
                    FROM pedidos p
                    JOIN usuarios u ON p.user_id = u.id";
} else {
    // Si es un usuario normal, solo se muestran sus propios pedidos
    $sql_pedidos = "SELECT p.id, p.total, p.estado, p.fecha 
                    FROM pedidos p
                    WHERE p.user_id = $user_id";
}

$result_pedidos = $conn->query($sql_pedidos);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos</title>
</head>
<body>

    <h1>Mis Pedidos</h1>
    <?php if ($result_pedidos->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID Pedido</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
                <?php if ($is_admin): ?>
                    <th>Acción</th>
                <?php endif; ?>
            </tr>
            <?php while ($pedido = $result_pedidos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $pedido['id']; ?></td>
                    <td><?php echo $username;?></td>
                    <?php if ($is_admin): ?>
                        <td><?php echo htmlspecialchars($pedido['user_id']); ?></td>
                    <?php endif; ?>
                    <td><?php echo $pedido['total']; ?> €</td>
                    <td><?php echo ucfirst($pedido['estado']); ?></td>
                    <td><?php echo $pedido['fecha']; ?></td>
                    <?php if ($is_admin): ?>
                        <td>
                            <!-- Formulario para cambiar el estado del pedido -->
                            <form action="cambiar_estado_pedido.php" method="POST">
                                <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
                                <select name="estado">
                                    <option value="pendiente" <?php echo ($pedido['estado'] === 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="enviado" <?php echo ($pedido['estado'] === 'enviado') ? 'selected' : ''; ?>>Enviado</option>
                                    <option value="entregado" <?php echo ($pedido['estado'] === 'entregado') ? 'selected' : ''; ?>>Entregado</option>
                                </select>
                                <button type="submit">Actualizar</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No tienes pedidos registrados.</p>
        <a href="area_personal.php">Seguir Comprando</a>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
