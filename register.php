<?php
//Conexion con la base de datos 
$conn = new mysqli("localhost", "root", "", "tienda");
// Guardar los datos que se envian mediante el formulario
$rnombre = $_POST["fullname"];
$rname = $_POST["rname"];
$rpassword = $_POST["rpassword"];
// Creamos la consulta sql para almacenar los datos del formulario en la base de datos
$sql = "insert into usuarios (username, nombre, password) values ('$rname', '$rnombre', '$rpassword')";
// Guardamos la consultas en resultado 
$conn->query($sql);
// Cierro conexion
$conn->close();
header("Location: index.html")
?>

