<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "tienda");

// Obtener el ID del producto a eliminar
$producto_id = intval($_REQUEST['producto_id']);
$user_id = $_SESSION['user_id'];

// Eliminar el producto específico del carrito del usuario
$sql = "DELETE FROM carrito WHERE producto_id = $producto_id AND user_id = $user_id";

$conn->close();

// Redirigir al carrito
header("Location: carrito.php");
exit;
?>
