<?php
require_once ('lib/nusoap.php');
$client = new nusoap_client('http://localhost/descargassat/server.php?wsdl',true);
if(isset($_POST['name'])){

$res=$client->call("Test",array($_POST['name']));

echo $res . "<br />" ;

}
?>

<form method="post"

action="<?php echo basename(__FILE__); ?>">

<input name='name'>

<input type="submit" value="enviar" name='submit'/>

</form>