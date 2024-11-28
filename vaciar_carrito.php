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

// Eliminar todos los productos del carrito del usuario
$sql = "DELETE FROM carrito WHERE user_id = $user_id";



$conn->close();

// Redirigir al carrito
header("Location: carrito.php");
exit;
?>
