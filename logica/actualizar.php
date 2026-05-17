<?php
    //Iniciar sesión
    session_start();

    //Verificar nuevamente que el usuario esté autenticado para mayor seguridad
    if(!isset($_SESSION['correo'])) {
        header("Location: index.php");
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
            header("Location: perfil.php?error=correo_invalido");
            exit();
        }
        //Verificar si el nuevo correo ya existe en la base de datos y no es el mismo que el actual
        $verificar_correo = $conexion -> prepare("SELECT correo FROM usuarios_filora WHERE correo = ? AND correo != ?");
        $verificar_correo -> bind_param("ss", $correo_nuevo, $correo_actual);
        $verificar_correo -> execute();
        $verificar_correo -> store_result();
        if($verificar_correo -> num_rows > 0) {
            header("Location: perfil.php?error=correo_existente");
            exit();
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

            //Muestra los cambios nuevos en el perfil y en la página de perfil un mensaje de éxito
            header("Location: perfil.php?actualizado=1");
            exit();
        } else {
            //Mensaje en caso de no ejecutarse la actualización
            header("Location: perfil.php?error=actualizacion_fallida");
            exit();
        }
        //Cerrar conexiones
        $stmt -> close();
        $conexion -> close();
    }
?>