<?php
require_once "lib/nusoap.php";
$server = new soap_server();
$server->soap_defencoding = 'UTF-8';
$server->decode_utf8 = false;
$server->encode_utf8 = true;
$server->configureWSDL("WStest", "urn:WStest");



/*************************/
/** Registro de métodos **/
/*************************/
    $server->register("Test",
                        array("pregunta" => "xsd:string"),
                        array("return" => "xsd:string"),
                        "urn:WStest",
                        "urn:WStest#Test",
                        "rpc",
                        "encoded",
                         "Enviar mail de aviso");

    $server->register("Autentificacion",
        array("ceriticado" => "xsd:string", "archivo_key" => "xsd:string"),
        array("return" => "xsd:string"),
        "urn:WStest",
        "urn:WStest#Autentificacion",
        "rpc",
        "encoded",
        "Verifica login");         

    $server->register('solicitar_descarga',
        array("certificado" => "xsd:string","archivo_key"=>"xsd:string","token"=>"xsd:string","rfc"=>"sxd:string","fechaInicial"=>"xsd:string","fechaFinal"=>"xsd:string","tipoSolicitud"=>"xsd:string"),
        array("return"=>"xsd:string"),
        "urn:WStest",
        "urn:WStest#solicitar_descarga",
        "rpc",
        "encoded",
        "Solicitar descarga");

    $server->register('verificar_consulta',
        array("certificado"=>"xsd:string","archivo_key"=>"xsd:string","token"=>"xsd:string","rfc"=>"xsd:string","idSolicitud"=>"xsd:string"),
        array("return"=>"xsd:string"),
        "urn:WStest",
        "urn:WStest#verificar_consulta",
        "rpc",
        "encoded",
        "Verifica estatus de la consulta");

    $server->register('descargar',
        array("certificado"=>"xsd:string","archivo_key"=>"xsd:string","token"=>"xsd:string","rfc"=>"xsd:string","idPaquete"=>"xsd:string"),
        array("return"=>"xsd:string"),
        "urn:WStest",
        "urn:WStest#descargar",
        "rpc",
        "encoded",
        "Solicita descarga");
        
    $server->register('descargar_paquete',
        array("paquete"=>"xsd:string","nombreDescarga"=>"xsd:string"),
        array("return"=>"xsd:string"),
        "urn:WStest",
        "urn:WStest#descargar_paquete",
        "rpc",
        "encoded",
        "Descarga paquete");
        
                                        /*=========================
                                                :::METODOS:::
                                        ===========================*/
    function Test($respuesta) {
        return $respuesta;
    }
    function Autentificacion($cert,$key){
        // return "entro a autentificacion";
        $xmlString = getSoapBody($certificado,$keyPEM);
        $headers = Utils::headers($xmlString, 'http://DescargaMasivaTerceros.gob.mx/IAutenticacion/Autentica', null);
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
        $curl_close($ch);
        
        if($err){
            throw new Exception("CUrl Error #:" .$err);
        }else{
            return response(xmlToArray($soap));
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
    
    if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
    $server->service($HTTP_RAW_POST_DATA);
?>
