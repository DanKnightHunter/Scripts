
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

    //$id = $_GET['id'];
    $id = $_POST['id'];

    $arrayPrincipal = [];
    $arrayPrincipal2 = [];


    $query = "select * from alumno WHERE alumno.valido=true"." AND alumno.idAlumno=".$id." ORDER BY alumno.idAlumno;";
    $query_exec = mysqli_query($conexion, $query);
    //$salida = array("dato" => "a", "nombre" => "Andres");
    if(mysqli_num_rows($query_exec)){
        while($row=mysqli_fetch_assoc($query_exec)){
            array_push($arrayPrincipal2, $row);
            //$huevo['huevo'][]=$row;
        }
    }


    $arrayPrincipal = array(
        "Alumno" => $arrayPrincipal2,
    );

    echo json_encode($arrayPrincipal, JSON_PRETTY_PRINT);
    //echo var_dump($arrayPrincipal['huevo']['movil'][0]['idHuevo']);

    ?>       
