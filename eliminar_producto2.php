<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "tienda");

$producto_id= $_GET['id'];

$sql = "DELETE FROM productos WHERE id = $producto_id";

$conn->query($sql);

$conn->close();

header("Location: admin_area.php");
exit;
?>
