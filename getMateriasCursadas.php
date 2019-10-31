
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


    //$query = "select * from alumno WHERE alumno.valido=true"." AND alumno.idAlumno=".$id." ORDER BY alumno.idAlumno;";
    $query = "select materia.idMateria, materia.nombre AS mNombre, materia.clave, seccion.numeroSeccion, seccion.edificio,
                seccion.aula, profesor.nombre, profesor.apellidoPaterno, profesor.apellidoMaterno, seccion.idSeccion from alumno
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
            //array_push($arrayPrincipal2, $row);
            
            $query2 = "select idHorarioSeccion, horaInicio, horaFin, dia from seccion
                INNER JOIN horario_seccion ON horario_seccion.idSeccion = seccion.idSeccion
                WHERE seccion.idSeccion=".$row['idSeccion'].
                " ORDER BY seccion.idSeccion;";
            $query_exec2 = mysqli_query($conexion, $query2);
            //$salida = array("dato" => "a", "nombre" => "Andres");
            
            $arrayPrincipal3 = [];
            
            if(mysqli_num_rows($query_exec2)){
                while($row2=mysqli_fetch_assoc($query_exec2)){
                    array_push($arrayPrincipal3, $row2);
                }
            }
            $row["Hora"] = $arrayPrincipal3;
            array_push($arrayPrincipal2, $row);
        }
    }

    $arrayPrincipal = array(
        "Materia" => $arrayPrincipal2,
    );

    echo json_encode($arrayPrincipal, JSON_PRETTY_PRINT);
    //echo var_dump($arrayPrincipal['huevo']['movil'][0]['idHuevo']);

    ?>       
