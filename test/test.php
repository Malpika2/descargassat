<?php
require_once __DIR__ . '/../SWInclude.php';
include("DownloadXmlRequest.php");
use LoginXmlRequest as loginSAT;
use RequestXmlRequest as solicita;
use VerifyXmlRequest as verifica;
use DownloadXmlRequest as descargar;
use Utils as util;
date_default_timezone_set('UTC');
$cert = file_get_contents( __DIR__ . '/resources/aat170510949.cer');
$key = file_get_contents( __DIR__ . '/resources/Claveprivada_FIEL_AAT170510949_20170523_135232.key.pem');
$rfc = 'AAT170510949';
$fechaInicial = '2018-08-12T00:00:00';
$fechaFinal = '2019-08-02T12:59:59';
$TipoSolicitud = 'CFDI';



// AUTENTIFICAR CREDENCIALES EN SAT 
$ResponseAuth = loginSAT::soapRequest($cert,$key);
var_dump($ResponseAuth);
 echo '</br>';
echo "SOLICITAR CONSULTA DE CFDIs";
echo "<br>";
$ResponseRequest = solicita::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $fechaInicial, $fechaFinal, $TipoSolicitud);
var_dump($ResponseRequest);
echo '</br>';
echo "VERIFICAR ESTATUS DE LA SOLICITUD";echo "<br>";
$idSolicitud =  $ResponseRequest->IdSolicitud;
// $idSolicitud = "c8f51ba3-4e5e-4f14-9090-1ec5795ed602";


$ResponseVerify = verifica::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idSolicitud);
var_dump($ResponseVerify);
echo '</br>';

echo "OBTENER PAQUETE";echo "<br>";
$idPaquete = $ResponseVerify->idPaquete;
// $idPaquete = "BD0913D3-10DD-45D4-8B45-581D932B5658_01";
// echo "id_paquete: ".$idPaquete;
echo "<br>";
$ResponseDownload = descargar::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idPaquete);
var_dump($ResponseDownload);
echo "<br>";
echo "Paquete descargado:".$idPaquete.".zip";
util::saveBase64File($ResponseDownload->Paquete, $idPaquete.".zip");

?>
<!-- ESTATUS DE LA SOLICITUD --> 
<!--    Aceptada=1
        EnProceso=2
        Terminada=3
        Error=4
        Rechazada=5
        Vencida=6 
-->