<?php
    require_once("conexion/class_db.php");
    require_once("class_resp.php");

    class Pacientes extends class_db{
        //nombre de la tabla en DB
        private $table = "pacientes";
        //Campos de la tabla en DB
        private $pacienteid = "";
        private $dni = "";
        private $nombre = "";
        private $direccion = "";
        private $codigoPostal = "";
        private $genero = "";
        private $telefono = "";
        private $fechaNacimiento = "0000-00-00";
        private $correo = "";
        private $token = "";
        #TOKENS TEST
        //7eb5851ee272897b9cf3699b0bff1e53
        //3799168467792920daefa160a93515af


        //Sirve para mostrar por pagina cierta cantidad de pacientes 
        // para no mostrar todos los registros existentes
        public function listaPacientes($pagina){
            $i = 0; //inicio en el registro 0
            $cantidad = 50; //termina en el registro 100

            if($pagina > 1){
                $i = ($cantidad * ($pagina -1))+1;
                $cantidad = $cantidad * $pagina;
            }
            //query
            $query = "SELECT PacienteId, Nombre, DNI, Telefono, Correo FROM ".$this->table." limit $i, $cantidad";
            $datos = parent::getData($query);
            #print_r($query);
            return $datos;
        }

        //Obtener paciente individual
        public function obtenerPaciente($id){
            $query = "SELECT * FROM ".$this->table." WHERE PacienteId = '$id'";
            #print_r($query);
            return parent::getData($query);
        }

        public function post($json){
            $_respuestas = new Respuestas;
            $datos = json_decode($json, true);

            if(!isset($datos['token'])){
                
                return $_respuestas->error_401();

            }else{
                $this->token=$datos['token'];
                #todos los datos que vienen de la bd se almacenan aqui
                $arrayToken = $this->buscarToken();
                if($arrayToken){
                    //hacemos post - Insertar
                    if(!isset($datos['nombre']) || !isset($datos['dni']) || !isset($datos['correo'])){
                        return $_respuestas->error_400();
                    
                    }else{
                        $this->nombre = $datos['nombre'];
                        $this->dni = $datos['dni'];
                        $this->correo= $datos['correo'];
                        if(isset($datos['telefono'])){$this->telefono = $datos['telefono'];}
                        if(isset($datos['direccion'])){$this->direccion = $datos['direccion'];}
                        if(isset($datos['codigoPostal'])){$this->codigoPostal = $datos['codigoPostal'];}
                        if(isset($datos['genero'])){$this->genero = $datos['genero'];}
                        if(isset($datos['fechaNacimiento'])){$this->fechaNacimiento = $datos['fechaNacimiento'];}
                        $resp = $this->insertarPaciente();
                        if($resp){
                            $respuesta = $_respuestas->response;
                            $respuesta["result"] = array(
                                "pacienteId" => $resp
                            );
                            return $respuesta;
                        }else{
                            return $_respuestas->error_500();
                        }
                    }
                }
                else{
                    //return error
                    return $_respuestas->error_401("Token invalido o caducado");
                }
            }
        }

        private function insertarPaciente(){
            $query = "INSERT INTO " . $this->table . " (DNI,Nombre,Direccion,CodigoPostal,Telefono,Genero,FechaNacimiento,Correo)
            values ('" . $this->dni . "','" . $this->nombre . "','" . $this->direccion ."','" . $this->codigoPostal . "','"  . $this->telefono . "','" . $this->genero . "','" . $this->fechaNacimiento . "','" . $this->correo . "')"; 
            #print_r($query);
            $resp = parent::nonQueryId($query);
            if($resp){
                 return $resp;
            }else{
            return 0;
            }
        }


        public function put($json){

            $_respuestas = new Respuestas;
            $datos = json_decode($json,true);

            if(!isset($datos['token'])){
                return $_respuestas->error_401();
            }else{
                $this->token = $datos['token'];
                $arrayToken =   $this->buscarToken();
                if($arrayToken){
                    //HACEMOS PUT - ACTUALIZAR
                    if(!isset($datos['pacienteId'])){
                        return $_respuestas->error_400();
                    }else{
                        $this->pacienteid = $datos['pacienteId'];
                        if(isset($datos['nombre'])) { $this->nombre = $datos['nombre']; }
                        if(isset($datos['dni'])) { $this->dni = $datos['dni']; }
                        if(isset($datos['correo'])) { $this->correo = $datos['correo']; }
                        if(isset($datos['telefono'])) { $this->telefono = $datos['telefono']; }
                        if(isset($datos['direccion'])) { $this->direccion = $datos['direccion']; }
                        if(isset($datos['codigoPostal'])) { $this->codigoPostal = $datos['codigoPostal']; }
                        if(isset($datos['genero'])) { $this->genero = $datos['genero']; }
                        if(isset($datos['fechaNacimiento'])) { $this->fechaNacimiento = $datos['fechaNacimiento']; }
                    
                        $resp = $this->modificarPaciente();
                        if($resp){
                            $respuesta = $_respuestas->response;
                            $respuesta["result"] = array(
                                "pacienteId" => $this->pacienteid
                            );
                            return $respuesta;
                        }else{
                            return $_respuestas->error_500();
                        }
                    }

                }else{
                    return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
                }
            }
        }
    
        private function modificarPaciente(){
            $query = "UPDATE " . $this->table . " SET Nombre ='" . $this->nombre . "',Direccion = '" . $this->direccion . "', DNI = '" . $this->dni . "', CodigoPostal = '" .
            $this->codigoPostal . "', Telefono = '" . $this->telefono . "', Genero = '" . $this->genero . "', FechaNacimiento = '" . $this->fechaNacimiento . "', Correo = '" . $this->correo .
             "' WHERE PacienteId = '" . $this->pacienteid . "'"; 
            $resp = parent::nonQuery($query);
            if($resp >= 1){
                 return $resp;
            }else{
                return 0;
            }  
        }

        public function delete($json){
            $_respuestas = new Respuestas;
            $datos = json_decode($json, true);

            if(!isset($datos['token'])){
                
                return $_respuestas->error_401();

            }else{
                $this->token=$datos['token'];
                #todos los datos que vienen de la bd se almacenan aqui
                $arrayToken = $this->buscarToken();
                if($arrayToken){
                    //hacemos delete
                    if(!isset($datos['pacienteId'])){
                        return $_respuestas->error_400();
                    }else{
        
                        $this->pacienteid = $datos['pacienteId'];
                        $resp = $this->eliminarPaciente();
                        if($resp){
                            $respuesta = $_respuestas->response;
                            $respuesta["result"] = array(
                                "pacienteId" => $this->pacienteid
                            );
                            return $respuesta;
                        }else{
                            return $_respuestas->error_500();
                        }
                    }
                }
                else{
                    //return error
                    return $_respuestas->error_401("Token invalido o caducado");
                }
            }
        }

        private function eliminarPaciente(){
            $query = "DELETE FROM " . $this->table . " WHERE PacienteId= '" . $this->pacienteid . "'";
            $resp = parent::nonQuery($query);
            if($resp >= 1 ){
                return $resp;
            }else{
                return 0;
            }
        }


        private function buscarToken(){
            $query = "SELECT  TokenId,UsuarioId,Estado from usuarios_token WHERE Token = '" . $this->token . "' AND Estado = 'Activo'";
            $resp = parent::getData($query);
            if($resp){
                return $resp;
            }else{
                return 0;
            }
        }
    
    
        private function actualizarToken($tokenid){
            $date = date("Y-m-d H:i");
            $query = "UPDATE usuarios_token SET Fecha = '$date' WHERE TokenId = '$tokenid' ";
            $resp = parent::nonQuery($query);
            if($resp >= 1){
                return $resp;
            }else{
                return 0;
            }
        }


    }#end class
?>