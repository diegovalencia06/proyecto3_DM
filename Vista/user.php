<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - NomadNet</title>
    
    <link rel="stylesheet" href="../css/home.css">
    <link rel="icon" href="../img/logo_header.png">
    <link href="https://fonts.googleapis.com/css2?family=Forum&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <a href="../Controlador/home.php" class="logo-animado">NomadNet</a>

        <ul class="nav-links">
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Nosotros</a></li>
            <li><a href="#"></a></li>
            <li><a href="#" class="btn-formviaje">¡Añade tu viaje!</a></li>
        </ul>

        <div class="user-container">
            <?php 
                // Foto pequeña del Navbar (Sesión)
                $fotoNav = $_SESSION['fotografia'] ?? 'default_user.png'; 
                $ruta_nav = (strpos($fotoNav, 'http') === 0) ? $fotoNav : "../img/usuarios/" . $fotoNav;
            ?>
            
            <img src="<?php echo $ruta_nav; ?>" alt="Perfil" class="foto-perfil">

            <div>
                Bienvenido, <a style="color: green;" href="#"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                <p><a style="color: green; font-size: 0.8em;" href="../Controlador/logout.php">Cerrar sesión</a></p>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="perfil-card">
            
            <?php
                $fotoPerfil = !empty($datosUsuario['fotografia']) ? $datosUsuario['fotografia'] : 'default_user.png';
                $ruta_perfil = (strpos($fotoPerfil, 'http') === 0) ? $fotoPerfil : "../img/usuarios/" . $fotoPerfil;
            ?>

            <img src="<?php echo $ruta_perfil; ?>" alt="Foto Grande" class="foto-grande">
            
            <h2><?php echo htmlspecialchars($datosUsuario['username']); ?></h2>
            <span class="rol-badge">Viajero NomadNet</span>

            <ul class="datos-lista">
                <li>
                    <span class="icono">📧</span> 
                    <?php echo htmlspecialchars($datosUsuario['email']); ?>
                </li>
                
                <?php if (!empty($datosUsuario['telefono'])): ?>
                <li>
                    <span class="icono">📞</span> 
                    <?php echo htmlspecialchars($datosUsuario['telefono']); ?>
                </li>
                <?php endif; ?>

                <?php if (!empty($datosUsuario['date'])): ?>
                <li>
                    <span class="icono">🎂</span> 
                    <?php echo htmlspecialchars($datosUsuario['date']); ?>
                </li>
                <?php endif; ?>
            </ul>

            <a href="../Controlador/update_profile.php" class="btn-accion btn-editar">✏️ Editar Datos</a>
            <a href="../Controlador/logout.php" class="btn-accion btn-logout-card">Cerrar Sesión</a>

        </div>
    </div>

    <div><button id="btn-tema">🌙</button></div>
    
    <script src="../js/tema.js"></script>

</body>
</html>