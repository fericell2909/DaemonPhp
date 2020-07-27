<?php

//define('RUTA','/var/www/CROM/DEVELOPER/');
//define('LIB','/var/www/LIBRERIAS/');

define('RUTA','C:/xampp/htdocs/daemonsuladech/CROM/DEVELOPER');
define('LIB','C:/xampp/htdocs/daemonsuladech/LIBRERIAS');


include_once  RUTA . 'index.php';
include_once LIB.'Email.php';


$movimientos =  new General();

$data  = $movimientos->Grui_Consultar_VencimientoConvenio('3');

//print_r($data);

if ( count($data) > 0) {

    $email = new Email();
    $bResultadoEnvio = false;
    $codigorespuesta = -999;
    $mensajerespuesta = '';

    foreach($data as $value){
	
	    $email->EnviarEmailConvenio($value['asunto'], $value['correosuscrito'],array( 'email'=>$value['correodestinatariopersonal'],'nombre'=>$value['nombresuscrito']),
		    $value['tipotexto'],$value['cuerpomensaje'], $bResultadoEnvio , $codigorespuesta , $mensajerespuesta);
	
	    $email->EnviarEmailConvenio($value['asunto'], $value['correosuscrito'],array( 'email'=>$value['correosuscrito'],'nombre'=>$value['nombreinterno']),
		    $value['tipotexto'],$value['cuerpomensaje'], $bResultadoEnvio , $codigorespuesta , $mensajerespuesta);
	    
	    $email->EnviarEmailConvenio($value['asunto'], $value['correosuscrito'],array( 'email'=>$value['correodestinatariopersonalcontraparte'],'nombre'=>$value['nombreexterno']),
		    $value['tipotexto'],$value['cuerpomensaje'], $bResultadoEnvio , $codigorespuesta , $mensajerespuesta);
	
	    if($bResultadoEnvio)
        {
            $movimientos->Grui_Actualizar_VencimientoConvenio('2',$value['identificador'],'1',$mensajerespuesta,$codigorespuesta);

        } else
        {
            $movimientos->Grui_Actualizar_VencimientoConvenio('2',$value['identificador'],'2',$mensajerespuesta,$codigorespuesta);
        }

    }
}

?>