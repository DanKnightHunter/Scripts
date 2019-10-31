<?php

    function conectarBD()  {
        $host = "host=192.168.75.130";
        //$host = "host=localhost";
        $port = "port=5454";
        $dbname = "dbname=postgres";
        //$dbname = "dbname=Incubadora";
        $user = "user=postgres";
        $password = "password=root";
        
        $bd = pg_connect("$host $port $dbname $user $password");
        if(!$bd)    {
            echo "Error al conectar: ".pg_last_error();
        }
        else    {
            return $bd;
        }
    }


?>