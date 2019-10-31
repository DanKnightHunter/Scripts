
    <?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    header('Content-Type: application/json');
    //require_once ("conexion.php");
    //$conexion = conectarBD();

    require_once ("conexionMovil.php");
    $conexion = conectar();

    //$usuario = $_GET['user'];
    //$contrasena = $_GET['pass'];

    $id = $_GET['id'];

    //$id = $_POST['id'];

    $arrayPrincipal = [];
    $arrayPrincipal2 = [];
    $arrayPrincipal3 = [];
    $arrayPrincipal4 = [];


    // Materias actuales

    $query = "select materia.idMateria from alumno
                INNER JOIN secciones_alumnos ON alumno.idAlumno = secciones_alumnos.idAlumno
                INNER JOIN seccion ON secciones_alumnos.idSeccion = seccion.idSeccion
                INNER JOIN materia ON materia.idMateria = seccion.idMateria
                INNER JOIN profesor ON profesor.idProfesor = seccion.idProfesor
                WHERE alumno.valido=true"." AND alumno.idAlumno=".$id.
                " ORDER BY alumno.idAlumno;";
    $query_exec = mysqli_query($conexion, $query);
    //$salida = array("dato" => "a", "nombre" => "Andres");
    if(mysqli_num_rows($query_exec)){
        while($row=mysqli_fetch_assoc($query_exec)){
            array_push($arrayPrincipal3, $row);
            
        }
    }

    // Materias cursadas

    $query = "select materia.idMateria from alumno
                INNER JOIN materias_cursadas ON alumno.idAlumno = materias_cursadas.idAlumno
                INNER JOIN seccion ON materias_cursadas.idSeccion = seccion.idSeccion
                INNER JOIN materia ON materia.idMateria = seccion.idMateria
                INNER JOIN profesor ON profesor.idProfesor = seccion.idProfesor
                WHERE alumno.valido=true"." AND alumno.idAlumno=".$id.
                " ORDER BY alumno.idAlumno;";
    $query_exec = mysqli_query($conexion, $query);
    //$salida = array("dato" => "a", "nombre" => "Andres");
    if(mysqli_num_rows($query_exec)){
        while($row=mysqli_fetch_assoc($query_exec)){
            array_push($arrayPrincipal4, $row);
            
        }
    }


    // Todas las materias
    //$query = "select * from alumno WHERE alumno.valido=true"." AND alumno.idAlumno=".$id." ORDER BY alumno.idAlumno;";
    $query = "select materia.idMateria, materia.nombre AS mNombre, materia.clave, seccion.numeroSeccion, seccion.edificio,
                seccion.aula, profesor.nombre, profesor.apellidoPaterno, profesor.apellidoMaterno, seccion.idSeccion from alumno
                INNER JOIN carrera ON alumno.idCarrera = carrera.idCarrera
                INNER JOIN carreras_materias ON carreras_materias.idCarrera = carrera.idCarrera
                INNER JOIN materia ON carreras_materias.idMateria = materia.idMateria
                INNER JOIN seccion ON materia.idMateria = seccion.idMateria
                INNER JOIN profesor ON profesor.idProfesor = seccion.idProfesor
                WHERE alumno.valido=true"." AND alumno.idAlumno=".$id.
                " ORDER BY materia.nombre;";
    $query_exec = mysqli_query($conexion, $query);
    //$salida = array("dato" => "a", "nombre" => "Andres");
    if(mysqli_num_rows($query_exec)){
        while($row=mysqli_fetch_assoc($query_exec)){
            $flag = true;
            foreach( $arrayPrincipal3 as $mat)  {
                if($row['idMateria'] == $mat['idMateria'] ) {
                    $flag = false;
                }
            }
            foreach( $arrayPrincipal4 as $mat)  {
                if($row['idMateria'] == $mat['idMateria'] ) {
                    $flag = false;
                }
            }
            
            if($flag)   {
                //array_push($arrayPrincipal2, $row);
                
                $query2 = "select idHorarioSeccion, horaInicio, horaFin, dia from seccion
                    INNER JOIN horario_seccion ON horario_seccion.idSeccion = seccion.idSeccion
                    WHERE seccion.idSeccion=".$row['idSeccion'].
                    " ORDER BY seccion.idSeccion;";
                $query_exec2 = mysqli_query($conexion, $query2);
                //$salida = array("dato" => "a", "nombre" => "Andres");

                $arrayPrincipal5 = [];

                if(mysqli_num_rows($query_exec2)){
                    while($row2=mysqli_fetch_assoc($query_exec2)){
                        array_push($arrayPrincipal5, $row2);
                    }
                }
                
                $row["Hora"] = $arrayPrincipal5;
                array_push($arrayPrincipal2, $row);
                
            }
            
            
            
        }
    }

        /*
    materia.idMateria, materia.nombre AS mNombre, materia.clave, seccion.numeroSeccion, seccion.edificio,
                seccion.aula, profesor.nombre, profesor.apellidoPaterno, profesor.apellidoMaterno, seccion.idSeccion 
    
    INNER JOIN secciones_alumnos ON alumno.idAlumno = secciones_alumnos.idAlumno
                INNER JOIN seccion ON secciones_alumnos.idSeccion = seccion.idSeccion
                INNER JOIN materia ON materia.idMateria = seccion.idMateria
                INNER JOIN profesor ON profesor.idProfesor = seccion.idProfesor*/

    $arrayPrincipal = array(
        "Materia" => $arrayPrincipal2,
    );


    echo json_encode($arrayPrincipal, JSON_PRETTY_PRINT);
    //echo var_dump($arrayPrincipal['huevo']['movil'][0]['idHuevo']);

    ?>       
