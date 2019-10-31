<?php


    function conectar()  {
        $hostname_localhost ="167.71.150.242";        
        $database_localhost ="horario";
        $username_localhost ="root";
        $password_localhost ="password";
        
        $bd = mysqli_connect($hostname_localhost, $username_localhost, $password_localhost, $database_localhost);
        if(!$bd)    {
            echo "Error al conectar: ";
        }
        else    {
            echo "conexion exitosa";
            return $bd;
        }
    }

?>
