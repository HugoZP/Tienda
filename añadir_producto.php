<?php 
// Crear una conexión
$conn = new mysqli("localhost", "root", "", "tienda");
// Recojo los parámetros enviados  
$producto_nombre = $_REQUEST["producto_nombre"];
$producto_precio = $_REQUEST["producto_precio"];
// Construyo la consulta
$sql = "insert into productos (producto_nombre, producto_precio) 
        values ('$producto_nombre', '$producto_precio')";
// ejecuto la consulta
$conn->query($sql);
// Cierro la conexión
$conn->close();
header("Location: admin_area.php");
?>