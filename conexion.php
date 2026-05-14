<?php
    //Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "filora_acdb1");
    if ($conexion -> connect_error) {
        die("Error de conexión a la base de datos");
    }

?>