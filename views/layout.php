<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>
    <div class="contenedor-app">
        <div class="imagen"></div>
        <div class="app">
            <?php
            if (isset($_SESSION['usuario'])) {
                $usuario = $_SESSION['usuario'];
            }
            ?>
            <div class="alertajs"></div>
            <nav class="nav-bar">
                <div class="menu-user">
                    <a href="/">
                        <img class="icon" src="/build/img/barberlogo.png" alt="logo">
                    </a>
                    <?php
                    if (isset($usuario->nombre)) { ?>
                        <div class="menu-usuario">
                            <div class="datos-usuario hover-resalt">
                                <p class="nombre-usuario"><?php echo $usuario->nombre ?></p>
                                <svg class="icon avatar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z" />
                                </svg>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </nav>

            <main class="main">

                <?php echo $contenido; ?>
                <?php $mensaje = $_GET['mensaje'] ?? null;
                if (isset($mensaje)) {
                    mostrarMensaje($mensaje);
                }

                ?>
                <?php
                echo $script ?? '';
                ?>
                <?php
                if (isset($usuario->nombre)) { ?>
                    <script src='/build/js/usuario.js'></script>
                <?php } ?>
        </div>
        </main>
    </div>
    <script src="/build/js/globales.js"></script>
</body>

</html>