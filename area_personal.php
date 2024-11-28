<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html"); // Redirigir al login si no está logueado
    exit;
}

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "tienda");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Obtener datos del usuario
$sql_user = "SELECT username FROM usuarios WHERE id = $user_id";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Personal</title>
</head>
<style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        :root {
            --primary: #2c3e50;
            --secondary: #e74c3c;
            --accent: #3498db;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: var(--light);
        }

        header {
            background: var(--primary);
            color: white;
            padding: 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
            margin-left: 10px; /* Empuja la sección de botones hacia la derecha */
        }

        .nav-btn {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .modal:target {
            display: block;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-submit {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .modal:target+.overlay {
            display: block;
        }

        main {
            max-width: 1200px;
            margin: 6rem auto 2rem;
            padding: 0 1rem;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .product-image {
            width: 100%;
            height: 200px;
            background: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
        }

        .product-info {
            padding: 1rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .product-price {
            color: var(--secondary);
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .product-description {
            flex-grow: 1;
        }

        .add-to-cart {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            width: 100%;
            margin-top: auto;
        }
        .cart-icon {
            font-size: 1.5rem;
            padding: 0.5rem;
            display: flex;
            margin-left: auto; /* Alinea el icono del carrito a la derecha */
            text-decoration: none; /* Quita el subrayado */
        }

        @media (max-width: 768px) {
            .products {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }
    </style>
<body>
    <header>
        <nav>
    <h1>Bienvenido, <?php echo htmlspecialchars($user['username']); ?></h1>
    <a href="carrito.php" class="nav-btn">Ver carrito</a> 
    <a href="pedidos.php" class="nav-btn">Ver tus pedidos</a>
    </nav>
    </header>
</body>
<div class="overlay"></div>
    <main>

        <div class="products">
            <!-- Producto 1 -->
            <div class="product-card">
            <form method="REQUEST" action="procesar_compra.php">
                <div class="product-image">📱</div>
                <div class="product-info">
                    <h3 class="product-title">Smartphone XYZ</h3>
                    <p class="product-description">Último modelo con cámara profesional</p>
                    <div class="product-price">$599.99</div>
                    
                        <input type="hidden" name="producto_id" value="1">
                        <input type="hidden" name="producto_nombre" value="Smartphone XYZ">
                        <input type="hidden" name="producto_precio" value="599.99">
                        <input type="number" id="cantidad" name="cantidad" min="1" value="1" class="add-to-cart"></br>
                        <button type="submit" class="add-to-cart">Añadir al Carrito</button>
                    </div>
            </div>
        </form>
        <form method="REQUEST" action="procesar_compra.php">

            <!-- Producto 2 -->
            <div class="product-card">
                <div class="product-image">💻</div>
                <div class="product-info">
                    <h3 class="product-title">Laptop Pro</h3>
                    <p class="product-description">Potente laptop para profesionales</p>
                    <div class="product-price">$1299.99</div>
                        <input type="hidden" name="producto_id" value="2">
                        <input type="hidden" name="producto_nombre" value="Laptop Pro">
                        <input type="hidden" name="producto_precio" value="1299.99">
                        <input type="number" id="cantidad" name="cantidad" min="1" value="1" class="add-to-cart"></br>
                        <button type="submit" class="add-to-cart">Añadir al Carrito</button>
                    </div>
            </div>
        </form>
        <form method="REQUEST" action="procesar_compra.php">
            <!-- Producto 3 -->
            <div class="product-card">
                <div class="product-image">🎧</div>
                <div class="product-info">
                    <h3 class="product-title">Auriculares Wireless</h3>
                    <p class="product-description">Sonido premium sin cables</p>
                    <div class="product-price">$149.99</div>

                        <input type="hidden" name="producto_id" value="3">
                        <input type="hidden" name="producto_nombre" value="Auriculares Wireless">
                        <input type="hidden" name="producto_precio" value="149.99">
                        <input type="number" id="cantidad" name="cantidad" min="1" value="1" class="add-to-cart"></br>
                        <button type="submit" class="add-to-cart">Añadir al Carrito</button>
                    </div>
            </div>
        </form>
        <form method="REQUEST" action="procesar_compra.php">
            <!-- Producto 4 -->
            <div class="product-card">
                <div class="product-image">⌚</div>
                <div class="product-info">
                    <h3 class="product-title">Smartwatch Sport</h3>
                    <p class="product-description">Tu compañero fitness perfecto</p>
                    <div class="product-price">$199.99</div>

                        <input type="hidden" name="producto_id" value="4">
                        <input type="hidden" name="producto_nombre" value="Smartwatch Sport">
                        <input type="hidden" name="producto_precio" value="199.99">
                        <input type="number" id="cantidad" name="cantidad" min="1" value="1" class="add-to-cart"></br>
                        <button type="submit" class="add-to-cart">Añadir al Carrito</button>
                    </form>   
                </div>
            </div>
        </div>
    </main>
</body>
</html>

<?php
$conn->close();
?>
