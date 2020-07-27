<?php
include_once 'vendor/autoload.php';
//define('LIB','/var/www/LIBRERIAS/vendor/');
class Email {
    private $EMAIL;
    private $SENDGRID;
    private $APIKEY;
    private $FROM;
    private $HTTPCODEOK;

    protected function getApikey()
    {
        $this->APIKEY = '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';
        return $this->APIKEY;
    }
    protected function getFrom(){
        $this->FROM = 'noreply@uladech.edu.pe';
        return $this->FROM;
    }
    protected function getEmail(){
        $this->EMAIL= new \SendGrid\Mail\Mail();
        return $this->EMAIL;
    }
    protected function getSendGrid(){
        $this->SENDGRID = new \SendGrid($this->getApikey());
        return $this->SENDGRID;
    }
    protected function getHttpCode()
    {
        $this->HTTPCODEOK = 202;
        return $this->HTTPCODEOK;
    }
    public function EnviarEmail($Asunto,$To,$TipoTexto,$Contenido, &$bResultadoEnvio, &$codigorespuesta, &$mensajerespuesta){
        $email = $this->getEmail();
        $email->setFrom($this->getFrom(), "Centro de Atención al Usuario - ULADECH");
        $email->setSubject($Asunto);
        $email->addTo($To['email'], $To['nombre']);
        $email->addContent($TipoTexto, $Contenido);

        try {

            $response =  $this->getSendGrid()->send($email);
            //$response =  $this->getSendGrid()->send('');
            // print $response->statusCode() . "\n";
             //print_r ($response->headers());
            // print_r ($response->body());

            if ( $response->statusCode() == $this->getHttpCode() ){
                $bResultadoEnvio = true;

            }  else
            {
                $bResultadoEnvio = false;
            }

            $codigorespuesta = $response->statusCode();
            //print $response->body();
            $mensajerespuesta = 'ENVIO EXITOSO';


        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
            $bResultadoEnvio = false;
            $codigorespuesta = -999;
            $mensajerespuesta = $e->getMessage();
        }

    }
    
    public function EnviarEmailConvenio($Asunto,$Suscrito,$To,$TipoTexto,$Contenido, &$bResultadoEnvio, &$codigorespuesta, &$mensajerespuesta){
        $email = $this->getEmail();
        $email->setFrom($Suscrito, "Dirección de Cooperación - ULADECH");
        $email->setSubject($Asunto);
        $email->addTo($To['email'], $To['nombre']);
        $email->addContent($TipoTexto, $Contenido);

        try {

            $response =  $this->getSendGrid()->send($email);
            if ( $response->statusCode() == $this->getHttpCode() ){
                $bResultadoEnvio = true;

            }  else
            {
                $bResultadoEnvio = false;
            }

            $codigorespuesta = $response->statusCode();
            $mensajerespuesta = 'ENVIO EXITOSO';

        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
            $bResultadoEnvio = false;
            $codigorespuesta = -999;
            $mensajerespuesta = $e->getMessage();
        }

    }
	
	
	public function EnviarEmailAdjunto($Asunto,$To,$TipoTexto,$Contenido,$emailadd,
	                                   &$bResultadoEnvio, &$codigorespuesta, &$mensajerespuesta , $adjuntos){
		
    	$arrayEmails = explode('|',$To['correodestinatariopersonal'] . '|' .$emailadd);
		#$arrayEmails = explode('|','fericell2909@gmail.com|fericell2909@gmail.com');
		$email = $this->getEmail();
		$email->setFrom($this->getFrom(), "Centro de Atención al Usuario - ULADECH");
		$email->setSubject($Asunto);
		//$email->addTo($To['email'], $To['nombre']);
		//$email->addTo('fericell2909@gmail.com','Marco Estrada Lopez');
		
		//$email->addTos($arrayEmails);
		$email->addTo($To['email'], $To['nombre']);
		//$email->addTo('fericell2909@gmail.com','Marco Estrada Lopez');
		
		$email->addBcc('egarciap@uladech.edu.pe', 'Elias Garcia');
		$email->addBcc('ktorresa@uladech.edu.pe', 'Karina Torres');
		//$email->addBcc('fericell@hotmail.com', 'Marco Estrada');
		//$email->addBcc('fericell2909@gmail.com', 'Marco Estrada');
		$email->addContent($TipoTexto, $Contenido);
		#var_dump($adjuntos);
		#print_r($adjuntos);
		if ( count($adjuntos) > 0 ){
			
			foreach($adjuntos as $value){
				
				$file_encoded=base64_encode(file_get_contents($value['rutaadjunto']));
				$email->addAttachment($file_encoded,$value['tipoadjunto'],$value['nombrearchivoadjunto'],"attachment");
				
			}
		}
		
		try {
			
			$response =  $this->getSendGrid()->send($email);
			//$response =  $this->getSendGrid()->send('');
			// print $response->statusCode() . "\n";
			// print_r ($response->headers());
			// print_r ($response->body());
			
			if ( $response->statusCode() == $this->getHttpCode() ){
				$bResultadoEnvio = true;
				// echo "Correcto";
			}  else
			{
				$bResultadoEnvio = false;
				// echo "Incorrecto";
			}
			
			$codigorespuesta = $response->statusCode();
			//print $response->body();
			$mensajerespuesta = 'ENVIO EXITOSO';
			
			//print $codigorespuesta . "\n";
			//print $bResultadoEnvio. "\n";
			
		} catch (Exception $e) {
			echo 'Caught exception: '. $e->getMessage() ."\n";
			$bResultadoEnvio = false;
			$codigorespuesta = -999;
			$mensajerespuesta = $e->getMessage();
		}
		
		
	}
	
	public function EnviarEmailBcc($Asunto,$To,$TipoTexto,$Contenido, $emailbcc, &$bResultadoEnvio, &$codigorespuesta, &$mensajerespuesta){
		$email = $this->getEmail();
		$email->setFrom($this->getFrom(), "Centro de Atención al Usuario - ULADECH");
		$email->setSubject($Asunto);
		$email->addTo($To['email'], $To['nombre']);
		//$email->addTo($emailbcc,'Marco Estrada Lopez');
		$email->addContent($TipoTexto, $Contenido);
		
		try {
			
			$response =  $this->getSendGrid()->send($email);
			//$response =  $this->getSendGrid()->send('');
			// print $response->statusCode() . "\n";
			//print_r ($response->headers());
			// print_r ($response->body());
			
			if ( $response->statusCode() == $this->getHttpCode() ){
				$bResultadoEnvio = true;
				
			}  else
			{
				$bResultadoEnvio = false;
			}
			
			$codigorespuesta = $response->statusCode();
			//print $response->body();
			$mensajerespuesta = 'ENVIO EXITOSO';
			
			
		} catch (Exception $e) {
			echo 'Caught exception: '. $e->getMessage() ."\n";
			$bResultadoEnvio = false;
			$codigorespuesta = -999;
			$mensajerespuesta = $e->getMessage();
		}
		
	}
	
	public function EnviarCarnePostulante($Asunto,$To,$TipoTexto,$Contenido,
	                                   &$bResultadoEnvio, &$codigorespuesta, &$mensajerespuesta , $adjuntos){
    	
		$email=$this->getEmail();
		$email->setFrom($this->getFrom(),"Centro de Atención al Usuario");
		$email->setSubject($Asunto);
		
		$email->addTo($To['email'],$To['nombre']);
		$email->addContent($TipoTexto, $Contenido);
		
		if ( count($adjuntos) > 0 ){
			
			foreach($adjuntos as $value){
				
				$file_encoded=base64_encode(file_get_contents($value['rutaadjunto']));
				$email->addAttachment($file_encoded,$value['tipoadjunto'],$value['nombrearchivoadjunto'],"attachment");
				
			}
		}
		
		try {
			
			$response =  $this->getSendGrid()->send($email);
			//$response =  $this->getSendGrid()->send('');
			// print $response->statusCode() . "\n";
			// print_r ($response->headers());
			// print_r ($response->body());
			
			if ( $response->statusCode() == $this->getHttpCode() ){
				$bResultadoEnvio = true;
				// echo "Correcto";
			}  else
			{
				$bResultadoEnvio = false;
				// echo "Incorrecto";
			}
			
			$codigorespuesta = $response->statusCode();
			//print $response->body();
			$mensajerespuesta = 'ENVIO EXITOSO';
			
			//print $codigorespuesta . "\n";
			//print $bResultadoEnvio. "\n";
			
		} catch (Exception $e) {
			echo 'Caught exception: '. $e->getMessage() ."\n";
			$bResultadoEnvio = false;
			$codigorespuesta = -999;
			$mensajerespuesta = $e->getMessage();
		}
		
		
	}
	
	public function EnviarEmailWithBcc($Asunto,$To,$bcc ,$TipoTexto,$Contenido, &$bResultadoEnvio, &$codigorespuesta, &$mensajerespuesta){
		
    	$email = $this->getEmail();
		$email->setFrom($this->getFrom(), "Centro de Atención al Usuario - ULADECH");
		$email->setSubject($Asunto);
		$email->addTo($To['email'], $To['nombre']);
		
		IF (is_array($bcc))
		{
			foreach($bcc as  $dt)
			{
				$email->addBcc($dt['email'], $dt['nombre']);
			}
		}
		
		
		$email->addContent($TipoTexto, $Contenido);
		
		try {
			
			$response =  $this->getSendGrid()->send($email);
			
			if ( $response->statusCode() == $this->getHttpCode() ){
				$bResultadoEnvio = true;
				
			}  else
			{
				$bResultadoEnvio = false;
			}
			
			$codigorespuesta = $response->statusCode();
			//print $response->body();
			$mensajerespuesta = 'ENVIO EXITOSO';
			
			
		} catch (Exception $e) {
			echo 'Caught exception: '. $e->getMessage() ."\n";
			$bResultadoEnvio = false;
			$codigorespuesta = -999;
			$mensajerespuesta = $e->getMessage();
		}
		
	}
}
