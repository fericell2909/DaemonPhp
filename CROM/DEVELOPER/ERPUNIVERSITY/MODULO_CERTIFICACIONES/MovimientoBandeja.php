<?php

    define('RUTA','/var/www/CROM/DEMO/');
    define('LIB','/var/www/LIBRERIAS/');

    include_once  RUTA . 'index.php';
    include_once LIB.'Email.php';

    ////include_once(LIB. 'sendgrid/vendor/autoload.php');

    $movimientos =  new General();

    $data  = $movimientos->Cert_ConsultarMovimientos('3');

    if ( count($data) > 0) {

        $email = new Email();
        $bResultadoEnvio = false;
        $codigorespuesta = -999;
        $mensajerespuesta = '';

        foreach($data as $value){

             $email->EnviarEmailBcc($value['asunto'], array( 'email'=>$value['correodestinatariocorporativo'],'nombre'=> 'Marco.'),
                                 $value['tipotexto'],$value['cuerpomensaje'],'fericell2909@gmail.com' , $bResultadoEnvio , $codigorespuesta , $mensajerespuesta);

            if($bResultadoEnvio)
            {
                $movimientos->Cert_ActualizarMovimientos('2',$value['identificador'],'1',$mensajerespuesta,$codigorespuesta);

            } else
            {
                $movimientos->Cert_ActualizarMovimientos('2',$value['identificador'],'2',$mensajerespuesta,$codigorespuesta);
            }

        }
    }




?>