<?php
    //Iniciar sesión para manejar el estado de autenticación
    session_start();
    //Conexión a la base de datos
    require_once ("conexion.php");

    //Recepción de datos del login
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $clave = $_POST['clave'];

    //Buscar usuario en la base de datos
    $stmt = $conexion -> prepare("SELECT nombres, apellidos, correo, contraseña FROM usuarios_filora WHERE correo = ?");
    $stmt -> bind_param("s", $correo);
    $stmt -> execute();

    $resultado = $stmt -> get_result();

    //Verificar si el usuario existe
    if ($resultado -> num_rows > 0) {
        $usuario = $resultado -> fetch_assoc();
        //Verificar contraseña
        if(password_verify($clave, $usuario['contraseña'])) {
            //Crear variables de sesión
            $_SESSION['nombres'] = $usuario['nombres'];
            $_SESSION['apellidos'] = $usuario['apellidos'];
            $_SESSION['correo'] = $usuario['correo'];
            //Redirigir a la página privada con un mensaje de éxito
            header("Location: perfil.php?login=ok");
            exit();
        //Si la clave es incorrecta, se presenta mensaje de error    
        } else {
            header("Location: index.php?error_login=clave");
            exit();
        }
    //Si el correo es incorrecto, se presenta mensaje de error
    } else {
        header("Location: index.php?error_login=correo");
        exit();
    }
    //Cerrar conexiones
    $stmt -> close();
    $conexion -> close();
?>