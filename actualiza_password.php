<?php
    //Iniciar sesión
    session_start();

    //Verificar nuevamente que el usuario esté autenticado para mayor seguridad
    if(!isset($_SESSION['correo'])) {
        header("Location: index.php");
        exit();
    }

    //Verificar el método POST que viene del formulario de cambiar_password
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        //Conexión a la base de datos
        require_once("conexion.php");
        //Obtener correo actual desde la sesión
        $correo = $_SESSION['correo'];

        //Obtener datos recibidos del formulario
        $clave_actual = ($_POST['contrasena_actual']);
        $nueva_clave = ($_POST['nueva_contrasena']);
        $confirmar_clave = ($_POST['confirmar_nueva_contrasena']);

        //Validar que la nueva contraseña y la confirmación coincidan
        if($nueva_clave !== $confirmar_clave) {
            header("Location: cambiar_password.php?error=Las contraseñas nuevas no coinciden");
            exit();
        }

        //Buscar la contraseña actual del usuario en la base de datos
        $stmt = $conexion -> prepare("SELECT contraseña FROM usuarios_filora WHERE correo = ?");
        $stmt -> bind_param("s", $correo);
        $stmt -> execute();
        $resultado = $stmt -> get_result();
        $usuario = $resultado -> fetch_assoc();

        //Verificar que la contraseña actual ingresada sea correcta
        if(!password_verify($clave_actual, $usuario['contraseña'])) {
            header("Location:cambiar_password.php?error=La contraseña actual es incorrecta");
            exit();
        }
        //Validar que la nueva contraseña no sea la misma que la actual
        if(password_verify($nueva_clave, $usuario['contraseña'])) {
            header("Location:cambiar_password.php?error=La nueva contraseña no puede ser la misma que la actual");
            exit();
        }

        //Hashear la nueva contraseña
        $nueva_clave_hashed = password_hash($nueva_clave, PASSWORD_DEFAULT);
        //Actualizar la contraseña en la base de datos
        $stmt = $conexion -> prepare("UPDATE usuarios_filora SET contraseña = ? WHERE correo = ?");
        $stmt -> bind_param("ss", $nueva_clave_hashed, $correo);
        if($stmt -> execute()) {
            //Redirigir al perfil con un mensaje de éxito
            header("Location: cambiar_password.php?cambio_password=1");
            exit();
        } else {
            //Mostrar mensaje de error en caso de que no se pueda ejecutar el cambio
            header("Location: cambiar_password.php?error=Error al cambiar la contraseña. Por favor, intenta nuevamente.");
            exit();
        }  
    }
?>