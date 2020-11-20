<?php
    include_once("class/class_resp.php");
    include_once("class/class_pacientes.php");

    $_respuestas =  new Respuestas();
    $_pacientes = new Pacientes();
    
    if($_SERVER['REQUEST_METHOD'] == "GET"){

        if(isset($_GET["page"])){
            $pagina = $_GET["page"];
            $listaPacientes = $_pacientes->listaPacientes($pagina);
            header("Content-Type: application/json");
            echo json_encode($listaPacientes);
            http_response_code(200);
        }else if(isset($_GET['id'])){
            $pacienteid = $_GET['id'];
            $datosPaciente = $_pacientes->obtenerPaciente($pacienteid);
            header("Content-Type: application/json");
            echo json_encode($datosPaciente);
            http_response_code(200);
        }
        
    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        //recibimos los datos enviados
        $postBody = file_get_contents("php://input");
        //enviamos los datos al manejador
        $datosArray = $_pacientes->post($postBody);
        #print_r($datosArray);
        //delvovemos una respuesta 
         header('Content-Type: application/json');
         if(isset($datosArray["result"]["error_id"])){
             $responseCode = $datosArray["result"]["error_id"];
             http_response_code($responseCode);
         }else{
             http_response_code(200);
         }
         echo json_encode($datosArray);
        
    }else if($_SERVER['REQUEST_METHOD'] == "PUT"){
        
        //recibimos los datos enviados
        $postBody = file_get_contents("php://input");
        //enviamos datos al manejador
        $datosArray = $_pacientes->put($postBody);
        //delvovemos una respuesta 
        header('Content-Type: application/json');
        if(isset($datosArray["result"]["error_id"])){
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        }
        echo json_encode($datosArray);
    
    }else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
       $postBody = file_get_contents("php://input");
        $datosArray = $_pacientes->delete($postBody);
         //delvovemos una respuesta 
        header('Content-Type: application/json');
        if(isset($datosArray["result"]["error_id"])){
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        }
         echo json_encode($datosArray);
    
      /*  $headers = getallheaders();
        if(isset($headers['token']) && isset($headers['pacienteId'])){

            $send = [
                "token" => $headers['token'],
                "pacienteId" => $headers['pacienteId']
            ];
             $postBody = json_encode($send);
        }else{
             $postBody = file_get_contents("php://input");
        }
    
        //enviamos datos al manejador
        $datosArray = $_pacientes->delete($postBody);
        //delvovemos una respuesta 
           header('Content-Type: application/json');
           if(isset($datosArray["result"]["error_id"])){
                echo json_encode($datosArray);  $responseCode = $datosArray["result"]["error_id"];
                http_response_code($responseCode);
           }else{
                http_response_code(200);
           }*/
    
    }
    else{
        header('Content-Type: application/json');
        $datosArray = $_respuestas->error_405();
        echo json_encode($datosArray);
    }


    /*   


                        ------------------TEST GET (select pacientes) ----------------
                        http://localhost/API/pacientes?page=1

                    {
                        "PacienteId": "1",
                        "Nombre": "Juan Carlos Medina",
                        "DNI": "A000000001",
                        "Telefono": "633281515",
                        "Correo": "Paciente1@gmail.com"
                    }
                    
                        -----------------TEST POST Auth  ---------------------------------
                            Busca si el usuario existe en tabla usuarios
                            *Se agrega un token nuevo para el usuario en tabla usuarios_token
                            http://localhost/API/auth.php
                    {
                        "usuario" : "usuario1@gmail.com",
                        "password" : "123456"
                    }
                        *Test usuario incorrecto
                        *Test password incorrecto
                        *utilizando un usuario inactivo buscar en tabla usuarios
                    {"status":"error","result":{"error_id":"200","error_msg":"Usuario Inactivo"}}

                        -----------------TEST POST (Insertar Paciente) --------------
                        http://localhost/API/pacientes?page=1
                    {
                        "direccion" : "Perez Treviño 245",
                        "dni"  :"012345ACBD",
                        "nombre" : "Geenesis Sanchez",
                        "correo" : "jaleman@gmail.com",
                        "genero" : "F",
                        "fechaNacimiento" : "2014-10-05",
                        "codigoPostal" : "25000",
                        "telefono" : "844128712"
                    }
                        -----------------TEST PUT (Modificar paciente) -------------------
                        http://localhost/API/pacientes?page=1

                    {
                        "pacienteId" : "6",
                        "direccion" : "Bellavista 201",
                        "dni"  :"ad0000asdas",
                        "nombre" : "Geenesis Piggy",
                        "correo" : "jaleman@gmail.com",
                        "genero" : "F",
                        "fechaNacimiento" : "2014-10-05",
                        "codigoPostal" : "25000",
                        "telefono" : "844128712"
                    }


                    //full app working
                    1. Crear token nuevo  auth.php
                    2. Agregar paciente utilizando el token creado pacientes.php
                        {
                            "correo" : "jaleman@gmail.com",
                            "dni"  :"012345ACBD",
                            "nombre" : "Geenesis Sanchez",
                            "token" : "3799168467792920daefa160a93515af"
                        }
                    3. Actualizar paciente ingresado -- Cambiar un campo
                    {
                            "pacienteId":"21",
                            "correo" : "jaleman@gmail.com",
                            "dni"  :"012345ACBD",
                            "nombre" : "Geenesis Sanchez",
                            "token" : "3799168467792920daefa160a93515af"
                    }
                    4. 


    */ 
?>