<?php
    require_once('conexion/class_db.php');
    require_once('class_resp.php');

    #HEREDAMOS CLASE CONEXION
    #Cuando heredamos podemos utilizar todos los metodos a excepcion de los privados
    class auth extends class_db{

        //recibe postbody para verificar si se introducen los datos correctos
        public function login($json){

            $_respuestas = new Respuestas;
            //convertir json a array
            $datos = json_decode($json, true);
            //Si no existe campo usuario o campo password lanza error
            if(!isset($datos['usuario'])|| !isset($datos["password"])){
                //error con los campos 
                return $_respuestas->error_400();
            }
            //todo esta bien
            $usuario = $datos['usuario'];
            $password = $datos["password"]; //password que nos envia el usuario
            $password = parent::encriptar($password); // --> encriptamos password para almacenar en la bd

            $datos = $this->getDatosUsuario($usuario);//SI LOS DATOS EXISTEN SE ALMACENAN AQUI 
           
            if($datos){
                //verificar si la contraseña es igual 
                if($password == $datos[0]['Password']){
                    if($datos[0]['Estado'] == 'Activo'){
                        //crear token
                        $verificar = $this->insertToken($datos[0]['UsuarioId']);
                        if($verificar){
                            //se guardo token
                            $result = $_respuestas->response;
                            //modificamos 
                            $result["result"] = array(
                                #en verificar obtenemos el token generado en la funcion 
                                "token" => $verificar 
                            );
                            return $result;
                        }else{
                            //no se guardo token
                            return $_respuestas->error_500("Error interno - no se puede almacenar token");
                        }
                    }else{
                        //usuario inactivo
                        return $_respuestas->error_200("Usuario Inactivo");
                    }
                }else{
                    //las contraseñas no coinciden
                    return $_respuestas->error_200("Password incorrecto");
                }

            }else{
                //si no existe el usuario retorna un error
                return $_respuestas->error_200("El usuario $usuario no existe");
            }
        }

        private function getDatosUsuario($correo){
            $query = "SELECT UsuarioId, Password, Estado FROM usuarios WHERE Usuario = '$correo'";
            $datos = parent :: getData($query);
            if(isset($datos[0]['UsuarioId'])){
                return $datos;
            }else{
                return 0;
            }

        }

        private function insertToken($usuarioid){
            //utilizamos funcion bin2hex --- nos regresa una cadena string hexadecimal 
            //utilizamos openssl_random_pseudo_bytes nos genera cadena de bytes pseudoaleatoria
            //utilizamos las 2 para generar un token unico para cada usuario 
            $val = true;
            $token = bin2hex(openssl_random_pseudo_bytes(16, $val)); #(16 caracteres)
            $date = date("Y-m-d H:i");
            $estado = "Activo";
            #$query = "INSERT INTO usuarios_token (UsuarioId,Token,Estado,Fecha) VALUES ('$usuarioid', '$token', '$estado', '$date')";
            $query = "INSERT INTO usuarios_token (UsuarioId,Token,Estado,Fecha)VALUES('$usuarioid','$token','$estado','$date')";
            $verifica = parent::nonQuery($query);
            if($verifica){
                #return "test";
                return $token;
            }else{
                return 0;
            }
        }

    }//end class
?>