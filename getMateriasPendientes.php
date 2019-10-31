
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

    $query = "select materia.idMateria, materia.nombre, materia.clave from alumno
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

    $query = "select materia.idMateria, materia.nombre, materia.clave from alumno
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
    $query = "select materia.idMateria, materia.nombre, materia.clave from alumno
                INNER JOIN carrera ON alumno.idCarrera = carrera.idCarrera
                INNER JOIN carreras_materias ON carreras_materias.idCarrera = carrera.idCarrera
                INNER JOIN materia ON carreras_materias.idMateria = materia.idMateria
                WHERE alumno.valido=true"." AND alumno.idAlumno=".$id.
                " ORDER BY materia.nombre;";
    $query_exec = mysqli_query($conexion, $query);
    //$salida = array("dato" => "a", "nombre" => "Andres");
    if(mysqli_num_rows($query_exec)){
        while($row=mysqli_fetch_assoc($query_exec)){
            $flag = true;
            foreach( $arrayPrincipal3 as $mat)  {
                if($row == $mat) {
                    $flag = false;
                }
            }
            foreach( $arrayPrincipal4 as $mat)  {
                if($row == $mat) {
                    $flag = false;
                }
            }
            
            if($flag)   {
                array_push($arrayPrincipal2, $row);
            }
            
        }
    }

    $arrayPrincipal = array(
        "Materia" => $arrayPrincipal2,
    );


    echo json_encode($arrayPrincipal, JSON_PRETTY_PRINT);
    //echo var_dump($arrayPrincipal['huevo']['movil'][0]['idHuevo']);

    ?>       
