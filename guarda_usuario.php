<?php
    //Conexión a la base de datos
    require_once ("conexion.php");

    //Validación de datos recibidos del formulario
    //htmlspecialchars previene XSS, trin elimina espacios en blanco innecesarios
    $nombres = htmlspecialchars(trim($_POST['nombres']));
    $apellidos = htmlspecialchars(trim($_POST['apellidos']));
    $cedula = htmlspecialchars(trim($_POST['cedula']));
    //filter_var limpia el correo de caracteres no válidos
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $clave_plana = $_POST['clave']; //Contraseña recibida del formulario
    $confirmar_clave = $_POST['confirmar_clave']; //Confirmación de contraseña recibida del formulario

    //Validar que las dos contraseñas coincidan
    if($clave_plana !== $confirmar_clave) {
        //Redirigir al formulario de registro con un mensaje de error
        header("Location: registro_usuario.php?error=claves_no_coinciden");
        exit();
    }

    //Hasheo de la contraseña
    //password_default para la mejor protección actual
    $clave_hashed = password_hash($clave_plana, PASSWORD_DEFAULT);
    
    //Verificar si el correo ya existe
    $verificar_correo = $conexion -> prepare("SELECT cedula FROM usuarios_filora WHERE correo = ?");
    $verificar_correo -> bind_param("s", $correo);
    $verificar_correo -> execute();
    $verificar_correo -> store_result();

    if ($verificar_correo -> num_rows > 0) {
        //Mostrar el mensaje de error por precaución
        header("Location: registro_usuario.php?error=correo_existente");
        exit();
    //Si el correo no existe, proceder a registrar el nuevo usuario
    } else {
        //Insertar el nuevo usuario en la base de datos con la contraseña hasheada
        $stmt = $conexion -> prepare("INSERT INTO usuarios_filora (cedula, nombres, apellidos, correo, contraseña) VALUES (?, ?, ?, ?, ?)");
        //Usar las variable hasheada en lugar de la contraseña plana
        $stmt -> bind_param("issss", $cedula, $nombres, $apellidos, $correo, $clave_hashed);

        if($stmt -> execute()) {
            //Redirigir al inicio de sesión con un mensaje de éxito
            header("Location: index.php?registro=ok");
            exit();
        } else {
            //Redirigir al formulario de registro
            header("Location: registro_usuario.php?error=registro_fallido");
            exit();
        }
        $stmt -> close(); 
    }
    //Cerrar conexiones
    $verificar_correo -> close();
    $conexion -> close();
?>