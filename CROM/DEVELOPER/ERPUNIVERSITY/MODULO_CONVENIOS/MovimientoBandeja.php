<?php

    define('RUTA','/var/www/CROM/DEVELOPER/');
    define('LIB','/var/www/LIBRERIAS/');
//define('RUTA','C:/xampp/htdocs/daemonsuladech/CROM/DEVELOPER');
//define('LIB','C:/xampp/htdocs/daemonsuladech/LIBRERIAS');
    include_once  RUTA . 'index.php';
    include_once LIB.'Email.php';

    ////include_once(LIB. 'sendgrid/vendor/autoload.php');

    $movimientos =  new General();

//    $data  = $movimientos->Cert_ConsultarMovimientos('3');
    $data  = $movimientos->Grui_ConsultarMovimientos('3');
    if ( count($data) > 0) {

        $email = new Email();
        $bResultadoEnvio = false;
        $codigorespuesta = -999;
        $mensajerespuesta = '';

        foreach($data as $value){

             $email->EnviarEmail($value['asunto'], array( 'email'=>$value['correodestinatariocorporativo'],'nombre'=>$value['nombres']),
                                 $value['tipotexto'],$value['cuerpomensaje'], $bResultadoEnvio , $codigorespuesta , $mensajerespuesta);

            if($bResultadoEnvio)
            {
                $movimientos->Grui_ActualizarMovimientos('2',$value['identificador'],'1',$mensajerespuesta,$codigorespuesta);

            } else
            {
                $movimientos->Grui_ActualizarMovimientos('2',$value['identificador'],'2',$mensajerespuesta,$codigorespuesta);
            }

        }
    }




?>