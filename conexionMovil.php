<?php

    function conectar()  {
        $hostname_localhost ="localhost";        
        $database_localhost ="horario";
        $username_localhost ="root";
        $password_localhost ="password";
        
        $bd = mysqli_connect($hostname_localhost, $username_localhost, $password_localhost, $database_localhost);
        if(!$bd)    {
            echo "Error al conectar: ".mysql_error();
        }
        else    {
            echo "conexion exitosa";
            return $bd;
        }
    }

?>