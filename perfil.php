<?php
    //Iniciar sesión en el apartado oculto
    session_start();

    //Verificar nuevamente que el usuario esté autenticado para mayor seguridad
    if (!isset($_SESSION['correo'])) {
        header("Location: index.php");
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

    //Manejo de caso donde no se encuentra el usuario, aunque esto no debería ocurrir si la sesión es válida, es una medida de seguridad adicional
    if(!$usuarios_filora) {
        //Si no se encuentra el usuario, cerrar sesión por seguridad y redirigir al inicio de sesión
        header("Location: logout.php");
        exit();
    }

    //Verificación para alerta de inicio de sesión exitoso
    $login_exitoso = false;
    if(isset($_GET['login']) && $_GET['login'] == 'ok') {
        $login_exitoso = true;
    }
    //Verificación para alerta de actualización de datos exitosa
    $perfil_actualizado = false;
    if(isset($_GET['actualizado']) && $_GET['actualizado'] == '1') {
        $perfil_actualizado = true;
    }

    //Verificaciones de errores para mostrar alertas
    $mensaje_error = '';
    if(isset($_GET['error'])) {
        if($_GET['error'] == 'correo_invalido') { //Mensaje de error de correo inválido
            $mensaje_error = 'El correo ingresado no es válido. Por favor, ingresa un correo electrónico correcto.';
        } elseif($_GET['error'] == 'correo_existente') { //Mensaje de error de correo existente
            $mensaje_error = 'El correo ingresado ya está registrado. Por favor, utiliza otro correo.';
        } elseif($_GET['error'] == 'actualizacion_fallida') { //Mensaje de error de actualización
            $mensaje_error = 'Error al actualizar el perfil. Por favor, intenta nuevamente.';
        }
    }
    //Cerrar conexiones
    $stmt -> close();
    $conexion -> close();
?>

<!DOCTYPE html>
<html lang="es">
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
    <!--Alerta de inicio de sesión exitoso-->
    <?php if($login_exitoso): ?>
        <div id="alertaLogin" class="fixed top-20 right-5 bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-2xl shadow-xl z-[999] transition-all duration-500">
            ¡Bienvenido, <?= htmlspecialchars($_SESSION['nombres']) ?>! Has iniciado sesión exitosamente.
        </div>
    <?php endif; ?>
    <!--Alerta de actualización exitosa-->
    <?php if($perfil_actualizado): ?>
        <div id="alertaActualizado" class="fixed top-20 right-5 bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-2xl shadow-xl z-[999] transition-all duration-500">
            ¡Tu perfil ha sido actualizado exitosamente!
        </div>
    <?php endif; ?>
    <!--Alertas de errores-->
    <?php if($mensaje_error != ''): ?>
        <div id="alertaError" class="fixed top-20 right-5 bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-2xl shadow-xl z-[999] transition-all duration-500" role="alert">
            <?= htmlspecialchars($mensaje_error) ?>
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
        <!--Botón hamburgesa para móvil-->
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
                <a href="perfil.php" class="bg-rose-100 text-rose-500 rounded-2xl px-5 py-4 font-medium transition">Editar Perfil</a>
                <a href="cambiar_password.php" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Cambiar Contraseña</a>
                <a href="" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Favoritos</a>
                <a href="" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Carrito</a>
                <a href="" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Mis Compras</a>
                <a href="logout.php" class="hover:text-rose-700 text-neutral-600 rounded-2xl px-5 py-4 transition">Cerrar Sesión</a>
            </nav>
        </aside>
        <!--Contenido principal derecho del perfil (formulario de edición para nombres, apellidos, correo; y botón para guardar cambios)-->
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
    <script>
        //Script para desplegar menú hamburguesa en móviles
        const botonMovil = document.getElementById('botonMovil');
        const menuMovil = document.getElementById('menuMovil');

        botonMovil.addEventListener('click', () => {
            menuMovil.classList.toggle('hidden');
        });

        //Cerrar el mensaje de login exitoso luego de 3 segundos
        const alertaLogin = document.getElementById('alertaLogin');
        if(alertaLogin) {
            //Quitar parámetro de URL para evitar que el mensaje aparezca al recargar la página
            window.history.replaceState({}, document.title, "perfil.php");
            //Cerrar el mensaje después de 3 segundos
            setTimeout(() => {
                alertaLogin.style.opacity = '0';
                setTimeout(() => {
                    alertaLogin.remove();
                }, 500);
            }, 3000);
        }
        //Cerrar el mensaje de actualización exitosa luego de 3 segundos
        const alertaActualizado = document.getElementById('alertaActualizado');
        if(alertaActualizado) {
            //Quitar parámetro de URL para evitar que el mensaje aparezca al recargar la página
            window.history.replaceState({}, document.title, "perfil.php");
            //Cerrar el mensaje después de 3 segundos
            setTimeout(() => {
                alertaActualizado.style.opacity = '0';
                setTimeout(() => {
                    alertaActualizado.remove();
                }, 500);
            }, 3000);
        }
        //Cerrar el mensaje de errores luego de 3 segundos
        const alertaError = document.getElementById('alertaError');
        if(alertaError) {
            //Quitar parámetro de URL para evitar que el mensaje aparezca al recargar la página
            window.history.replaceState({}, document.title, "perfil.php");
            //Cerrar el mensaje después de 3 segundos
            setTimeout(() => {
                alertaError.style.opacity = '0';
                setTimeout(() => {
                    alertaError.remove();
                }, 500);
            }, 3000);
        }
    </script>
</body>
</html>