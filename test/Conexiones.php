<?php 
class Conexiones{
    public  $usuario = 'root';
    public  $password = '';  // en mi caso tengo contraseña pero en casa caso introducidla aquí.
    public  $servidor = "localhost";
    public  $basededatos = "descargassat";

    public static function conectar(){
        $conn = mysqli_connect($servidor, $usuario, $password, $basededatos);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $conexion;
    }

    
}
?>