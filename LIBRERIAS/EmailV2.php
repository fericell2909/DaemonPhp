<?php

use SendGrid\Mail\EmailAddress;

include_once 'vendor/autoload.php';

class EmailV2 {
	
	private $EMAIL;
	private $SENDGRID;
	private $APIKEY;
	private $FROM;
	private $HTTPCODEOK;
	
	private $dao;
	
	function __construct($dao)
	{
		$this->dao = $dao;
	}
	protected function getApikey(){
		
		//$apiemail=new apiemail();
		$result = $this->dao->getTokenApiEmail();
		$this->APIKEY=$result;
		
		return $this->APIKEY;
	}
	
	protected function getFrom(){
		
		$this->FROM='noreply@uladech.edu.pe';
		
		return $this->FROM;
	}
	
	protected function getEmail(){
		
		$this->EMAIL=new \SendGrid\Mail\Mail();
		
		return $this->EMAIL;
	}
	
	protected function getSendGrid(){
		
		$this->SENDGRID=new \SendGrid($this->getApikey());
		
		return $this->SENDGRID;
	}
	
	protected function getHttpCode(){
		
		$this->HTTPCODEOK=202;
		
		return $this->HTTPCODEOK;
	}
	
	public function SendMail($Dominio,$Modulo,$Usuario,$From,$Asunto,$Tos,$Ccos,$Bccos,$TipoTexto,$Contenido,$Adjuntos,&$bResultadoEnvio='',&$codigorespuesta='',&$mensajerespuesta=''){
		
		$apiemail = $this->dao;
		
		$email=$this->getEmail();
		$email->setFrom($this->getFrom(),$From);
		$email->setSubject($Asunto);
		
		if($Tos!=''){
			if(strpos($Tos,'|')!=''){
				$arrayEmails=explode('|',$Tos);
				$email->addTos($arrayEmails);
			}else{
				$email->addTo($Tos);
			}
		}
		
		if($Ccos!=''){
			if(strpos($Ccos,'|')!=''){
				$arrayEmailCc=explode('|',$Ccos);
				$email->addCcs($arrayEmailCc);
			}else{
				$email->addCc($Ccos);
			}
		}
		
		if($Bccos!=''){
			if(strpos($Bccos,'|')!=''){
				$arrayEmailBc=explode('|',$Bccos);
				$email->addBccs($arrayEmailBc);
			}else{
				$email->addBcc($Bccos);
			}
		}
		
		if($Adjuntos!=''){
			if(strpos($Adjuntos,'|')!=''){
				$arrayAdjuntos=explode('|',$Adjuntos);
				if(count($arrayAdjuntos)>0){
					for($i=0; $i<count($arrayAdjuntos); $i++){
						$file_encoded=base64_encode(file_get_contents($arrayAdjuntos[$i]));
						$email->addAttachment($file_encoded,'.pdf','nameprueba.pdf',"attachment");
					}
				}
			}
		}
		
		$email->addContent($TipoTexto,$Contenido);
		
		try{
			$response=$this->getSendGrid()->send($email);
			
			if($response->statusCode()==$this->getHttpCode()){ //202
				$bResultadoEnvio=true;
			}else{
				$bResultadoEnvio=false;
			}
			
			$rptaArray='';
			$codigorespuesta=$response->statusCode();
			$rpta=$response->headers();
			for($i=0; $i<=12; $i++){
				$rptaArray.=$rpta[$i];
			}
			
			if($TipoTexto=='text/html'){
				$Contenido=htmlspecialchars($Contenido,ENT_QUOTES,'ISO-8859-1',false);
			}
			
			$result=$apiemail->saveResponseMail($Dominio,$Modulo,$From,$Asunto,$Tos,$Ccos,$Bccos,$TipoTexto,$Contenido,$Adjuntos,$codigorespuesta,$rptaArray,$rpta[0],$rpta[1],$rpta[2],$rpta[3],$rpta[4],$rpta[5],$rpta[6],$rpta[7],$rpta[8],$rpta[9],$rpta[10],$rpta[11],$rpta[12],$Usuario);
			
			$mensajerespuesta='ENVIO EXITOSO';
			
			return $result;
		}catch(Exception $e){
			$rptaArray='';
			$codigorespuesta=$response->statusCode();
			$rpta=$response->headers();
			for($i=0; $i<=12; $i++){
				$rptaArray.=$rpta[$i];
			}
			
			$result=$apiemail->saveResponseMail($Dominio,$Modulo,$From,$Asunto,$Tos,$Ccos,$Bccos,$TipoTexto,$Contenido,$Adjuntos,$codigorespuesta,$rptaArray,$rpta[0],$rpta[1],$rpta[2],$rpta[3],$rpta[4],$rpta[5],$rpta[6],$rpta[7],$rpta[8],$rpta[9],$rpta[10],$rpta[11],$rpta[12],$Usuario);
			
			$bResultadoEnvio=false;
			$mensajerespuesta=$e->getMessage();
			
			return $result;
		}
	}
	
	public function SendMail2($Dominio,$Modulo,$Usuario,$From,$Asunto,$Tos,$Ccos,$Bccos,$TipoTexto,$Contenido,$Adjuntos,&$bResultadoEnvio='',&$codigorespuesta='',&$mensajerespuesta=''){
		
		$apiemail=new apiemail();
		
		$email=$this->getEmail();
		$email->setFrom($this->getFrom(),$From);
		$email->setSubject($Asunto);
		
		if($Tos!=''){
			if(strpos($Tos,'|')!=''){
				$arrayEmails=explode('|',$Tos);
				$email->addTos($arrayEmails);
			}else{
				$email->addTo($Tos);
			}
		}
		
		if($Ccos!=''){
			if(strpos($Ccos,'|')!=''){
				$arrayEmailCc=explode('|',$Ccos);
				$email->addCcs($arrayEmailCc);
			}else{
				$email->addCc($Ccos);
			}
		}
		
		if($Bccos!=''){
			if(strpos($Bccos,'|')!=''){
				$arrayEmailBc=explode('|',$Bccos);
				$email->addBccs($arrayEmailBc);
			}else{
				$email->addBcc($Bccos);
			}
		}
		
		if($Adjuntos!=''){
			if(strpos($Adjuntos,'|')!=''){
				$arrayAdjuntos=explode('|',$Adjuntos);
				if(count($arrayAdjuntos)>0){
					for($i=0; $i<count($arrayAdjuntos); $i++){
						$nombrearchivo='ULADECH.pdf';
						$rutaarchivo='';
						
						if(strpos($arrayAdjuntos[$i],'°')!=''){
							$adjunto=explode('°',$arrayAdjuntos[$i]);
							if(count($adjunto)>1){
								$rutaarchivo=$adjunto[0];
								$nombrearchivo=$adjunto[1];
							}else{
								$rutaarchivo=$adjunto;
							}
						}else{
							$rutaarchivo=$arrayAdjuntos[$i];
						}
						if($rutaarchivo!=''){
							$file_encoded=base64_encode(file_get_contents($rutaarchivo));
							$email->addAttachment($file_encoded,'.pdf',$nombrearchivo,"attachment");
						}
					}
				}
			}else{
				$nombrearchivo='ULADECH.pdf';
				$rutaarchivo='';
				
				if(strpos($Adjuntos,'°')!=''){
					$adjunto=explode('°',$Adjuntos);
					if(count($adjunto)>1){
						$rutaarchivo=$adjunto[0];
						$nombrearchivo=$adjunto[1];
					}else{
						$rutaarchivo=$adjunto;
					}
				}else{
					$rutaarchivo=$Adjuntos;
				}
				if($rutaarchivo!=''){
					$file_encoded=base64_encode(file_get_contents($rutaarchivo));
					$email->addAttachment($file_encoded,'.pdf',$nombrearchivo,'');
				}
			}
		}
		
		$email->addContent($TipoTexto,$Contenido);
		
		try{
			$response=$this->getSendGrid()->send($email);
			
			if($response->statusCode()==$this->getHttpCode()){ //202
				$bResultadoEnvio=true;
			}else{
				$bResultadoEnvio=false;
			}
			
			$rptaArray='';
			$codigorespuesta=$response->statusCode();
			$rpta=$response->headers();
			for($i=0; $i<=12; $i++){
				$rptaArray.=$rpta[$i];
			}
			
			if($TipoTexto=='text/html'){
				$Contenido=htmlspecialchars($Contenido,ENT_QUOTES,'ISO-8859-1',false);
			}
			
			$result=$apiemail->saveResponseMail($Dominio,$Modulo,$From,$Asunto,$Tos,$Ccos,$Bccos,$TipoTexto,$Contenido,$Adjuntos,$codigorespuesta,$rptaArray,$rpta[0],$rpta[1],$rpta[2],$rpta[3],$rpta[4],$rpta[5],$rpta[6],$rpta[7],$rpta[8],$rpta[9],$rpta[10],$rpta[11],$rpta[12],$Usuario);
			
			$mensajerespuesta='ENVIO EXITOSO';
			
			return $result;
		}catch(Exception $e){
			$rptaArray='';
			$codigorespuesta=$response->statusCode();
			$rpta=$response->headers();
			for($i=0; $i<=12; $i++){
				$rptaArray.=$rpta[$i];
			}
			
			$result=$apiemail->saveResponseMail($Dominio,$Modulo,$From,$Asunto,$Tos,$Ccos,$Bccos,$TipoTexto,$Contenido,$Adjuntos,$codigorespuesta,$rptaArray,$rpta[0],$rpta[1],$rpta[2],$rpta[3],$rpta[4],$rpta[5],$rpta[6],$rpta[7],$rpta[8],$rpta[9],$rpta[10],$rpta[11],$rpta[12],$Usuario);
			
			$bResultadoEnvio=false;
			$mensajerespuesta=$e->getMessage();
			
			return $result;
		}
	}

	public function SendMail_Con_Adjuntos($Dominio,$Modulo,$Usuario,$From,$Asunto,$Tos,$Ccos,$Bccos,$TipoTexto,$Contenido,$Adjuntos,&$bResultadoEnvio='',&$codigorespuesta='',&$mensajerespuesta='' , $adjuntos)
	{
		
		$apiemail = $this->dao;
		
		$email=$this->getEmail();
		$email->setFrom($this->getFrom(),$From);
		$email->setSubject($Asunto);
		
		if($Tos!=''){
			if(strpos($Tos,'|')!=''){
				$arrayEmails=explode('|',$Tos);
				$email->addTos($arrayEmails);
			}else{
				$email->addTo($Tos);
			}
		}
		
		if($Ccos!=''){
			if(strpos($Ccos,'|')!=''){
				$arrayEmailCc=explode('|',$Ccos);
				$email->addCcs($arrayEmailCc);
			}else{
				$email->addCc($Ccos);
			}
		}
		
		if($Bccos!=''){
			if(strpos($Bccos,'|')!=''){
				$arrayEmailBc=explode('|',$Bccos);
				$email->addBccs($arrayEmailBc);
			}else{
				$email->addBcc($Bccos);
			}
		}
		
		if($Adjuntos!=''){
			if(strpos($Adjuntos,'|')!=''){
				$arrayAdjuntos=explode('|',$Adjuntos);
				if(count($arrayAdjuntos)>0){
					for($i=0; $i<count($arrayAdjuntos); $i++){
						$file_encoded=base64_encode(file_get_contents($arrayAdjuntos[$i]));
						$email->addAttachment($file_encoded,'.pdf','nameprueba.pdf',"attachment");
					}
				}
			}
		}
		
		$email->addContent($TipoTexto,$Contenido);
		
		if ( count($adjuntos) > 0 ){
			
			foreach($adjuntos as $value){
				
				$file_encoded=base64_encode(file_get_contents($value['rutaadjunto']));
				$email->addAttachment($file_encoded,$value['tipoadjunto'],$value['nombrearchivoadjunto'],"attachment");
				
			}
		}
		
		try{
			$response=$this->getSendGrid()->send($email);
			
			if($response->statusCode()==$this->getHttpCode()){ //202
				$bResultadoEnvio=true;
			}else{
				$bResultadoEnvio=false;
			}
			
			$rptaArray='';
			$codigorespuesta=$response->statusCode();
			$rpta=$response->headers();
			for($i=0; $i<=12; $i++){
				$rptaArray.=$rpta[$i];
			}
			
			if($TipoTexto=='text/html'){
				$Contenido=htmlspecialchars($Contenido,ENT_QUOTES,'ISO-8859-1',false);
			}
			
			$result=$apiemail->saveResponseMail($Dominio,$Modulo,$From,$Asunto,$Tos,$Ccos,$Bccos,$TipoTexto,$Contenido,$Adjuntos,$codigorespuesta,$rptaArray,$rpta[0],$rpta[1],$rpta[2],$rpta[3],$rpta[4],$rpta[5],$rpta[6],$rpta[7],$rpta[8],$rpta[9],$rpta[10],$rpta[11],$rpta[12],$Usuario);
			
			$mensajerespuesta='ENVIO EXITOSO';
			
			return $result;
		}catch(Exception $e){
			$rptaArray='';
			$codigorespuesta=$response->statusCode();
			$rpta=$response->headers();
			for($i=0; $i<=12; $i++){
				$rptaArray.=$rpta[$i];
			}
			
			$result=$apiemail->saveResponseMail($Dominio,$Modulo,$From,$Asunto,$Tos,$Ccos,$Bccos,$TipoTexto,$Contenido,$Adjuntos,$codigorespuesta,$rptaArray,$rpta[0],$rpta[1],$rpta[2],$rpta[3],$rpta[4],$rpta[5],$rpta[6],$rpta[7],$rpta[8],$rpta[9],$rpta[10],$rpta[11],$rpta[12],$Usuario);
			
			$bResultadoEnvio=false;
			$mensajerespuesta=$e->getMessage();
			
			return $result;
		}
	}
}
