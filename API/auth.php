<?php   
    require_once('class/class_auth.php');
    require_once('class/class_resp.php');

    // $_auth = new auth; -- > creamos nuestros objetos
    $_auth = new auth;
    $_respuestas = new Respuestas;


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        #echo 'test';
        //RECEPCION DE DATOS
        $postBody = file_get_contents('php://input');
        //ENVIAMOS DATOS AL MANEJADOR
        $datosArray = $_auth->login($postBody); // respuesta
        //DEVOLVEMOS RESPUESTA
        header("Content-Type: application/json");
        if(isset($datosArray["result"]["error_id"])){
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        }

        echo(json_encode($datosArray));
    }else{
        header("Content-Type: application/json");
        $datosArray = $_respuestas->error_405();
        echo json_encode($datosArray);
    }
?>