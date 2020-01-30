<?php
    class Conexion 
    {
        public  $usuario = "user_descargasat";
        public  $contrasena = "";  
        public  $servidor = "localhost";
        public  $basededatos = "descargasat";
        

        public static  function conectar(){
             $conexion = mysqli_connect( 'localhost', 'user_descargasat','') or die ('No se ha podido conectar al servidor de Base de datos');
             $db = mysqli_select_db( $conexion, 'descargasat' ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );    
             return $conexion;
        }
        public static  function insertar($params){
            $conexion = mysqli_connect( 'localhost', 'user_descargasat','') or die ('No se ha podido conectar al servidor de Base de datos');
            $db = mysqli_select_db( $conexion, 'descargasat' ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );    
            $sql = "INSERT INTO solicitudes (idSolicitud,codEstatus, mensaje, idPaquete, paquete, fechaInicial, fechaFinal, tipoSolicitud, token,rfc, cert64, key64, fechaConsulta) VALUES
                                            ('".$params['IdSolicitud']."' , '".$params['CodEstatus']."','".$params['Mensaje']."' , NULL, NULL, '".$params['fechaInicial']."','".$params['fechaFinal']."','".$params['tipoSolicitud']."','".$params['token']."', '".$params['rfc']."' , '".$params['cert64']."', '".$params['key64']."', '".$params['fechaConsulta']."')";
            if ($conexion->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
        }
        public static function getRegistros(){
            $conexion = new mysqli("localhost", "user_descargasat", "", "descargasat") or die ('No se ha podido conectar al servidor de Base de datos');
            $sql = "SELECT * FROM solicitudes";
            $resultados = $conexion->query($sql);
            return   $resultados->fetch_all();
        }
        public static function update($data){
            
            $conexion = new mysqli("localhost","user_descargasat","","descargasat") or die("Error de conexion a la Base de datos");
                $sql = "UPDATE solicitudes SET codEstatus = '".$data['codEstatus']."', EstadoSolicitud = '".$data['EstadoSolicitud']."', idPaquete = '".$data['idPaquete']."',mensaje = '".$data['mensaje']."', NumeroCFDIs = ".$data['NumeroCFDIs']."  WHERE id_solicitud = ".$data['id_solicitud']."";
                error_log($sql,3,'error_log.php');
                if ($conexion->query($sql) === TRUE) {
                    error_log("Solicitud exitosa" , 3, 'error_log.php');
                } else {
                    error_log("Error de BD: " . $conexion->error , 3, 'error_log.php');
                }

        }

    }
    
?>