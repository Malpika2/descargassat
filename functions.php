<?php
require_once "lib/nusoap.php";
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
            $_SESSION['cert'] = file_get_contents( __DIR__ . '/test/resources/'.$nombre_archivo);
        }
        $key = $_FILES['key']['name'];
        $upload_folder ='test/resources/';
        $nombre_archivo = $_FILES['key']['name'];
        $tmp_archivo = $_FILES['key']['tmp_name'];
        $archivador = $upload_folder . '/'.$nombre_archivo;
        if (!move_uploaded_file($tmp_archivo, $archivador)) {
        echo  "Ocurrio un error con el archivo KEY.";
        }else{
            $_SESSION['key'] = file_get_contents( __DIR__ . '/test/resources/'.$nombre_archivo);
        }
        // var_dump($client);
        $cert2 = base64_encode($_SESSION['cert']);
        $key2 = base64_encode($_SESSION['key']);
        // echo $otraocsa;
        // $ResponseAuth = $client->call("Test",array($cert2));
        $ResponseAuth = $client->call("Autentificacion",array($cert2,$key2));
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }
        // echo $cert;
        // $ResponseAuth= $client->call("Test",'uno');
        // $typedata = gettype($_SESSION['cert']);
        // echo $typedata;
        // $ResponseAuth = loginSAT::soapRequest($_SESSION['cert'],$_SESSION['key']);
        // $_SESSION['token'] = $ResponseAuth->token;
        echo json_encode($ResponseAuth);
        // echo json_encode('Login exitoso');
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