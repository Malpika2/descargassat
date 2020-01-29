<?php
require_once "lib/nusoap.php";
require_once "Conexion.php";
use Conexion as conexion;
$client = new nusoap_client('http://localhost/descargassat/server.php?wsdl',true);
session_start();
switch ($_POST['accion']) {
    case 'login':
        $data = $_POST;
        $cert = $_FILES['cert']['name'];
        $upload_folder ='test/resources';
        $nombre_archivo = $_FILES['cert']['name'];
        $tmp_archivo = $_FILES['cert']['tmp_name'];
        $archivador = $upload_folder . '/'.$nombre_archivo;
        if (!move_uploaded_file($tmp_archivo, $archivador)) {
        echo  "Ocurrio un error con el Certificado .";
        }else{
            // $_SESSION['cert'] = file_get_contents( __DIR__ . '/test/resources/'.$nombre_archivo);
            $_SESSION['cert64'] =base64_encode(file_get_contents( __DIR__ . '/test/resources/'.$nombre_archivo));
        }
        $key = $_FILES['key']['name'];
        $upload_folder ='test/resources/';
        $nombre_archivo = $_FILES['key']['name'];
        $tmp_archivo = $_FILES['key']['tmp_name'];
        $archivador = $upload_folder . '/'.$nombre_archivo;
        if (!move_uploaded_file($tmp_archivo, $archivador)) {
        echo  "Ocurrio un error con el archivo KEY.";
        }else{
            // $_SESSION['key'] = file_get_contents( __DIR__ . '/test/resources/'.$nombre_archivo);
            $_SESSION['key64'] = base64_encode(file_get_contents( __DIR__ . '/test/resources/'.$nombre_archivo));
        }
        $cert2 = $_SESSION['cert64'];
        $key2 = $_SESSION['key64'];
        
        $personas[1] =  array('key' => $key2, 'cert' => $cert2);
        $ResponseAuth = $client->call('autentificacion',array('key'=>$key2,'cert'=>$cert2));
        $err = $client->getError();
        if ($err) {
            
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }
        error_log($ResponseAuth, 3,'error_log.php');
        $_SESSION['token'] = $ResponseAuth;
        // echo json_encode($ResponseAuth);
        echo json_encode('Autentificaciones de claves exitosa');
        break;
    case 'solicitar_consulta':
        $data = $_POST;
        $fechaInicial = $data['fechaInicial'].'T00:00:00';
        $fechaFinal = $data['fechaFinal'].'T12:59:59';
        $TipoSolicitud = $data['tipoSolicitud'];
        $rfc = $data['rfc'];
        // echo $fechaInicial;
        // echo '<br>';
        // echo $fechaFinal;
        // echo '<br>';
        // echo $TipoSolicitud;
        // echo '<br>';
        // echo $rfc;echo '<br>';
        // echo $_SESSION['token'];echo '<br>';

        $datos = array('cert'=>$_SESSION['cert64'], 'key'=>$_SESSION['key64'],'token'=>$_SESSION['token'], 'rfc'=>$rfc, 'fechaInicial'=>$fechaInicial,'fechaFinal'=>$fechaFinal,'tipoSolicitud'=>$TipoSolicitud);
        // error_log(json_encode($datos), 3 ,'error_log.php');
        $ResponseRequest =  $client->call('solicitar_descarga',$datos);
        
        // $ResponseRequest = solicita::soapRequest($_SESSION['cert'], $_SESSION['key'], $_SESSION['token'], $rfc, $fechaInicial, $fechaFinal, $TipoSolicitud);
        
        // $conexion = conexion::conectar();
        // IdSolicitud,codEstatus, mensaje, idPaquete, paquete, fechaInicial, fechaFinal, tipoSolicitud, token,rfc, cert64, key64, fechaConsulta
        // error_log($ResponseRequest['IdSolicitud'],3,'error_log.php');
        $datosInsert = array('IdSolicitud'=>$ResponseRequest['IdSolicitud'],'CodEstatus'=>$ResponseRequest['CodEstatus'],'Mensaje'=>$ResponseRequest['Mensaje'],'idPaquete'=>null,'paquete'=>null,'fechaInicial'=>$fechaInicial,'fechaFinal'=>$fechaFinal,'tipoSolicitud'=>$TipoSolicitud,'token'=>$_SESSION['token'],'rfc'=>$rfc,'cert64'=>$_SESSION['cert64'],'key64'=>$_SESSION['key64'],'fechaConsulta'=>date('d-m-Y',time()));
        $segunda = conexion::insertar($datosInsert);
        echo $segunda;
        // echo json_encode($conexion);
        // error_log(json_encode($ResponseRequest),3,'error_log.php');
        /*echo json_encode($ResponseRequest);*/
        break;
    case 'verificar_consulta':
        $data = $_POST;
        $datos = array('cert'=>$data['cer64'],'key'=>$data['key64'],'token'=>$data['token'],'rfc'=>$data['rfc'],'IdSolicitud'=>$data['IdSolicitud']);
        $ResponseVerify = $client->call('verificar_consulta',$datos);
        
        conexion::update(array('id_solicitud'=>$data['id_solicitud'],'IdSolicitud'=>$data['IdSolicitud'],'EstadoSolicitud'=>$ResponseVerify['EstadoSolicitud'],'codEstatus'=>$ResponseVerify['CodEstatus'],'mensaje'=>$ResponseVerify['Mensaje'],'idPaquete'=>$ResponseVerify['idPaquete'],'NumeroCFDIs'=>$ResponseVerify['NumeroCFDIs']));
        echo json_encode($ResponseVerify);
        // $ResponseVerify = verifica::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idSolicitud);
        // return json_encode($ResponseVerify);
        break;
    case 'descargar':
        $ResponseAuth = loginSAT::soapRequest($cert,$key);
        $ResponseVerify = verifica::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idSolicitud);
        $idPaquete = $ResponseVerify->idPaquete;
        $ResponseDownload = descargar::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idPaquete);
        return json_encode($ResponseDownload);
        break;
    case 'descargar_paquete':
        $data  = $_POST;
        $datos = array('cert'=>$data['cer64'],'key'=>$data['key64'],'rfc'=>$data['rfc'],'idPaquete'=>$data['idPaquete']);
        $ResponseDownload = $client->call('descargar_paquete', $datos);
        // $ResponseDownload = descargar::soapRequest($cert, $key, $rfc, $idPaquete);
        saveBase64File($ResponseDownload['Paquete'], "Paquete".time().".zip");
        return "Archivo descargado";
        break;
    case 'actualizarRegistros':
        $respuesta = conexion::getRegistros();
        echo json_encode($respuesta);
    break;
    default:
       return "Funcion desconocida";
        break;
    }
    function saveBase64File($data, $filename){
        $data = base64_decode($data);
        file_put_contents($filename, $data);
      }
    
?>