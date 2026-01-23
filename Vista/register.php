<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="../css/register.css">
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
        <div class="form-register">
            <div class="form-container">
                <h2>Regístrate</h2>
                <form method="post" action="../Controlador/register.php">
                    <div class="register-username">Nombre de usuario: <input name="username"></div>
                    <div class="register-email">Correo electrónico: <input name="email" type="email"></div>
                    <div class="register-password">Contraseña: <input name="password" type="password"></div>
                    <div class="register-telefono">Número de teléfono: <input name="telefono" type="tel"></div>
                    <div class="register-fecha">Fecha de nacimiento: <input name="date" type="date"></div>
                    <button type="submit" name="register">Registrarse</button>
                </form>
                <p>¿Ya tienes una cuenta? <a href="../Controlador/login.php" style="color: green;">Inicia sesión</a></p>
                <div class="error">
                    <?php echo $_SESSION['error'] ?? '' ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>