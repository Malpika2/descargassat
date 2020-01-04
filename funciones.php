<?php
require_once __DIR__ . '/SWInclude.php';
include("test/DownloadXmlRequest.php");
// include("conexiones.php");
use LoginXmlRequest as loginSAT;
use RequestXmlRequest as solicita;
use VerifyXmlRequest as verifica;
use DownloadXmlRequest as descargar;
use Conexiones as conexion;
use Utils as util;
date_default_timezone_set('UTC');
// $cert = file_get_contents( __DIR__ . '/resources/aat170510949.cer');
// $key = file_get_contents( __DIR__ . '/resources/Claveprivada_FIEL_AAT170510949_20170523_135232.key.pem');
// $rfc = 'AAT170510949';
// $fechaInicial = '2018-08-12T00:00:00';
// $fechaFinal = '2019-08-02T12:59:59';
$TipoSolicitud = 'CFDI';

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
        echo  "Ocurrio un error al subir el cert. No pudo guardarse.";
        }else{
            $_SESSION['cert'] = file_get_contents( __DIR__ . '/test/resources/'.$nombre_archivo);
        }
        $key = $_FILES['key']['name'];
        $upload_folder ='test/resources/';
        $nombre_archivo = $_FILES['key']['name'];
        $tmp_archivo = $_FILES['key']['tmp_name'];
        $archivador = $upload_folder . '/'.$nombre_archivo;
        if (!move_uploaded_file($tmp_archivo, $archivador)) {
        echo  "Ocurrio un error al subir el key. No pudo guardarse.";
        }else{
            $_SESSION['key'] = file_get_contents( __DIR__ . '/test/resources/'.$nombre_archivo);
        }
        $ResponseAuth = loginSAT::soapRequest($_SESSION['cert'],$_SESSION['key']);
        $_SESSION['token'] = $ResponseAuth->token;
        
        echo json_encode('Login exitoso');
        break;
    case 'solicitar_consulta':
        // $data = $_POST;
        // $fechaInicial = $data['fechaInicial'].'T00:00:00';
        // $fechaFinal = $data['fechaFinal'].'T12:59:59';
        // $TipoSolicitud = $data['tipoSolicitud'];
        // $rfc = $data['rfc'];
        // echo $fechaInicial;
        // echo '<br>';
        // echo $fechaFinal;
        // echo '<br>';
        // echo $TipoSolicitud;
        // echo '<br>';
        // echo $rfc;echo '<br>';
        // echo $_SESSION['token'];echo '<br>';
        // $ResponseRequest = solicita::soapRequest($_SESSION['cert'], $_SESSION['key'], $_SESSION['token'], $rfc, $fechaInicial, $fechaFinal, $TipoSolicitud);
        $conexion = conexion::conectar();
        // echo json_encode($conexion);
        // echo json_encode($ResponseRequest);
        break;
    case 'verificar_consulta':
        $ResponseRequest = solicita::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $fechaInicial, $fechaFinal, $TipoSolicitud);
        $ResponseVerify = verifica::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idSolicitud);
        return json_encode($ResponseVerify);
        break;
    case 'descargar':
        $ResponseAuth = loginSAT::soapRequest($cert,$key);
        $ResponseVerify = verifica::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idSolicitud);
        $idPaquete = $ResponseVerify->idPaquete;
        $ResponseDownload = descargar::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idPaquete);
        return json_encode($ResponseDownload);
        break;
    case 'descargar_paquete':
        util::saveBase64File($ResponseDownload->Paquete, $idPaquete.".zip");
        return "Archivo descargado";
        break;
    default:
       return "Funcion desconocida";
        break;
}
?>