<?php
    //Inicio de sesión si ya se autenticó
    session_start();

    if (!isset($_SESSION['usuario'])) {
        //Redirigir a la página de inicio de sesión si no está autenticado
        header("Location: index.html");
        exit();
    }

?>

<h1>
    Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>, a tu panel de control.
</h1>