<?php

        #CLASE CONEXION PARA BASE DE DATOS 
    #EVITAR LA REDEFINICION DE LA CLASE
    #si la clase ya existe no realiza las siguientes instrucciones
  
        class class_db{
            //varuables de instancia
            private $server;
            private $user;
            private $password;
            private $dbname;
            private $port;
            private $conexion;

            //METODO CONSTRUCTOR
            function __construct(){
                $dataList = $this -> datosConexion();
                foreach ($dataList as $key => $value){
                    $this->server = $value['server'];
                    $this->user = $value['user'];
                    $this->password = $value['password'];
                    $this->dbname = $value['dbname'];
                    $this->port = $value['port'];
                }
                $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->dbname, $this->port);
                if($this->conexion->connect_errno){
                    echo "No se pudo establecer conexion con la base de datos";
                    die();
                }
            }//end constructor
            //OBTENEMOS LOS DATOS DE NUESTRA CONEXION 
            private function datosConexion(){
                $direccion = dirname(__FILE__);
                $jsondata = file_get_contents($direccion . "/" . "config");
                return json_decode($jsondata, true);
            }

            private function convertirUTF8($array){
                array_walk_recursive($array,function(&$item,$key){
                    if(!mb_detect_encoding($item,'utf-8',true)){
                        $item = utf8_encode($item);
                    }
                });
                return $array;
            }
        
            //LISTA DE PERSONAJES EN DB
            public function getData($sqlstr){
                $results = $this->conexion->query($sqlstr);
                $resultArray = array();
                foreach($results as $key){
                    $resultArray[]=$key;
                }
                return $this->convertirUTF8($resultArray);
            }
            //INSERT ---- DEVUELVE NUMERO DE TABLAS AFECTADAS
            public function nonQuery($sqlstr){
                $results = $this->conexion->query($sqlstr);
                return $this->conexion->affected_rows;
            }

             //SOLAMENTE INSERT ---- DEVUELVE ULTIMO ID INSERTADO
            public function nonQueryId($sqlstr){
                $results = $this->conexion->query($sqlstr);
                $filas = $this->conexion->affected_rows;
                if($filas >= 1){
                    return $this->conexion->insert_id;
                 }else{
                     return 0;
                }
            }#end function

            protected function encriptar($string){
                return md5($string);
            }
        

        }#end class
     
    //encriptar



    /*
    $server = 'localhost';
    $user = 'root';
    $password = '';
    $db_name = 'RickandMorty';
    $port = '3306';

    //Conexion 
    $db_conn = new mysqli($server, $user, $password, $db_name, $port);
    if($db_conn->connect_errno){
        die($db_conn -> connect_error);
    }

    function NonQuery($sqlstr, &$db_conn = null){
        if(!$db_conn)global $db_conn;
        $result = $db_conn->query($sqlstr);
        return $db_conn -> affect_row;
    }

    function getCharacters($sqlstr, &$db_conn = null){

        if(!$db_conn)global $db_conn;
        $result = $db_conn->query($sqlstr);
        $resultArray = array();
        foreach ($result as $registros){
            $resultArray[] = $registros;
        }
        return $resultArray;
    }
    */

?>