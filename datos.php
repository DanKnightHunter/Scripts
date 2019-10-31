<?php

require_once ("conexionMovil.php");
$conexion = conectar();

require("simplehtmldom/simple_html_dom.php");

$nombreCarrera = 'ING EN COMPUTACION';
$codigoCarrera = 'INCO';

$arr[] = array();
$prof[] = array();
$mat[] = array();

$i = 0;

    function existeDato($a, $d)  {
        foreach($a as $act) {
            if($act != null)    {
                if (strcmp($act[0], $d) == 0) {
                    //echo $act[0].' _ '.$d;
                    return true;
                }
            }
        }
        return false;
    }

    function returnId($a, $d)  {
        foreach($a as $act) {
            if($act != null)    {
                if (strcmp($act[0], $d) == 0) {
                    return $act[1];
                }
            }
        }
        return false;
    }


while($i != 2)  {
    $url="Consulta de Oferta Academica.html"; 
    if($i != 0) {
        $url="Consulta de Oferta Academica2.html"; 
    }
    $html=file_get_contents($url); 
    $dom = new domDocument; 
    /*** load the html into the object ***/ 
    $dom->loadHTML($html); 
    /*** discard white space ***/ 
    $dom->preserveWhiteSpace = false; 
    /*** the table by its tag name ***/ 
    $tables = $dom->getElementsByTagName('table'); 
    /*** get all rows from the table ***/ 
    $rows = $tables->item(0)->getElementsByTagName('tr'); 
    $actual = '';
    $nuevo = '';
    /*** loop over the table rows ***/ 
    foreach ($rows as $row) 
    { 
        /*** get each column by tag name ***/ 
        $cols = $row->getElementsByTagName('td'); 
        /*** echo the values ***/ 
        $actual = $cols->item(0)->nodeValue;
        if ($cols->item(0)->nodeValue == '01' || $cols->item(0) == 'NULL' || strlen($cols->item(16)->nodeValue) == 11 )   {
            
        }
        else    {
            $var1 = $cols->item(0)->nodeValue; 
            #echo $cols->item(0)->nodeValue;
            $var2 = $cols->item(1)->nodeValue; 
            $var3 = $cols->item(2)->nodeValue; 
            $var4 = $cols->item(3)->nodeValue;
            $var5 = $cols->item(4)->nodeValue;
            $var6 = $cols->item(5)->nodeValue;
            $var7 = $cols->item(6)->nodeValue;
            //echo $cols->item(7)->nodeValue.' , ';
            $var8 = $cols->item(8)->nodeValue;
            $var9= $cols->item(9)->nodeValue;
            $var10 = $cols->item(10)->nodeValue;
            $var11 = $cols->item(11)->nodeValue;

            $var12 = $cols->item(12)->nodeValue;
            $var13 = $cols->item(13)->nodeValue;
            //echo $cols->item(14)->nodeValue.' , ';
            $var14 = $cols->item(15)->nodeValue;
            $var15 = $cols->item(16)->nodeValue; 

            //echo $cols->item(17)->nodeValue.' , ';
            //echo $cols->item(18)->nodeValue.' , ';
            //$j = $cols->item(0)->nodeValue;
            $nuevo = $cols->item(0)->nodeValue;
        }
        
        /*echo $cols->item(1)->nodeValue.' , '; 
        echo $cols->item(2)->nodeValue.' , '; 
        echo $cols->item(3)->nodeValue.' , ';
        echo $cols->item(4)->nodeValue.' , ';
        echo $cols->item(5)->nodeValue.' , ';
        echo $cols->item(6)->nodeValue.' , ';
        //echo $cols->item(7)->nodeValue.' , ';
        echo $cols->item(8)->nodeValue.' , ';
        echo $cols->item(9)->nodeValue.' , ';
        echo $cols->item(10)->nodeValue.' , ';
        echo $cols->item(11)->nodeValue.' , ';
        
        echo $cols->item(12)->nodeValue.' , ';
        echo $cols->item(13)->nodeValue.' , ';
        //echo $cols->item(14)->nodeValue.' , ';
        echo $cols->item(15)->nodeValue.' , ';
        echo $cols->item(16)->nodeValue; 
        
        echo $cols->item(17)->nodeValue.' , ';
        echo $cols->item(18)->nodeValue.' , ';
        //echo $cols->item(19)->nodeValue.' , ';
        
        */
        //$arr[] = $var1;
        
        //echo '          actual '. $actual . " _ nuevo " . $nuevo;
        
        if ( $actual == $nuevo )
            $arr[] = array($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var10, $var11, $var12, $var13, $var14, $var15);
        
        
        
        //echo $cols->item(5)->nodeValue.'<br />'; 
        //echo $cols->item(6)->nodeValue.'<br />'; 
        //echo $cols->item(7)->nodeValue.'<br />'; 
        //echo $cols->item(8)->nodeValue.'<br />'; 
        //echo $cols->item(9)->nodeValue.'<br />'; 
        //echo $cols->item(10)->nodeValue.'<br />'; 
        //echo '<br />'; 
    } 
    $i++;
    
}

for ($i = 0; $i < 10; $i++) {
    echo '<br />'; 
    echo '<br />'; 
    echo '<br />'; 

    var_dump($arr[$i]);
}


ini_set('max_execution_time', 300);

$query_search = "INSERT INTO carrera (nombre, codigo, valido) VALUES ('".$nombreCarrera."', '".$codigoCarrera."', true)";
$query_exec = mysqli_query($conexion, $query_search);
$idCarrera = mysqli_insert_id( $conexion ); // Ultimo id de la carrera creada

foreach ($arr as $dato) {
    if(count($dato) > 1 && $dato[14] != NULL)    {
        
        if(existeDato($prof, $dato[14]))    {
            // Profesor
            $idProfesor = returnId($prof, $dato[14]); // Ultimo id del profesor creado
            
            if( existeDato($mat, $dato[2]) )    {
                $idMateria = returnId($mat, $dato[2]); // Ultimo id del profesor creado
            }else   {
                // Materia
                $query_search = "INSERT INTO materia (nombre, clave, valido) VALUES ('".$dato[2]."', '".$dato[1]."', true)";
                $query_exec = mysqli_query($conexion, $query_search);
                $idMateria = mysqli_insert_id( $conexion ); // Ultimo id de la materia creada
                
                // Materias de las Carreras
                $query_search = "INSERT INTO carreras_materias (idCarrera, idMateria, valido) VALUES ('".$idCarrera."', '".$idMateria."', true)";
                $query_exec = mysqli_query($conexion, $query_search);

                //echo $query_search;
                //echo '<br>';

                $mat[] = array($dato[2], $idMateria);
            }

            /*
            // Materia
            $query_search = "INSERT INTO materia (nombre, clave, valido) VALUES ('".$dato[2]."', '".$dato[1]."', true)";
            $query_exec = mysqli_query($conexion, $query_search);
            $idMateria = mysqli_insert_id( $conexion ); // Ultimo id de la materia creada*/

            // Seccion 
            $query_search = "INSERT INTO seccion (idProfesor, idMateria, numeroSeccion, cupo, edificio, aula, valido) VALUES ('".$idProfesor."', '".$idMateria."', '".$dato[3]."', '".$dato[5]."', '".$dato[10]."', '".$dato[11]."', true)";
            $query_exec = mysqli_query($conexion, $query_search);
            $idSeccion = mysqli_insert_id( $conexion ); // Ultimo id de la seccion creada

            $horas = explode('-', $dato[8]); // Separa las horas de inicio y de fin 0700 - 0900
            $dias = explode(' ', $dato[9]); // Separa los dias que tienen clases L . I . . .

            foreach ($dias as $dia) { // Recorer el arreglo de dias son 6 posibles de lunes a sabado
                if($dia != '.') { // Validar los dias que hay clases si hay un punto no hay clases ese dia
                    $query_search = "INSERT INTO horario_seccion (idSeccion, horaInicio, horaFin, dia, valido) VALUES ('".$idSeccion."', '".$horas[0]."', '".$horas[1]."', '".$dia."', true)";
                    $query_exec = mysqli_query($conexion, $query_search);
                }
            }
            
        }
        else    {
            
            // Profesor
            $nombre = explode(',', $dato[14]); // Separa el nombre y los apellodos nombre, apeP apeM
            $apellidos = explode(' ', $nombre[0]); // Separa los apellidos por patern y materno

            $query_search = "INSERT INTO profesor (nombre, apellidoPaterno, apellidoMaterno, valido) VALUES ('".$nombre[1]."', '".$apellidos[0]."', '".$apellidos[1]."', true)";

            //echo $query_search;
            //echo '<br>';

            $query_exec = mysqli_query($conexion, $query_search);
            $idProfesor = mysqli_insert_id( $conexion ); // Ultimo id del profesor creado

            $prof[] = array($dato[14], $idProfesor);

            if( existeDato($mat, $dato[2]) )    {
                $idMateria = returnId($mat, $dato[2]); // Ultimo id del profesor creado
            }else   {
                // Materia
                $query_search = "INSERT INTO materia (nombre, clave, valido) VALUES ('".$dato[2]."', '".$dato[1]."', true)";
                $query_exec = mysqli_query($conexion, $query_search);
                $idMateria = mysqli_insert_id( $conexion ); // Ultimo id de la materia creada
                
                // Materias de las Carreras
                $query_search = "INSERT INTO carreras_materias (idCarrera, idMateria, valido) VALUES ('".$idCarrera."', '".$idMateria."', true)";
                $query_exec = mysqli_query($conexion, $query_search);

                //echo $query_search;
                //echo '<br>';

                $mat[] = array($dato[2], $idMateria);
            }

            // Seccion 
            $query_search = "INSERT INTO seccion (idProfesor, idMateria, numeroSeccion, cupo, edificio, aula, valido) VALUES ('".$idProfesor."', '".$idMateria."', '".$dato[3]."', '".$dato[5]."', '".$dato[10]."', '".$dato[11]."', true)";
            $query_exec = mysqli_query($conexion, $query_search);
            $idSeccion = mysqli_insert_id( $conexion ); // Ultimo id de la seccion creada

            $horas = explode('-', $dato[8]); // Separa las horas de inicio y de fin 0700 - 0900
            $dias = explode(' ', $dato[9]); // Separa los dias que tienen clases L . I . . .

            foreach ($dias as $dia) { // Recorer el arreglo de dias son 6 posibles de lunes a sabado
                if($dia != '.') { // Validar los dias que hay clases si hay un punto no hay clases ese dia
                    $query_search = "INSERT INTO horario_seccion (idSeccion, horaInicio, horaFin, dia, valido) VALUES ('".$idSeccion."', '".$horas[0]."', '".$horas[1]."', '".$dia."', true)";
                    $query_exec = mysqli_query($conexion, $query_search);
                }
            }
            
        }
        
        
    }
}


for ($i = 0; $i < 50; $i++) {
    echo '<br />'; 
    echo $i; 
    echo '<br />'; 

    var_dump($prof[$i]);
}

//$query_search = "INSERT INTO horario_seccion (horaInicio, horaFin, dia, valido) VALUES ('".$arr[3][2]."', '".$arr[3][1]."', true)";
//$query_exec = mysqli_query($conexion, $query_search);


//INSERT INTO horario_seccion (horaInicio, horaFin, dia, valido) VALUES (0070, 0070, 'Lunes', true);

//INSERT INTO seccion (idProfesor, idMateria, numeroSeccion, cupo, edificio, aula, valido) VALUES (1, 1, 'D01', 30, 'DEDX', 'A001', true);

?>