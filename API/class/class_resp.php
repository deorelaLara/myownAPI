<?php
    class Respuestas{
        public $response = [
            'status' => "ok",
            "result" => array()
        ];

        //ERROR ----- > Metodo no permitido
        public function error_405(){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                "error_id" => "405",
                "error_msg" => "Metodo no permitido"
            );
            return $this->response;
        }
        //ERROR 200 ----> 
        public function error_200($str="Datos incorrectos."){ #agregamos un valor por defecto para que siga funcionando la funcion si no ingresamos parametro
            $this->response['status'] = "error";
            $this->response['result'] = array(
                "error_id" => "200",
                "error_msg" => $str
            );
            return $this->response;
        }
        //error 400 --- > BAD REQUEST
        public function error_400(){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                "error_id" => "400",
                "error_msg" => "Datos enviados incompletos o con formato incorrecto"
            );
            return $this->response;
        }
    
        //error 500 -----> Internal server error
        public function error_500($valor = "Error interno del servidor"){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                "error_id" => "500",
                "error_msg" => $valor
            );
            return $this->response;
        }
    
    
        public function error_401($valor = "No autorizado"){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                "error_id" => "401",
                "error_msg" => $valor
            );
            return $this->response;
        }

    }#end class
?>