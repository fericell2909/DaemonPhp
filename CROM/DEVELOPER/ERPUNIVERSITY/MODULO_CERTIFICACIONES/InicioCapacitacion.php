<?php

define('RUTA','/var/www/CROM/DEVELOPER/');
define('LIB','/var/www/LIBRERIAS/');

include_once  RUTA . 'index.php';
include_once LIB.'Email.php';


$movimientos =  new General();

$data  = $movimientos->Cert_Consultar_InicioCapacitaciones('3');

//print_r($data);

if ( count($data) > 0) {

    $email = new Email();
    $bResultadoEnvio = false;
    $codigorespuesta = -999;
    $mensajerespuesta = '';

    foreach($data as $value){

        $email->EnviarEmail($value['asunto'], array( 'email'=>$value['correodestinatariocorporativo'],'nombre'=> ' '),
            $value['tipotexto'],$value['cuerpomensaje'], $bResultadoEnvio , $codigorespuesta , $mensajerespuesta);

        if($bResultadoEnvio)
        {
            $movimientos->Cert_Actualizar_InicioCapacitaciones('2',$value['identificador'],'1',$mensajerespuesta,$codigorespuesta);

        } else
        {
            $movimientos->Cert_Actualizar_InicioCapacitaciones('2',$value['identificador'],'2',$mensajerespuesta,$codigorespuesta);
        }

    }
}

?>