<?php
    //Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "filora_acdb1");
    if ($conexion -> connect_error) {
        die("Error de conexión a la base de datos"); //Mostrar mensaje de error en caso de que no se logre la conexión
    }
?>