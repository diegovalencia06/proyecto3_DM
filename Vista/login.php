<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio sesión</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="main">
        <div class="slider">
            <ul>
                <li><img src="../img/slider1.jpg" alt=""></li>
                <li><img src="../img/slider2.jpg" alt=""></li>
                <li><img src="../img/slider3.jpg" alt=""></li>
                <li><img src="../img/slider4.jpg" alt=""></li>

            </ul>
        </div>
        <div class="form-login">
            <div class="form-container">
                <h2>Inicio de sesión</h2>
                <form method="post" action="../Controlador/login.php">
                    <div class="login-username">Nombre de usuario: <input name="username" required></div>
                    <div class="login-password">Contraseña: <input name="password" type="password" required></div>
                    <button type="submit" name="login">Iniciar sesión</button>
                </form>
                <p>¿Todavía no tienes cuenta? <a href="../Controlador/register.php" style="color: green;">Regístrate</a></p>
                <div class="error">
                    <?php echo $_SESSION['error'] ?? '' ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>