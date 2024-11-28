<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "tienda");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Escapar datos para prevenir inyección SQL
    $username = $conn->real_escape_string($username);

    // Consulta SQL para verificar el usuario y la contraseña
    $sql = "SELECT id, password FROM usuarios WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar si la contraseña coincide
        if ($password === $row['password']) { 
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;

            // Verificar si es el admin (por nombre de usuario)
            if ($username === 'admin') {
                // Si es admin, redirigir a la página del admin
                header("Location: admin_area.php");
            } else {
                // Si es un usuario normal, redirigir a su área personal
                header("Location: area_personal.php");
            }
            exit;
        } else {
            // Contraseña incorrecta
            $error = "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        $error = "El usuario no existe.";
    }
}

// Cerrar conexión
$conn->close();

// Mostrar error si ocurre
if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
    echo "<a href='index.html'>Volver al inicio</a>";
}
?>
