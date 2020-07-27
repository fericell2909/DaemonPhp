<?php

define('RUTA','/var/www/CROM/DEVELOPER/');
define('LIB','/var/www/LIBRERIAS/');


include_once  RUTA . 'index.php';
include_once LIB.'Email.php';
include_once LIB.'EmailV2.php';

function generar_archivo_adjunto( $resultado ,$postulante,$semestre,$sede,$escuela,$modalidadingreso,$fase , $namefile )
{
	#$namefile        = $postulante.$sede.$escuela.$semestre;
	$namefilemostrar = $postulante.'-'.$sede.'-'.$escuela.'-'.$semestre;
	#print_r($resultado);
	if(count($resultado)>0){
		foreach ($resultado[0] as $key => $valor) {
			$$key = $valor;
		}
	}
	$ruta_imagen_base = RUTA . 'ERPUNIVERSITY/MODULO_ADMISION/uladech.jpg';
	#$ruta_imagen_base = 'uladech.jpg';
	
	$img = imagecreatefromjpeg($ruta_imagen_base);
	$im  = imagecreatetruecolor(650,220); //im_destino contendrá la nueva imagen recortada
	
	imagecopy($im, $img, 0, 0, 0, 0, 500,280);
	$textofoto = "FOTO";
	
	$blanco = imagecolorallocate($im, 255, 255, 255);
	$gris   = imagecolorallocate($im, 128, 128, 128);
	$negro  = imagecolorallocate($im, 0, 0, 0);
	imagecolortransparent($im, $negro);
	
	#imagefilledrectangle($im, 70, 0, 650, 220, $blanco); //relleno el fondo
	#imagefilledrectangle($im, 0, 52, 399, 220, $blanco);
	$negro      = imagecolorallocate($im, 2, 0, 0);
	$colortexto = imagecolorallocate($im, 2, 0, 0);
	imageline($im,325,0,325,250,$negro);
	imageline($im,370,180,470,180,$negro);
	imageline($im,520,180,620,180,$negro);
	imagerectangle ($im, 230, 90, 320, 210, $negro);
	imagestring($im, 3, 260, 140, $textofoto, $colortexto);
	imagestring($im, 2, 395, 185, utf8_decode("Admisión                Postulante"), $colortexto);
	
	#$font = '../../font/timesbd.ttf';
	
	// Add some shadow to the text
	#imagettftext($im, 10, 0, 67, 15, $colortexto, $font, utf8_decode("UNIVERSIDAD CATÓLICA LOS ANGELES"));
	
	imagestring($im, 3, 85, 10, utf8_decode("UNIVERSIDAD CATÓLICA LOS ANGELES"), $colortexto);
	imagestring($im, 3, 150, 25, "DE CHIMBOTE", $colortexto);
	//imagestring($im, 3, 130, 40, "CRECEMOS CONTIGO", $colortexto);
	imagestring($im, 5, 90, 60, utf8_decode("CARNÉ POSTULANTE"), $colortexto);
	####datos Basicos del Postulante###############################
	imagestring($im, 3, 5, 115, "Apellido Paterno :", $colortexto);
	imagestring($im, 2, 145, 115, utf8_decode($apellidopaterno), $colortexto);
	imagestring($im, 3, 5, 135, "Apellido Materno :", $colortexto);
	imagestring($im, 2, 145, 135, utf8_decode($apellidomaterno), $colortexto);
	imagestring($im, 3, 5, 155, "Primer Nombre    :", $colortexto);
	imagestring($im, 2, 145, 155, utf8_decode($primernombre), $colortexto);
	imagestring($im, 3, 5, 175, "Segundo Nombre   :", $colortexto);
	imagestring($im, 2, 145, 175, utf8_decode($segundonombre), $colortexto);
	imagestring($im, 5, 80, 200, $postulante, $colortexto);
	//
	###Datos de Postulacion########################################
	
	#imagestring($im, 3, 350, 10, "Facultad     :", $colortexto);
	#imagestring($im, 2, 450, 10, utf8_decode($facultadinsc), $colortexto);
	imagestring($im, 3, 350, 10, "         PROGRAMA DE ESTUDIO", $colortexto);#30
	imagestring($im, 3, 350, 50, "Primera Opc.:", $colortexto);#30
	imagestring($im, 2, 450, 50, utf8_decode($nomescuelainsc), $colortexto);#30
	#nombre completo de la maestria,doctorado y segu da especialidad
	
	if(/*$sede=='01' and*/ ($nomescuelasegun)!='SIN ESCUELA DE INGRESO') {
		imagestring($im, 3, 350, 70, "Segunda Opc.:", $colortexto);#50
		imagestring($im, 2, 450, 70, utf8_decode($nomescuelasegun), $colortexto);#50
	}
	imagestring($im, 3, 350, 90, "Periodo      :", $colortexto);#70
	imagestring($im, 2, 450, 90, $periodo, $colortexto);#70
	
	#imagestring($im, 3, 350, 90, "Fase         :", $colortexto);
	#imagestring($im, 2, 450, 90, $fase, $colortexto);
	
	imagestring($im, 3, 350, 110, "Modalidad    :", $colortexto);
	imagestring($im, 2, 450, 110, utf8_decode($tipoingreso), $colortexto);
	
	imagestring($im, 3, 350, 130, "Fecha        :", $colortexto);
	imagestring($im, 2, 450, 130, $fechainscripcion, $colortexto);
	#imagestring($im, 3, 350, 110, $namefilemostrar, $colortexto);
	
	imagestring($im, 3, 385, 205, utf8_decode("CARNET PERSONAL E INSTRANSFERIBLE"), $colortexto);
	imagepng($im,RUTA . 'ERPUNIVERSITY/MODULO_ADMISION/'.$namefile);
	
}

$movimientos =  new General();

$data = $movimientos->adm_listar_postulantes_envio_carne();

if ( count($data) > 0) {
	
	$email = new Email();
	$email_v2 = new EmailV2($movimientos);
	
	$bResultadoEnvio = false;
	$codigorespuesta = -999;
	$mensajerespuesta = '';
	
	foreach($data as $value){
		
		if ($value['tipocorreoenvio'] == '1' && $value['pagocompromiso'] == '0')
		{
			
			/* No va adjunto carne de postulante.
			$adjuntos = array();
			$namefile        = 'C'.uniqid().'.png';
			$namefile = $value['postulante'].'.png';
			$data_carne_postulante =  $movimientos->ConstanciaIngreso($value['postulante'],$value['semestre'],$value['sede'],$value['estructura'] , $value['tipoingreso'] , 'A' ,'A');
			
			generar_archivo_adjunto($data_carne_postulante ,$value['postulante'],$value['semestre'],$value['sede'],$value['estructura'] ,$value['tipoingreso'],'A',$namefile);
			
			$url = RUTA . 'ERPUNIVERSITY/MODULO_ADMISION/'.$namefile;
			
			
			$adjuntos[0] = array('rutaadjunto'=> $url , 'tipoadjunto' => 'application/png'  , 'nombrearchivoadjunto' => $value['postulante'].'.png' );
			*/
			
			# Obtener
			
			/*
			$email->EnviarCarnePostulante($value['asuntocorreo'], array( 'email'=>$value['correo'],'nombre'=>$value['nombres']),
				'text/html' , $value['cuerpocorreo'] ,
				$bResultadoEnvio , $codigorespuesta , $mensajerespuesta ,
				$adjuntos);
			*/
			
			$resultado_envio_correo = $email_v2->SendMail('01','022','DAEMON','',$value['asuntocorreo'],$value['correo'],'','','text/html' , $value['cuerpocorreo'] ,'',$bResultadoEnvio , $codigorespuesta , $mensajerespuesta);
			
			// Eliminar Link temporal
			//unlink($url);
			
			$movimientos-> actualizar_envio_correo($value['postulante'] , $value['indice'] , 'DAEMON',$codigorespuesta , $mensajerespuesta,$resultado_envio_correo,$value['tipologenvio']);
			
			if(!$bResultadoEnvio){
				
				$email->EnviarEmailWithBcc($value['asuntoerrorcorreo'], array( 'email'=> $value['correoerror'],'nombre'=> $value['nombrecorreoerror']) , array( 'email'=> $value['correobccerror'],'nombre'=> $value['nombrebcccorreoerror']), $value['contenidoerrorcorreo'] , $bResultadoEnvio, $codigorespuesta, $mensajerespuesta);
				
			}
			
		}
		
		if($value['tipocorreoenvio'] == '1' && $value['pagocompromiso'] == '1')
		{
			
			
			$adjuntos = array();
			$namefile        = 'C'.uniqid().'.png';
			$namefile = $value['postulante'].'.png';
			
			$data_carne_postulante =  $movimientos->ConstanciaIngreso($value['postulante'],$value['semestre'],$value['sede'],$value['estructura'] , $value['TipoIngreso'] , 'A' ,'A');
			
			generar_archivo_adjunto($data_carne_postulante ,$value['postulante'],$value['semestre'],$value['sede'],$value['estructura'] ,$value['TipoIngreso'],'A',$namefile);
			
			$url = RUTA . 'ERPUNIVERSITY/MODULO_ADMISION/'.$namefile;
			
			
			
			$adjuntos[0] = array('rutaadjunto'=> $url , 'tipoadjunto' => 'application/png'  , 'nombrearchivoadjunto' => $value['postulante'].'.png' );
			
			
			/*
			$email->EnviarCarnePostulante($value['asuntocorreo'], array( 'email'=>$value['correo'],'nombre'=>$value['nombres']),
				'text/html' , $value['cuerpocorreo'] ,
				$bResultadoEnvio , $codigorespuesta , $mensajerespuesta ,
				$adjuntos);
			
			//unlink($url);
			*/
			
			$resultado_envio_correo = $email_v2->SendMail_Con_Adjuntos('01','022','DAEMON','',$value['asuntocorreo'],$value['correo'],'','','text/html' , $value['cuerpocorreo'] ,'',$bResultadoEnvio , $codigorespuesta , $mensajerespuesta,$adjuntos);
			
			
			// Eliminar Link temporal/
			unlink($url);
			
			$movimientos-> actualizar_envio_correo($value['postulante'] , $value['indice'] , 'DAEMON',$codigorespuesta , $mensajerespuesta,$resultado_envio_correo,$value['tipologenvio']);
			
			if(!$bResultadoEnvio){
				
				$email->EnviarEmailWithBcc($value['asuntoerrorcorreo'], array( 'email'=> $value['correoerror'],'nombre'=> $value['nombrecorreoerror']) , array( 'email'=> $value['correobccerror'],'nombre'=> $value['nombrebcccorreoerror']), $value['contenidoerrorcorreo'] , $bResultadoEnvio, $codigorespuesta, $mensajerespuesta);
				
			}
			
			
		}
		// Correo Rechazado y Anulado .
		if ($value['tipocorreoenvio'] == '2' or $value['tipocorreoenvio'] == '3')
		{
			/*
			$email->EnviarEmail($value['asuntocorreo'], array( 'email'=>$value['correo'],'nombre'=>$value['nombres']),
				'text/html' , $value['cuerpocorreo'] ,
				$bResultadoEnvio , $codigorespuesta , $mensajerespuesta );
			*/
			
			$resultado_envio_correo = $email_v2->SendMail('01','022','DAEMON','',$value['asuntocorreo'],$value['correo'],'','','text/html' , $value['cuerpocorreo'] ,'',$bResultadoEnvio , $codigorespuesta , $mensajerespuesta);
			
			// $movimientos->actualizar_envio_correo($value['postulante'] , $value['indice'] , 'DAEMON',$codigorespuesta , $mensajerespuesta);
			
			$movimientos-> actualizar_envio_correo($value['postulante'] , $value['indice'] , 'DAEMON',$codigorespuesta , $mensajerespuesta,$resultado_envio_correo,$value['tipologenvio']);
			
		}
		
		// Pago Compromiso postulante Modulo de Admision General
		if ($value['tipocorreoenvio'] == '9' )
		{
			
			$adjuntos = array();
			$namefile        = 'C'.uniqid().'.png';
			$namefile = $value['postulante'].'.png';
			
			$data_carne_postulante =  $movimientos->ConstanciaIngreso($value['postulante'],$value['semestre'],$value['sede'],$value['estructura'] , $value['TipoIngreso'] , 'A' ,'A');
			
			generar_archivo_adjunto($data_carne_postulante ,$value['postulante'],$value['semestre'],$value['sede'],$value['estructura'] ,$value['TipoIngreso'],'A',$namefile);
			
			$url = RUTA . 'ERPUNIVERSITY/MODULO_ADMISION/'.$namefile;
			
			
			
			$adjuntos[0] = array('rutaadjunto'=> $url , 'tipoadjunto' => 'application/png'  , 'nombrearchivoadjunto' => $value['postulante'].'.png' );
			
			
			$resultado_envio_correo = $email_v2->SendMail_Con_Adjuntos('01','022','DAEMON','',$value['asuntocorreo'],$value['correo'],@$value['correocopiaauditoria'],'','text/html' , $value['cuerpocorreo'] ,'',$bResultadoEnvio , $codigorespuesta , $mensajerespuesta,$adjuntos);
			
			
			// Eliminar Link temporal/
			unlink($url);
			
			$movimientos-> actualizar_envio_correo($value['postulante'] , $value['indice'] , 'DAEMON',$codigorespuesta , $mensajerespuesta,$resultado_envio_correo,$value['tipocorreoenvio']);
			
			if(!$bResultadoEnvio){
				
				$email->EnviarEmailWithBcc($value['asuntoerrorcorreo'], array( 'email'=> $value['correoerror'],'nombre'=> $value['nombrecorreoerror']) , array( 'email'=> $value['correobccerror'],'nombre'=> $value['nombrebcccorreoerror']), $value['contenidoerrorcorreo'] , $bResultadoEnvio, $codigorespuesta, $mensajerespuesta);
				
			}
			
			
		}
		
	}
}


// Correo de Constancia de Ingreso.

$movimientos_const = new General();

$data_constancias = $movimientos_const->mantenedora_envio_constancia_admision(2);

$email_constancia = new Email();

if( count($data_constancias) > 0 )
{
	
	foreach($data_constancias as $value){
		
		
		$bResultadoEnvio_constancia = false;
		$codigorespuestaconstancia = -999;
		$mensajerespuestaconstancia = '';
		
		/*
		$email->EnviarEmail($value['asuntocorreo'], array( 'email'=>$value['correo'],'nombre'=>$value['nombres']),
			'text/html' , $value['cuerpocorreo'] ,
			$bResultadoEnvio_constancia , $codigorespuestaconstancia , $mensajerespuestaconstancia );
		*/
		
		/*
		$email_constancia->EnviarEmail($value['asuntocorreo'], array( 'email'=>'fericell2909@gmail.com','nombre'=>$value['nombres']),
			'text/html' , $value['cuerpocorreo'] ,
			$bResultadoEnvio_constancia , $codigorespuestaconstancia , $mensajerespuestaconstancia );
		
		*/
		
		
		$email_constancia->EnviarEmailWithBcc($value['asuntocorreo'], array( 'email'=> $value['correo'],'nombre'=> $value['nombres']) ,
			array( 0 => array( 'email'=> 'mestradal@uladech.edu.pe' ,'nombre'=> 'Marco Estrada') ,
			       1 => array('email'=> 'efloresf@uladech.edu.pe' ,'nombre'=> 'Eder Flores'),
			       2 => array( 'email'=> 'ctorresq@uladech.edu.pe' ,'nombre'=> 'Carlos Torres') ,
			       3 => array('email'=> 'egarciap@uladech.edu.pe' ,'nombre'=> 'Elias')
			),'text/html' , $value['cuerpocorreo'] , $bResultadoEnvio_constancia , $codigorespuestaconstancia , $mensajerespuestaconstancia );
		
		
		/*
		$email_constancia->EnviarEmailWithBcc($value['asuntocorreo'], array( 'email'=> 'fericell2909@gmail.com','nombre'=> $value['nombres']) ,
			array( 0 => array( 'email'=> 'mestradal@uladech.edu.pe' ,'nombre'=> 'Marco Estrada') ,
			       1 => array('email'=> 'efloresf@uladech.edu.pe' ,'nombre'=> 'Eder Flores')
			),'text/html' , $value['cuerpocorreo'] , $bResultadoEnvio_constancia , $codigorespuestaconstancia , $mensajerespuestaconstancia );
		
		*/
		$movimientos_const_tmp = new General();
		
		$movimientos_const_tmp->mantenedora_envio_constancia_admision(3 , $value['identificador'] , $codigorespuestaconstancia , $mensajerespuestaconstancia );
		
		$movimientos_const_tmp = null;
	}
}


?>

