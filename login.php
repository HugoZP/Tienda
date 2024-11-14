<?php
//Conexion con la base de datos 
$conn = new mysqli("localhost", "root", "", "tienda");
// Guardar los datos enviados mediante el formulario
$name = $_POST["name"];
$password = $_POST["password"];
// Construimos la consulta
$sql = "SELECT password FROM login WHERE name = '$name'";
// Ejecutamos y recogemos el resultado
$result = $conn->query($sql);

// Verificar si el usuario esta registrado
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verificar la contraseña directamente
    if ($password === $row['password']) {
        echo "Login exitoso. ¡Bienvenido, $name!";
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}
// Cierro conexion
$conn->close();
?>
