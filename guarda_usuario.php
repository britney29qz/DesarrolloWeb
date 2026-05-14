<?php
    //Conexión
    require_once ("conexion.php");

    //Validación de datos recibidos del formulario
    //htmlspecialchars previene XSS, trin elimina espacios en blanco innecesarios
    $nombres = htmlspecialchars(trim($_POST['nombres']));
    $apellidos = htmlspecialchars(trim($_POST['apellidos']));
    $cedula = htmlspecialchars(trim($_POST['cedula']));
    //filter_var limpia el correo de caracteres no válidos
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $clave_plana = $_POST['clave']; //Contraseña recibida del formulario

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
        echo "<p style='color:red; text-align:center;'>" . htmlspecialchars("El correo ya está registrado. Por favor, utiliza otro.") . "</p>";
    } else {
        //Insertar el nuevo usuario en la base de datos con la contraseña hasheada
        $stmt = $conexion -> prepare("INSERT INTO usuarios_filora (cedula, nombres, apellidos, correo, contraseña) VALUES (?, ?, ?, ?, ?)");
        //Usar las variable hasheada en lugar de la contraseña plana
        $stmt -> bind_param("issss", $cedula, $nombres, $apellidos, $correo, $clave_hashed);

        if($stmt -> execute()) {
            echo "<p style='color:green; text-align:center;'>" . htmlspecialchars("Usuario registrado exitosamente.") . "</p>";
            echo "<p style='text-align:center;'><a href='listar_usuarios.php'>Ver lista de usuarios</a></p>";
        } else {
            echo "<p style='text-align:center; color:red;'>" . htmlspecialchars("Error al registrar el usuario. Por favor, intenta nuevamente.") . "</p>";
        }
        $stmt -> close();
    }
    $verificar_correo -> close();
    $conexion -> close();
?>