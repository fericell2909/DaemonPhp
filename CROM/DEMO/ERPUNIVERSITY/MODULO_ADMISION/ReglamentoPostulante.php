<?php

define('RUTA','/var/www/CROM/DEMO/');
define('LIB','/var/www/LIBRERIAS/');

include_once  RUTA . 'index.php';
include_once LIB.'Email.php';


$movimientos =  new General();

$data = $movimientos->adm_consultar_ReglamentoPostulante('3');
# adm_consultar_ReglamentoPostulante
//print_r($data);

if ( count($data) > 0) {
	
	$email = new Email();
	$bResultadoEnvio = false;
	$codigorespuesta = -999;
	$mensajerespuesta = '';
	
	foreach($data as $value){
		
		$adjuntos =   $movimientos->adm_obtener_archivos_adjuntos_postulantes('4',$value['identificador']);
		
		$email->EnviarEmailAdjunto($value['asunto'], array( 'email'=>$value['correodestinatariopersonal'],'nombre'=>$value['nombrespostulantes']),
			$value['tipotexto'],$value['cuerpomensaje'],'fericell2909@gmail.com',
			$bResultadoEnvio , $codigorespuesta , $mensajerespuesta ,
			$adjuntos);
		
		# EnviarEmailAdjunto($Asunto,$To,$TipoTexto,$Contenido, $RutaAdjunto = '' , $tipoAdjunto = '' , $nombreArchivoAdjunto = ''   ,  &$bResultadoEnvio, &$codigorespuesta, &$mensajerespuesta
		#$RutaAdjunto = '' , $tipoAdjunto = '' , $nombreArchivoAdjunto = ''
		//var_dump($bResultadoEnvio);
		if($bResultadoEnvio )
		{
			$movimientos->adm_actualizar_ReglamentoPostulante('2',$value['identificador'],'1',$mensajerespuesta,$codigorespuesta,'');
			
		} else
		{
			$movimientos->adm_actualizar_ReglamentoPostulante('2',$value['identificador'],'2',$mensajerespuesta,$codigorespuesta,'');
		}
		
	}
}

?>
