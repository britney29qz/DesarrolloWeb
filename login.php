<?php

//Iniciar sesión para manejar el estado de autenticación
session_start();
//Conexión a la base de datos
require_once ("conexion.php");

//Recepción de datos
$correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
$clave = $_POST['clave'];

//Buscar usuario
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
        //Redirigir a la página de principal
        header("Location: perfil.php");
        exit();
    } else {
        echo "Contraseña incorrecta. Por favor, intenta nuevamente.";
    }
} else {
    echo "Correo no registrado. Por favor, verifica tus datos o regístrate.";
}

$stmt -> close();
$conexion -> close();

?>