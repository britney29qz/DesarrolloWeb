<?php
    
    //Iniciar sesión en el apartado oculto
    session_start();

    //Verificar nuevamente que el usuario esté autenticado para mayor seguridad
    if (!isset($_SESSION['correo'])) {
        header("Location: index.html");
        exit();
    }

    //Conexión a la base de datos
    require_once ("conexion.php");

    //Obtener correo desde la sesión para identificar al usuario
    $correo = $_SESSION['correo'];

    //Buscar la información del usuario utilizando el correo de la sesión
    $stmt = $conexion -> prepare("SELECT nombres, apellidos, correo FROM usuarios_filora WHERE correo = ?");
    $stmt -> bind_param("s", $correo);
    $stmt -> execute();
    $resultado = $stmt -> get_result();
    $usuarios_filora = $resultado -> fetch_assoc();

    //Manejo de caso donde no se encuentra el usuario o la cédula no es válida
    if(!$usuarios_filora) {
        //Mostrar mensaje de error si no se encuentra el usuario o la cédula no es válida
        die("Usuario no encontrado. Por favor, vuelva a intentar.");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
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
    <!--Menú de navegación fijo para todas las páginas-->
    <header class="w-full h-30 bg-white flex items-center justify-between px-8 shadow-sm relative z-50">
        <img src="img/logolargo.png" alt="Logo de Filora" class="w-50">
        <!--Menú para desktop-->
        <nav class="hidden lg:flex gap-30 mr-20 text-neutral-700 text-lg font-medium">
            <a href="index.html" class="hover:text-rose-700 transition-colors duration-300">Inicio</a>
            <a href="productos.html" class="hover:text-rose-700 transition-colors duration-300">Productos</a>
            <a href="nosotros.html" class="hover:text-rose-700 transition-colors duration-300">Nosotros</a>
            <a href="perfil.html" class="hover:text-rose-700 transition-colors duration-300">Perfil</a>
        </nav>
        <!--Botoón hamburgesa-->
        <button id="botonMovil" class="lg:hidden cursor-pointer" aria-label="Abrir menú">
            <svg class="w-8 h-8 text-neutral-700 hover:text-rose-700 transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <!--Menú para móviles-->
        <nav id="menuMovil" class="hidden lg:hidden absolute top-25 left-0 w-full bg-white shadow-md">
            <div class="flex flex-col items-center gap-6 py-6 text-neutral-700 text-lg font-medium">
                <a href="index.html" class="hover:text-rose-700 transition-colors duration-300">Inicio</a>
                <a href="productos.html" class="hover:text-rose-700 transition-colors duration-300">Productos</a>
                <a href="nosotros.html" class="hover:text-rose-700 transition-colors duration-300">Nosotros</a>
                <a href="perfil.html" class="hover:text-rose-700 transition-colors duration-300">Perfil</a>
            </div>
        </nav>
    </header>
    <!--Contenedor-->
    <main class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-8">
        <!--Aside de perfil-->
        <aside class="bg-white w-full lg:w-[30%] p-5 h-fit">
            <h2 class="text-2xl font-semibold text-neutral-700 mb-8">Mi Perfil</h2>
            <nav class="flex flex-col gap-3">
                <a href="perfil.php" class="bg-rose-100 text-rose-500 rounded-2xl px-5 py-4 font-medium transition">Editar Perfil</a>
                <a href="cambiar_password.php" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Cambiar Contraseña</a>
                <a href="" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Favoritos</a>
                <a href="" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Carrito</a>
                <a href="" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Mis Compras</a>
                <a href="" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Cerrar Sesión</a>
            </nav>
        </aside>
        <!--Contenido principal del perfil (formulario de edición)-->
        <section class="bg-white shadow-xl rounded-3xl w-full lg:w-[70%] p-8 lg:p-10">
            <h1 class="text-2xl font-semibold text-neutral-700 mb-2">Actualiza tu información personal</h1>
            <form class="flex flex-col gap-5" action="actualizar.php" method="POST">
                <label class="text-neutral-600 font-medium">Nombres</label>
                <input class="border border-rose-200 rounded-2xl px-4 py-3 outline-none focus:border-rose-300 transition" type="text" name="nombres" value="<?= htmlspecialchars($usuarios_filora['nombres']) ?>" required> 
                <label class="text-neutral-600 font-medium">Apellidos</label>
                <input class="border border-rose-200 rounded-2xl px-4 py-3 outline-none focus:border-rose-300 transition" type="text" name="apellidos" value="<?= htmlspecialchars($usuarios_filora['apellidos']) ?>" required>
                <label class="text-neutral-600 font-medium">Correo</label>
                <input class="border border-rose-200 rounded-2xl px-4 py-3 outline-none focus:border-rose-300 transition" type="email" name="correo" value="<?= htmlspecialchars($usuarios_filora['correo']) ?>" required>
                <button class="bg-rose-400 hover:bg-rose-500 transition duration-300 text-white py-3 rounded-xl font-medium mt-2 cursor-pointer" type="submit">
                    Guardar Cambios
                </button>
            </form>


        </section>

    </main>

    
</body>
</html>