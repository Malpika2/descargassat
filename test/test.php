<?php
require_once __DIR__ . '/../SWInclude.php';
use LoginXmlRequest as loginSAT;
use RequestXmlRequest as solicita;
use VerifyXmlRequest as verifica;
use DownloadXmlRequest as descarga;
use Utils as util;

date_default_timezone_set('UTC');



$cert = file_get_contents( __DIR__ . '/resources/FielPrueba.cer');
$key = file_get_contents( __DIR__ . '/resources/FielPrueba.key');
$rfc = 'VECJ880326123';
$fechaInicial = '2018-07-02T00:00:00';
$fechaFinal = '2018-08-02T12:59:59';
$TipoSolicitud = 'Metadata';
$idSolicitud = '1fb832ff-6a25-4616-8ca8-04478690cc29';
$idPaquete = '1fb832ff-6a25-4616-8ca8-04478690cc29_01';

$ResponseAuth = loginSAT::soapRequest($cert,$key);

// var_dump($ResponseAuth);
// echo 'Cert:'.$cert.'</br>';
// echo 'Key:'.$key.'</br>';
// echo 'ResponseAuth->token:'.$ResponseAuth->token.'</br>';
// echo 'rfc:'.$rfc.'</br>';
// echo 'fechaInicial:'.$fechaInicial.'</br>';
// echo 'fechaFinal:'.$fechaFinal.'</br>';
// echo 'TipoSolicitud:'.$TipoSolicitud.'</br>';
$ResponseRequest = solicita::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $fechaInicial, $fechaFinal, $TipoSolicitud);
var_dump($ResponseRequest);
echo '</br>';
$ResponseVerify = verifica::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idSolicitud);
var_dump($ResponseVerify);
echo '</br>';
$ResponseDownload = descarga::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idPaquete);
util::saveBase64File($ResponseDownload->Paquete, $idPaquete.".zip");
var_dump($ResponseDownload);

?>