
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
    //$codigo = $_POST['codigo'];
    $codigo = $_GET['codigo'];
    //$nip = $_POST['nip'];
    $nip = $_GET['nip'];

    $arrayPrincipal = [];
    $arrayPrincipal2 = [];
    $valido = false;


    $query = "select * from alumno WHERE alumno.valido=true"." AND alumno.codigo=".$codigo." AND alumno.nip=".$nip." ORDER BY alumno.idAlumno;";
    $query_exec = mysqli_query($conexion, $query);
    //$salida = array("dato" => "a", "nombre" => "Andres");
    if(mysqli_num_rows($query_exec)){
        while($row=mysqli_fetch_assoc($query_exec)){
            //array_push($arrayPrincipal2, $row);
            $valido = true;
        }
    }


    /*$arrayPrincipal = array(
        "Alumno" => $arrayPrincipal2,
    );*/

    //echo json_encode($arrayPrincipal, JSON_PRETTY_PRINT);
    echo json_encode($valido, JSON_PRETTY_PRINT);
    

    ?>       
