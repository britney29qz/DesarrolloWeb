<?php
    //Iniciar sesión en el apartado oculto
    session_start();

    //Verificar nuevamente que el usuario esté autenticado para mayor seguridad
    if (!isset($_SESSION['correo'])) {
        header("Location: index.php");
        exit();
    }

    //Verificación para alerta de cambio de contraseña exitosa
    $cambio_password = false;
    $error_password = "";
    if(isset($_GET['cambio_password']) && $_GET['cambio_password'] == '1') { //Para correcto
        $cambio_password = true;
    }
    if(isset($_GET['error'])) { //Para error
        $error_password = $_GET['error'];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!--Importar fuentes-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    <!--Configurar fuente-->
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-white">
    <!--Alerta de cambio de contraseña exitoso-->
    <?php
        if(isset($_GET['cambio_password'])): ?>
            <div id="alertaCambioPassword" class="fixed top-20 right-5 bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-2xl shadow-xl z-[999] transition-all duration-500" role="alert">
                ¡Cambio de contraseña exitoso!
            </div>
    <?php endif; ?>
    <!--Alerta de error en cambio de contraseña-->
    <?php
        if(isset($_GET['error'])): ?>
            <div id="alertaErrorPassword" class="fixed top-20 right-5 bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-2xl shadow-xl z-[999] transition-all duration-500" role="alert">
                <?= htmlspecialchars($error_password) ?>
            </div>
    <?php endif; ?>

    <!--Menú de navegación fijo para todas las páginas-->
    <header class="w-full h-30 bg-white flex items-center justify-between px-8 shadow-sm relative z-50">
        <img src="img/logolargo.png" alt="Logo de Filora" class="w-50">
        <!--Menú para desktop-->
        <nav class="hidden lg:flex gap-30 mr-20 text-neutral-700 text-lg font-medium">
            <a href="index.php" class="hover:text-rose-700 transition-colors duration-300">Inicio</a>
            <a href="index.php" class="hover:text-rose-700 transition-colors duration-300">Productos</a>
            <a href="index.php" class="hover:text-rose-700 transition-colors duration-300">Nosotros</a>
            <a href="perfil.php" class="hover:text-rose-700 transition-colors duration-300">Perfil</a>
        </nav>
        <!--Botón hamburgesa para móviles-->
        <button id="botonMovil" class="lg:hidden cursor-pointer" aria-label="Abrir menú">
            <svg class="w-8 h-8 text-neutral-700 hover:text-rose-700 transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <!--Menú para móviles-->
        <nav id="menuMovil" class="hidden lg:hidden absolute top-25 left-0 w-full bg-white shadow-md z-50">
            <div class="flex flex-col items-center gap-6 py-6 text-neutral-700 text-lg font-medium">
                <a href="index.php" class="hover:text-rose-700 transition-colors duration-300">Inicio</a>
                <a href="index.php" class="hover:text-rose-700 transition-colors duration-300">Productos</a>
                <a href="index.php" class="hover:text-rose-700 transition-colors duration-300">Nosotros</a>
                <a href="perfil.php" class="hover:text-rose-700 transition-colors duration-300">Perfil</a>
            </div>
        </nav>
    </header>
    <!--Contenedor principal-->
    <main class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-8">
        <!--Aside izquiero con items de interés del perfil-->
        <aside class="bg-white w-full lg:w-[30%] p-5 h-fit z-0">
            <h2 class="text-2xl font-semibold text-neutral-700 mb-8">Mi Perfil</h2>
            <nav class="flex flex-col gap-3">
                <a href="perfil.php" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Editar Perfil</a>
                <a href="cambiar_password.php" class="bg-rose-100 text-rose-500 rounded-2xl px-5 py-4 font-medium transition">Cambiar Contraseña</a>
                <a href="" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Favoritos</a>
                <a href="" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Carrito</a>
                <a href="" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Mis Compras</a>
                <a href="logout.php" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Cerrar Sesión</a>
            </nav>
        </aside>
        <!--Contenido principal derecho del perfil (Formulario de cambio de contraseña y botón de guardar cambios)-->
        <section class="bg-white shadow-xl rounded-3xl w-full lg:w-[70%] p-8 lg:p-10">
            <h1 class="text-2xl font-semibold text-neutral-700 mb-2">Cambia tu contraseña</h1>
            <form class="flex flex-col gap-5" action="actualiza_password.php" method="POST">
                <label class="text-neutral-600 font-medium">Contraseña Actual</label>
                <input class="border border-rose-200 rounded-2xl px-4 py-3 outline-none focus:border-rose-300 transition" type="password" name="contrasena_actual" required>
                <label class="text-neutral-600 font-medium">Nueva Contraseña</label>
                <input class="border border-rose-200 rounded-2xl px-4 py-3 outline-none focus:border-rose-300 transition" type="password" name="nueva_contrasena" required>
                <label class="text-neutral-600 font-medium">Confirmar Nueva Contraseña</label>
                <input class="border border-rose-200 rounded-2xl px-4 py-3 outline-none focus:border-rose-300 transition" type="password" name="confirmar_nueva_contrasena" required>
                <button class="bg-rose-400 hover:bg-rose-500 transition duration-300 text-white py-3 rounded-xl font-medium mt-2 cursor-pointer" type="submit">
                    Guardar Cambios
                </button>
            </form>
        </section>
    </main>
    <script>
        //Script para desplegar menú hamburguesa en móviles
        const botonMovil = document.getElementById('botonMovil');
        const menuMovil = document.getElementById('menuMovil');

        botonMovil.addEventListener('click', () => {
            menuMovil.classList.toggle('hidden');
        });

        //Cerrar el mensaje de cambio de contraseña exitoso luego de 3 segundos
        const alertaCambioPassword = document.getElementById('alertaCambioPassword');
        if(alertaCambioPassword) {
            //Quitar parámetro de URL para evitar que el mensaje aparezca al recargar la página
            window.history.replaceState({}, document.title, "cambiar_password.php");
            setTimeout(() => {
                alertaCambioPassword.style.opacity = '0';
                setTimeout(() => {
                    alertaCambioPassword.remove();
                }, 500);
            }, 3000);
        }
        //Cerrar el mensaje de error de cambio de contraseña luego de 3 segundos
        const alertaErrorPassword = document.getElementById('alertaErrorPassword');
        if(alertaErrorPassword) {
            //Quitar parámetro de URL para evitar que el mensaje aparezca al recargar la página
            window.history.replaceState({}, document.title, "cambiar_password.php");
            setTimeout(() => {
                alertaErrorPassword.style.opacity = '0';
                setTimeout(() => {
                    alertaErrorPassword.remove();
                }, 500);
            }, 3000);
        }
    </script>
</body>
</html>