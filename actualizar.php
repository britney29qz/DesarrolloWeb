<?php

    //Iniciar sesión
    session_start();

    //Verificar nuevamente que el usuario esté autenticado para mayor seguridad
    if(!isset($_SESSION['correo'])) {
        header("Location: index.html");
        exit();
    }

    //Verificar el método POST que viene del formulario de perfil
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        //Conexión a la base de datos
        require_once ("conexion.php");
        //Obtener correo actual desde la sesión 
        $correo_actual = $_SESSION['correo'];

        //Sanitización de datos recibidos del formulario
        $nombres = htmlspecialchars(trim($_POST['nombres']));
        $apellidos = htmlspecialchars(trim($_POST['apellidos']));
        $correo_nuevo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);

        //Validar correo
        if(!filter_var($correo_nuevo, FILTER_VALIDATE_EMAIL)) {
            die("Correo no válido. Por favor, ingresa un correo correcto.");
        }

        //Actualizar la información del usuario en la base de datos si todo es correcto
        $stmt = $conexion -> prepare("UPDATE usuarios_filora SET nombres = ?, apellidos = ?, correo = ? WHERE correo = ?");
        $stmt -> bind_param("ssss", $nombres, $apellidos, $correo_nuevo, $correo_actual);

        //Ejecutar y verificar si la actualización fue exitosa
         if($stmt -> execute()) {
            //Actualizar sesión con el nuevo correo si se cambió
            $_SESSION['nombres'] = $nombres;
            $_SESSION['apellidos'] = $apellidos;
            $_SESSION['correo'] = $correo_nuevo;

            //Redirigir de nuevo al perfil para mostrar los cambios
            header("Location: perfil.php");
            exit();
        } else {
            echo "Error al actualizar el perfil. Por favor, intenta nuevamente.";
        }

        $stmt -> close();
        $conexion -> close();

    }




?>