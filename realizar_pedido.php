<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "tienda");

// ID del usuario logueado
$user_id = $_SESSION['user_id'];

// Obtener los productos del carrito del usuario
$sql = "SELECT * FROM carrito WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Crear un pedido por cada producto en el carrito
    while ($row = $result->fetch_assoc()) {
        $producto_id = $row['producto_id'];
        $cantidad = $row['cantidad'];
        $total = $row['producto_precio'] * $cantidad;

        // Insertar en la tabla de pedidos
        $insert_sql = "INSERT INTO pedidos (user_id, producto_id, cantidad, total)
                       VALUES ($user_id, $producto_id, $cantidad, $total)";
        $conn->query($insert_sql);
    }

    // Vaciar el carrito después de realizar el pedido
    $delete_sql = "DELETE FROM carrito WHERE user_id = $user_id";
    $conn->query($delete_sql);

    echo "Pedido realizado con éxito.</br>";
    echo '<a href="area_personal.php">Seguir Comprando</a>';

} else {
    echo "El carrito está vacío. No se puede realizar el pedido.";
}

$conn->close();

exit;
?>