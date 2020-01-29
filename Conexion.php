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
            // error_log(json_encode($params),3,'error_log.php');
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
            // $conexion = mysqli_connect( 'localhost', 'user_descargasat','') or die ('No se ha podido conectar al servidor de Base de datos');
            // $db = mysqli_select_db( $conexion, 'descargasat' ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );    
            $sql = "SELECT * FROM solicitudes";
            $resultados = $conexion->query($sql);
            // $resultados = mysqli_query($conexion,"select * from solicitudes limit 10");
            //  $conexion->query($sql);
            return   $resultados->fetch_all();
        }
        public static function update($data){
            //Agregar foreach para agregar los datos.
            $conexion = new mysqli("localhost","user_descargasat","","descargasat") or die("Error de conexion a la Base de datos");
            // foreach ($data as $key => $value) {
                // error_log('--_--'.$key.': '.$value,3,'error_log.php');
                $sql = "UPDATE solicitudes SET codEstatus = '".$data['codEstatus']."', EstadoSolicitud = '".$data['EstadoSolicitud']."', idPaquete = '".$data['idPaquete']."',mensaje = '".$data['mensaje']."', NumeroCFDIs = ".$data['NumeroCFDIs']."  WHERE id_solicitud = ".$data['id_solicitud']."";
                error_log($sql,3,'error_log.php');
                // $conexion->query($sql);
                if ($conexion->query($sql) === TRUE) {
                    error_log("Record updated successfully" , 3, 'error_log.php');
                } else {
                    error_log("Error updating record: " . $conexion->error , 3, 'error_log.php');
                }
            // }
            // error_log($data['IdSolicitud'],3,'error_log.php');
            // $sql = "UPDATE solicitudes set "

        }

    }
    
?>