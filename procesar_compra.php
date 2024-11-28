<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$dbname = "tienda";

$conn = new mysqli($host, $user, $password, $dbname);

// Obtener los datos del formulario
$producto_id = $_REQUEST['producto_id'];
$producto_nombre = $_REQUEST['producto_nombre'];
$producto_precio = $_REQUEST['producto_precio'];
$cantidad = $_REQUEST['cantidad'];
$user_id = $_SESSION['user_id'];

// Insertar en la tabla 'carrito'
$sql = "INSERT INTO carrito (producto_id, producto_nombre, producto_precio, cantidad, user_id)
        VALUES ('$producto_id','$producto_nombre', '$producto_precio', '$cantidad', '$user_id')";

if ($conn->query($sql) === TRUE) {
    // Redirigir de vuelta a la página principal
    header("Location: area_personal.php");
} else {
    echo "Error al añadir el producto: " . $conn->error;
}

$conn->close();
?>