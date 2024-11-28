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
$id = $_GET['id'];

// Eliminar el producto específico del carrito del usuario
$sql = "DELETE FROM usuarios WHERE id = $id";

$conn->close();

// Redirigir al carrito
header("Location: admin_area.php");
exit;
?>
