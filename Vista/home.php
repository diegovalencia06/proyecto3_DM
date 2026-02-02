<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="icon" href="../img/logo_header.png">

    <title>NomadNet</title>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="logo-animado">NomadNet</a>

        <ul class="nav-links">
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Nosotros</a></li>
            <li><a href="#"></a></li>
            <li><a href="#" class="btn-formviaje">¡Añade tu viaje!</a></li>
        </ul>

        <div>Bienvenido, <a style="color: green;" href="../Controlador/user.php"><?php echo $_SESSION['username']?></a>

        <p><a style="color: green;" href="../Controlador/logout.php">Cerrar sesión</a></p></div>
    </nav>
    <div><button id="btn-tema">🌙</button></div>
    <script src="../js/tema.js"></script>
</body>
</html>