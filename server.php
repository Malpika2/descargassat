<?php
require_once "lib/nusoap.php";
$namespace = "http://localhost/descargassat/server.php";
// $server = new soap_server();
// $server->configureWSDL("consulta",$namespace);
// $server->wsdl->schemaTargetNamespace = $namespace;
// $server->soap_defencoding = 'utf-8';


$server = new soap_server();

$server->soap_defencoding = 'utf-8';

$server->encode_utf8 = false;
$server->decode_utf8 = false;
$server->encode_utf8 = false;
$server->decode_utf8 = false;
$server->configureWSDL("WStest", "urn:WStest");
// $server->configureWSDL('WStest', 'urn:WStest', $namespace);
//Create a complex type

$server->wsdl->addComplexType(  'datos_persona_entrada', 
                                'complexType', 
                                'struct', 
                                'all', 
                                '',
                                array('key'              => array('name' => 'key','type' => 'xsd:string'),
                                      'cert'              => array('name' => 'cert','type' => 'xsd:string'))
);
// Parametros de Salida
$server->wsdl->addComplexType(  'datos_persona_salida', 
                                'complexType', 
                                'struct', 
                                'all', 
                                '',
                                array('mensaje'   => array('name' => 'mensaje','type' => 'xsd:string'))
);
$server->wsdl->addComplexType(  'arrayResponse',
                                'complexType',
                                'struct',
                                'all',
                                '',
                                array(  'IdSolicitud' => array('name' => 'IdSolicitud','type'=>'xsd:string'),
                                        'CodEstatus'  => array('name' => 'CodEstatus','type'=>'xsd:string'),
                                        'Mensaje'     => array('name' => 'Mensaje', 'type'=>'xsd:string') 
                                )
);
$server->wsdl->addComplexType(  'verificarResponse',
                                'complexType',
                                'struct',
                                'all',
                                '',
                                array(  
                                        'IdSolicitud'       => array('name' => 'IdSolicitud','type'=>'xsd:string'),
                                        'EstadoSolicitud'   => array('name' => 'EstadoSolicitud','type'=>'xsd:string'),
                                        'CodEstatus'        => array('name' => 'CodEstatus','type'=>'xsd:string'),
                                        'Mensaje'           => array('name' => 'Mensaje', 'type'=>'xsd:string'),
                                        'idPaquete'         => array('name' => 'idPaquete','type'=>'xsd:string'),
                                        'NumeroCFDIs'       => array('name' => 'NumeroCFDIs','type'=>'xsd:string')
                                )
                        );
$server->wsdl->addComplexType( 'downloadResponse',
                                'complexType',
                                'struct',
                                'all',
                                '',
                                array('Paquete'=> array('name' => 'Paquete','type' => 'xsd:string'))
                        );
/*************************/
/** Registro de métodos **/
/*************************/
    $server->register("Test",
                        array("datos_entrada" => "tns:datos_entrada"),
                        array("return" => "xsd:string"),
                        "urn:WStest",
                        "urn:WStest#Test",
                        "rpc",
                        "encoded",
                         "Enviar mail de aviso");

    $server->register("autentificacion",
        array('key' => 'xsd:string','cert'=>'xsd:string'), // parametros de entrada
        array("return" => "xsd:string"),
        "urn:WStest",
        "urn:WStest#autentificacion",
        "rpc",
        "encoded",
        "Verifica login");         

    $server->register('solicitar_descarga',
        array("cert" => "xsd:string","key"=>"xsd:string","token"=>"xsd:string","rfc"=>"sxd:string","fechaInicial"=>"xsd:string","fechaFinal"=>"xsd:string","tipoSolicitud"=>"xsd:string"),
        array("return"=>"tns:arrayResponse"),
        "urn:WStest",
        "urn:WStest#solicitar_descarga",
        "rpc",
        "encoded",
        "Solicitar descarga");

    $server->register('verificar_consulta',
        array("cert"=>"xsd:string","key"=>"xsd:string","token"=>"xsd:string","rfc"=>"xsd:string","IdSolicitud"=>"xsd:string"),
        array("return"=>"tns:verificarResponse"),
        "urn:WStest",
        "urn:WStest#verificar_consulta",
        "rpc",
        "encoded",
        "Verifica estatus de la consulta");

    // $server->register('descargar',
    //     array("certificado"=>"xsd:string","archivo_key"=>"xsd:string","token"=>"xsd:string","rfc"=>"xsd:string","idPaquete"=>"xsd:string"),
    //     array("return"=>"xsd:string"),
    //     "urn:WStest",
    //     "urn:WStest#descargar",
    //     "rpc",
    //     "encoded",
    //     "Solicita descarga");
        
    $server->register('descargar_paquete',
        array("cert"=>"xsd:string","key"=>"xsd:string","rfc"=>"xsd:string","idPaquete"=>"xsd:string"),
        array("return"=>"tns:downloadResponse"),
        "urn:WStest",
        "urn:WStest#descargar_paquete",
        "rpc",
        "encoded",
        "Descarga paquete");

    $server->register('calculo_edades', // nombre del metodo o funcion
        array('datos_persona_entrada' => 'tns:datos_persona_entrada'), // parametros de entrada
        array('return' => 'tns:datos_persona_salida'), // parametros de salida
        'urn:mi_ws1', // namespace
        'urn:hellowsdl2#calculo_edades', // soapaction debe ir asociado al nombre del metodo
        'rpc', // style
        'encoded', // use
        'La siguiente funcion recibe un arreglo multidimensional de personas y calcula las Edades respectivas segun la fecha de nacimiento indicada' // documentation,
         //$encodingStyle
);
        
                                        /*=========================
                                                :::METODOS:::
                                        ===========================*/
    function calculo_edades($datos) {
        // error_log (json_encode($datos), 3, 'error_log.php');
        $msg = '';  
        // Recorro el arreglo de datos enviados
        error_log($datos['cert'],3,'error_log.php');
        foreach ($datos as  $value){
            // error_log ($value, 3, 'error_log.php');
            // $edad_actual = date('Y') - $value['FechaNacimiento'];
            // $msg .= 'La edad de '. $value['nombre'] .' es:' . $edad_actual . ' años ==== <br />'; 
        }
        return array('mensaje' => $msg);
    }
        
    function Test($datos) {

        foreach ($datos as $key => $value){
            error_log ($value['certs'], 3, 'error_log.php');
        }
        return $datos;
    }
    function autentificacion($key,$cert){
            // error_log (json_encode($datos), 3, 'error_log.php');
            // error_log($cert,3,'error_log.php');

            $certificado = base64_decode($cert);
            $keyPEM = base64_decode($key);
        // $certificado = $datos['cert'];
        // $keyPEM = $datos['key'];

        
        $xmlString = getSoapBody($certificado,$keyPEM);
        
        $headers = headers($xmlString, 'http://DescargaMasivaTerceros.gob.mx/IAutenticacion/Autentica', null);
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, 'https://cfdidescargamasivasolicitud.clouda.sat.gob.mx/Autenticacion/Autenticacion.svc');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 50000);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlString);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            set_time_limit(0);
            $soap = curl_exec($ch);
            $err = curl_error($ch);
            $err = curl_error($ch);
            
        curl_close($ch);
        
        // error_log($datos['cert'],3,'error_log.php');
        if($err){
            throw new Exception("CUrl Error #:" .$err);
        }else{
            // error_log(response(xmlToArray($soap))->token , 3,'error_log.php');
            return response(xmlToArray($soap))->token;
        }
    }
    function solicitar_descarga($cert64, $key64, $token,$rfc, $fechaInicial, $fechaFinal, $TipoSolicitud){
        // error_log($cert64,3,'error_log.php');
        $token = autentificacion($key64,$cert64);

        $cert = base64_decode($cert64);
        $key = base64_decode($key64);
        
        $dataToHash = '<des:SolicitaDescarga xmlns:des="http://DescargaMasivaTerceros.sat.gob.mx"><des:solicitud RfcEmisor="'.$rfc.'" RfcSolicitante="'.$rfc.'" FechaInicial="'.$fechaInicial.'" FechaFinal="'.$fechaFinal.'" TipoSolicitud="'.$TipoSolicitud.'"></des:solicitud></des:SolicitaDescarga>';
        $digestValue = base64_encode(sha1($dataToHash, true));
        $dataToSign = '<SignedInfo xmlns="http://www.w3.org/2000/09/xmldsig#"><CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"></CanonicalizationMethod><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></SignatureMethod><Reference URI=""><Transforms><Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></Transform></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></DigestMethod><DigestValue>'.$digestValue.'</DigestValue></Reference></SignedInfo>';
        openssl_sign($dataToSign, $digs, $key, OPENSSL_ALGO_SHA1);
        $datosCer = openssl_x509_parse(derToPem($cert));
        $serialNumber = $datosCer["serialNumber"];
        $datos = '';
        foreach ($datosCer["issuer"] as $key => $value) {
        $datos .= $key.'='.$value.',';
        }
        $datos = substr($datos, 0, -1);
        $xml = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" xmlns:des="http://DescargaMasivaTerceros.sat.gob.mx" xmlns:xd="http://www.w3.org/2000/09/xmldsig#"><s:Header/><s:Body><des:SolicitaDescarga><des:solicitud RfcEmisor="'.$rfc.'" RfcSolicitante="'.$rfc.'" FechaFinal="'.$fechaFinal.'" FechaInicial="'.$fechaInicial.'" TipoSolicitud="'.$TipoSolicitud.'"><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></CanonicalizationMethod><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></SignatureMethod><Reference URI="#_0"><Transforms><Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></Transform></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></DigestMethod><DigestValue>'.$digestValue.'</DigestValue></Reference></SignedInfo><SignatureValue>'.base64_encode($digs).'</SignatureValue><KeyInfo><X509Data><X509IssuerSerial><X509IssuerName>'.$datos.'</X509IssuerName><X509SerialNumber>'.$serialNumber.'</X509SerialNumber></X509IssuerSerial><X509Certificate>'.base64_encode($cert).'</X509Certificate></X509Data></KeyInfo></Signature></des:solicitud></des:SolicitaDescarga></s:Body></s:Envelope>';
        $xmlString = $xml;
        $headers = headers($xmlString, 'http://DescargaMasivaTerceros.sat.gob.mx/ISolicitaDescargaService/SolicitaDescarga', $token);
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, 'https://cfdidescargamasivasolicitud.clouda.sat.gob.mx/SolicitaDescargaService.svc');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 50000);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlString);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            set_time_limit(0);
            $soap = curl_exec($ch);
            $err = curl_error($ch);
            $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else{ 
            $respuesta = responseRequest(xmlToArray($soap));
            
            // error_log('IdSolicitud: '.$respuesta->IdSolicitud , 3 , 'error_log.php');
            // error_log('CodEstatus: '.$respuesta->CodEstatus , 3 , 'error_log.php');
            // error_log('Mensaje '.$respuesta->Mensaje , 3 , 'error_log.php');
            $arrayResponse = array('IdSolicitud'=>$respuesta->IdSolicitud,'CodEstatus'=>$respuesta->CodEstatus,'Mensaje'=>$respuesta->Mensaje );
            // $arrayResponse = array('CodEstatus'=>$respuesta->CodEstatus);
            // $arrayResponse = array('Mensaje'=>$respuesta->Mensaje);

            // error_log(json_encode($respuesta));
            error_log(json_encode($arrayResponse));
            return $arrayResponse;
        }
    }
    function verificar_consulta($cert64, $key64, $token, $rfc, $IdSolicitud){
            // error_log($cert64,3,'error_log.php');

        $token = autentificacion($key64,$cert64);

        $cert = base64_decode($cert64);
        $key = base64_decode($key64);
        $xmlString = getSoapBodyVerif($cert, $key, $rfc, $IdSolicitud);
        $headers = headers($xmlString, 'http://DescargaMasivaTerceros.sat.gob.mx/IVerificaSolicitudDescargaService/VerificaSolicitudDescarga', $token);
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, 'https://cfdidescargamasivasolicitud.clouda.sat.gob.mx/VerificaSolicitudDescargaService.svc');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 50000);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlString);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            set_time_limit(0);
            $soap = curl_exec($ch);
            $err = curl_error($ch);
        
            $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else{
            $respuesta = responseVerif(xmlToArray($soap));
            // error_log(json_encode($respuesta),3,'error_log.php'); 
            $EstadoSolicitud = $respuesta->EstadoSolicitud;

            if (null!=$respuesta->idPaquete) {
                $idPaquete=$respuesta->idPaquete;
            }else{
                $idPaquete = '0';
            }
            // NumeroCFDIs
            $arrayResponse = array('IdSolicitud'=>$IdSolicitud,'EstadoSolicitud'=>$respuesta->EstadoSolicitud,'CodEstatus'=>$respuesta->CodEstatus,'Mensaje'=>$respuesta->Mensaje,'idPaquete'=>$idPaquete,'NumeroCFDIs'=>$respuesta->NumeroCFDIs);
            return $arrayResponse;
        }

    }
    function descargar_paquete($cert64, $key64, $rfc, $idPaquete){
        $token = autentificacion($key64,$cert64);
        $cert = base64_decode($cert64);
        $key = base64_decode($key64);
        $xmlString = getSoapBodyDownload($cert, $key, $rfc, $idPaquete);
        $headers = headers($xmlString, 'http://DescargaMasivaTerceros.sat.gob.mx/IDescargaMasivaTercerosService/Descargar', $token);
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, 'https://cfdidescargamasiva.clouda.sat.gob.mx/DescargaMasivaService.svc');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 50000);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlString);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            set_time_limit(0);
            $soap = curl_exec($ch);
            $err = curl_error($ch);
        
            $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else{
            $respuesta =responseDownload(xmlToArray($soap));
            error_log(json_encode($respuesta),3,'error_log.php');
            $arrayResponse = array('Paquete'=>$respuesta->Paquete);
            return $arrayResponse;
        }
    }
                                        /*==============================
                                            :::FUNCIONES AUXILIARES:::
                                        ===============================*/
    function getSoapBody($cert,$keyPEM){
        $uuid = "uuid-".genUuid()."-1";
        $fecha_inicial = time();
        $fecha_final = $fecha_inicial+(60*5);
        $data = '<u:Timestamp xmlns:u="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" u:Id="_0"><u:Created>'.date("Y-m-d\TH:i:s.Z\Z", $fecha_inicial).'</u:Created><u:Expires>'.date("Y-m-d\TH:i:s.Z\Z", $fecha_final).'</u:Expires></u:Timestamp>';
        $digestValue = base64_encode(sha1($data,true));
        $dataToSign = '<SignedInfo xmlns="http://www.w3.org/2000/09/xmldsig#"><CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></CanonicalizationMethod><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></SignatureMethod><Reference URI="#_0"><Transforms><Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></Transform></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></DigestMethod><DigestValue>'.$digestValue.'</DigestValue></Reference></SignedInfo>';
        openssl_sign($dataToSign, $digs, $keyPEM, OPENSSL_ALGO_SHA1);
        $xml = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" xmlns:u="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"><s:Header><o:Security s:mustUnderstand="1" xmlns:o="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"><u:Timestamp u:Id="_0"><u:Created>'.date("Y-m-d\TH:i:s.Z\Z", $fecha_inicial).'</u:Created><u:Expires>'.date("Y-m-d\TH:i:s.Z\Z", $fecha_final).'</u:Expires></u:Timestamp><o:BinarySecurityToken u:Id="'.$uuid.'" ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3" EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">'.base64_encode($cert).'</o:BinarySecurityToken><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/><Reference URI="#_0"><Transforms><Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><DigestValue>'.$digestValue.'</DigestValue></Reference></SignedInfo><SignatureValue>'.base64_encode($digs).'</SignatureValue><KeyInfo><o:SecurityTokenReference><o:Reference ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3" URI="#'.$uuid.'"/></o:SecurityTokenReference></KeyInfo></Signature></o:Security></s:Header><s:Body><Autentica xmlns="http://DescargaMasivaTerceros.gob.mx"/></s:Body></s:Envelope>';
        return $xml;
    }
    function getSoapBodyDownload($cert, $keyPEM, $rfc, $idPaquete){
        $dataToHash = '<des:PeticionDescargaMasivaTercerosEntrada xmlns:des="http://DescargaMasivaTerceros.sat.gob.mx"><des:peticionDescarga IdPaquete="'.$idPaquete.'" RfcSolicitante="'.$rfc.'"></des:peticionDescarga></des:PeticionDescargaMasivaTercerosEntrada>';
        $digestValue = base64_encode(sha1($dataToHash, true));
        $dataToSign = '<SignedInfo xmlns="http://www.w3.org/2000/09/xmldsig#"><CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></CanonicalizationMethod><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></SignatureMethod><Reference URI=""><Transforms><Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></Transform></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></DigestMethod><DigestValue>'.$digestValue.'</DigestValue></Reference></SignedInfo>';
        openssl_sign($dataToSign, $digs, $keyPEM, OPENSSL_ALGO_SHA1);
        $datosCer = openssl_x509_parse(derToPem($cert));
        $serialNumber = $datosCer["serialNumber"];
        $datos = '';
        foreach ($datosCer["issuer"] as $key => $value) {
          $datos .= $key.'='.$value.',';
        }
        $datos = substr($datos, 0, -1);
        $xml = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" xmlns:des="http://DescargaMasivaTerceros.sat.gob.mx" xmlns:xd="http://www.w3.org/2000/09/xmldsig#"><s:Header/><s:Body><des:PeticionDescargaMasivaTercerosEntrada><des:peticionDescarga IdPaquete="'.$idPaquete.'" RfcSolicitante="'.$rfc.'"><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/><Reference URI=""><Transforms><Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></DigestMethod><DigestValue>'.$digestValue.'</DigestValue></Reference></SignedInfo><SignatureValue>'.base64_encode($digs).'</SignatureValue><KeyInfo><X509Data><X509IssuerSerial><X509IssuerName>'.$datos.'</X509IssuerName><X509SerialNumber>'.$serialNumber.'</X509SerialNumber></X509IssuerSerial><X509Certificate>'.base64_encode($cert).'</X509Certificate></X509Data></KeyInfo></Signature></des:peticionDescarga></des:PeticionDescargaMasivaTercerosEntrada></s:Body></s:Envelope>';
        return $xml;
      }
    function response($data){
        $obj = (object)[];
        if(isset($data["Body"]["Fault"])){
            $obj->faultcode = $data["Body"]["Fault"]["faultcode"];
            $obj->faultstring = $data["Body"]["Fault"]["faultstring"];
        }
        else{
            $obj->token = $data["Body"]["AutenticaResponse"]["AutenticaResult"];
        }
        return $obj;
    }
    function responseRequest($data){
        $obj = (object)[];
        if(isset($data["Body"]["Fault"])){
          $obj->faultcode = $data["Body"]["Fault"]["faultcode"];
          $obj->faultstring = $data["Body"]["Fault"]["faultstring"];
        }
        else{
          $obj->IdSolicitud = $data["Body"]["SolicitaDescargaResponse"]["SolicitaDescargaResult"]["@attributes"]["IdSolicitud"];
          $obj->CodEstatus = $data["Body"]["SolicitaDescargaResponse"]["SolicitaDescargaResult"]["@attributes"]["CodEstatus"];
          $obj->Mensaje = $data["Body"]["SolicitaDescargaResponse"]["SolicitaDescargaResult"]["@attributes"]["Mensaje"];
        }
        return $obj;
    }
    function responseVerif($data){
        $obj = (object)[];
        if(isset($data["Body"]["Fault"])){
          $obj->faultcode = $data["Body"]["Fault"]["faultcode"];
          $obj->faultstring = $data["Body"]["Fault"]["faultstring"];
        }
        else{
          $obj->EstadoSolicitud = $data["Body"]["VerificaSolicitudDescargaResponse"]["VerificaSolicitudDescargaResult"]["@attributes"]["EstadoSolicitud"];
          $obj->CodEstatus = $data["Body"]["VerificaSolicitudDescargaResponse"]["VerificaSolicitudDescargaResult"]["@attributes"]["CodEstatus"];
          $obj->Mensaje = $data["Body"]["VerificaSolicitudDescargaResponse"]["VerificaSolicitudDescargaResult"]["@attributes"]["Mensaje"];
        //   error_log(json_encode($obj));
          $obj->CodigoEstadoSolicitud = $data["Body"]["VerificaSolicitudDescargaResponse"]["VerificaSolicitudDescargaResult"]["@attributes"]["CodigoEstadoSolicitud"];
          
          $obj->NumeroCFDIs = $data["Body"]["VerificaSolicitudDescargaResponse"]["VerificaSolicitudDescargaResult"]["@attributes"]["NumeroCFDIs"];
          if($obj->EstadoSolicitud == "3"){
            $obj->idPaquete = $data["Body"]["VerificaSolicitudDescargaResponse"]["VerificaSolicitudDescargaResult"]["IdsPaquetes"];
          }
        }
        return $obj;
    }
    function responseDownload($data){
        $obj = (object)[];
        if(isset($data["Body"]["Fault"])){
          $obj->faultcode = $data["Body"]["Fault"]["faultcode"];
          $obj->faultstring = $data["Body"]["Fault"]["faultstring"];
        }
        else{
          $obj->Paquete = $data["Body"]["RespuestaDescargaMasivaTercerosSalida"]["Paquete"];
        }
        return $obj;
    }
    function getSoapBodyVerif($cert, $keyPEM, $rfc, $idSolicitud){
        $dataToHash = '<des:VerificaSolicitudDescarga xmlns:des="http://DescargaMasivaTerceros.sat.gob.mx"><des:solicitud IdSolicitud="'.$idSolicitud.'" RfcSolicitante="'.$rfc.'"></des:solicitud></des:VerificaSolicitudDescarga>';
        $digestValue = base64_encode(sha1($dataToHash, true));
        $dataToSign = '<SignedInfo xmlns="http://www.w3.org/2000/09/xmldsig#"><CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></CanonicalizationMethod><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></SignatureMethod><Reference URI=""><Transforms><Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></Transform></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></DigestMethod><DigestValue>'.$digestValue.'</DigestValue></Reference></SignedInfo>';
        openssl_sign($dataToSign, $digs, $keyPEM, OPENSSL_ALGO_SHA1);
        $datosCer = openssl_x509_parse(derToPem($cert));
        $serialNumber = $datosCer["serialNumber"];
        $datos = '';
        foreach ($datosCer["issuer"] as $key => $value) {
          $datos .= $key.'='.$value.',';
        }
        $datos = substr($datos, 0, -1);
        $xml = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" xmlns:des="http://DescargaMasivaTerceros.sat.gob.mx" xmlns:xd="http://www.w3.org/2000/09/xmldsig#"><s:Header/><s:Body><des:VerificaSolicitudDescarga><des:solicitud IdSolicitud="'.$idSolicitud.'" RfcSolicitante="'.$rfc.'"><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/><Reference URI=""><Transforms><Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></DigestMethod><DigestValue>'.$digestValue.'</DigestValue></Reference></SignedInfo><SignatureValue>'.base64_encode($digs).'</SignatureValue><KeyInfo><X509Data><X509IssuerSerial><X509IssuerName>'.$datos.'</X509IssuerName><X509SerialNumber>'.$serialNumber.'</X509SerialNumber></X509IssuerSerial><X509Certificate>'.base64_encode($cert).'</X509Certificate></X509Data></KeyInfo></Signature></des:solicitud></des:VerificaSolicitudDescarga></s:Body></s:Envelope>';
        return $xml;
      }
    //////////////////////////////////////////
    function headers($xmlString, $soapAction, $token){
        return  array(
                 "Content-type: text/xml;charset=\"utf-8\"",
                 "Accept: text/xml",
                 "Cache-Control: no-cache",
                 $token ? "Authorization: WRAP access_token=\"".$token."\"":"",
                 "SOAPAction: ".$soapAction, 
                 "Content-length: ".strlen($xmlString),
        );
    }
    function xmlToArray($xml){
        return json_decode(json_encode(simplexml_load_string(str_replace("s:", "", str_replace("o:","", str_replace("u:","",str_replace("h:","",'<?xml version="1.0" encoding="utf-8"?>'.$xml)))))),TRUE);
    }

    function genUuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    function derToPem($der_data, $type='CERTIFICATE') {
        $pem = chunk_split(base64_encode($der_data), 64, "\n");
        $pem = "-----BEGIN ".$type."-----\n".$pem."-----END ".$type."-----\n";
        return $pem;
    }

    function saveBase64File($data, $filename){
        $data = base64_decode($data);
        file_put_contents($filename, $data);
    }
    function binaryToString($binary){
        $binaries = explode(' ', $binary);
        $string = null;
        foreach ($binaries as $binary) {
            $string .= pack('H*', dechex(bindec($binary)));
        }
        return $string;    
    }
    
    if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
    $server->service($HTTP_RAW_POST_DATA);
?>
