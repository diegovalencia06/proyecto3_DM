<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="../css/auth.css">

    <link rel="icon" href="../img/logo_header.png">
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
            <img src="../img/logo.png" alt="">
            <div class="form-container">
                <h2>Regístrate</h2>
                <form method="post" action="../Controlador/register.php" enctype="multipart/form-data">
                    <div class="register-username">Nombre de usuario: <input name="username"></div>
                    <div class="register-email">Correo electrónico: <input name="email" type="email"></div>
                    <div class="register-password">Contraseña: <input name="password" type="password"></div>
                    <div class="register-telefono">Número de teléfono: <input name="telefono" type="tel"></div>
                    <div class="register-fecha">Fecha de nacimiento: <input name="date" type="date"></div>
                    <div class="register-foto">Foto de perfil:<input type="file" name="foto_perfil" accept="image/png, image/jpeg, image/jpg"></div>
                    <button type="submit" name="register">Registrarse</button>
                </form>
                <a href="../Controlador/google_callback.php" class="googleauth">
                    
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" 
                         style="width: 18px; height: 18px; margin-right: 10px;" alt="G">
                    Continuar con Google
                </a>
                <p class="change_auth">¿Ya tienes una cuenta? <a href="../Controlador/login.php" style="color: green;">Inicia sesión</a></p>
                <div class="error"><?php echo $_SESSION['error'] ?? '' ?></div>
            </div>
            
        </div>
    </div>
        <div><button id="btn-tema">🌙</button></div>
    <script src="../js/tema.js"></script>

</body>
</html>