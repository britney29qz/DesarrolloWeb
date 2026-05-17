<?php
    //Manejar las alertas de error en el registro, como correo ya registrado o claves que no coinciden
    $mensaje_error = "";
    if(isset($_GET['error'])) {
        if($_GET['error'] == 'correo_existente') {
            $mensaje_error = "El correo ya está registrado. Por favor, utiliza otro."; //Mensaje de error para correo ya registrado
        }
        if($_GET['error'] == 'claves_no_coinciden') {
            $mensaje_error = "Las contraseñas nuevas no coinciden. Por favor, ingresa contraseñas iguales."; //Mensaje de error para claves que no coinciden
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
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
<body class="bg-white py-16 px-4">
    <!--Contenedor principal del formulario de registro-->
    <main class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl p-8 md:p-10 mx-auto">
        <h3 class="text-2xl text-center font-semibold text-neutral-800 mb-2">Crear Cuenta</h3>
        <p class="text-center text-neutral-600 mb-8">Regístrate para acceder a tus compras y favoritos</p>
        <!--Mostrar alertas de error si existen-->
        <?php if($mensaje_error !=''): ?>
            <div id="alertaErrorConCorr" class="fixed top-20 right-5 bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-2xl shadow-xl z-[999] transition-all duration-500" role="alert">
                <?= htmlspecialchars($mensaje_error) ?>
            </div>
        <?php endif; ?>
        <!--Formulario de registro-->
        <form class="flex flex-col gap-4 pl-5 pr-5" action="guarda_usuario.php" method="POST">
            <label class="text-neutral-700 font-medium" for="nombre">Nombres</label>
            <input class="border border-rose-200 rounded-2xl gap-1 px-4 py-3 outline-none focus:border-rose-300 transition" type="text" name="nombres" placeholder="Ej. Luis Enrique" required>
            <label class="text-neutral-700 font-medium" for="apellidos">Apellidos</label>
            <input class="border border-rose-200 rounded-2xl px-4 py-3 outline-none focus:border-rose-300 transition" type="text" name="apellidos" placeholder="Ej. López Vera" required>
            <label class="text-neutral-700 font-medium" for="cedula">Cédula</label>
            <input class="border border-rose-200 rounded-2xl px-4 py-3 outline-none focus:border-rose-300 transition" type="text" name="cedula" placeholder="Ej. 1234567890" minlength="10" maxlength="10" required>
            <label class="text-neutral-700 font-medium" for="correo">Correo Electrónico</label>
            <input class="border border-rose-200 rounded-2xl px-4 py-3 outline-none focus:border-rose-300 transition" type="email" name="correo" placeholder="Ej. luislopez@email.com" required>
            <label class="text-neutral-700 font-medium" for="contraseña">Contraseña</label>
            <input class="border border-rose-200 rounded-2xl px-4 py-3 outline-none focus:border-rose-300 transition" type="password" name="clave" placeholder="Mínimo 8 caracteres alfanuméricos" minlength="8" maxlength="30" required>
            <label class="text-neutral-700 font-medium" for="confirmar_contraseña">Confirmar Contraseña</label>
            <input class="border border-rose-200 rounded-2xl px-4 py-3 outline-none focus:border-rose-300 transition" type="password" name="confirmar_clave" required>
            
            <button class="bg-rose-400 hover:bg-rose-500 transition duration-300 text-white py-3 rounded-full font-medium mt-3 cursor-pointer" type="submit" value="Registrar Usuario">
                Registrar Usuario
            </button>
            <!--Pequeña sección que redirecciona al inicio-->
            <p class="text-center text-neutral-600 mb-8">
                <a href="index.php" class="text-rose-500 hover:text-rose-700 transition-colors duration-300">
                    Volver al inicio
                </a>
            </p>
        </form>
    </main>

    <script>
        //Cerrar el mensaje de error de registro luego de 3 segundos
        const alertaErrorConCorr = document.getElementById('alertaErrorConCorr');
        if(alertaErrorConCorr) {
            //Quitar parámetro de la URL para evitar que el mensaje aparezca al refrescar
            window.history.replaceState({}, document.title, "registro_usuario.php");
            setTimeout(() => {
                alertaErrorConCorr.style.opacity = '0';
                setTimeout(() => {
                    alertaErrorConCorr.remove();
                }, 500);
            }, 3000);
        }
    </script>
</body>
</html>