<?php

include_once ('/var/www/CONEXIONES/DEMO/database.php');
//include_once('C:\xampp\htdocs\daemonsuladech\CONEXIONES\DEVELOPER');
class General extends Database
{
	
	public function Asis_MarcadorConsultar($xFlag = '', $xCriterio = ''){
		$data = array();
		$sql = "CALL sp_apiAsisMarcadorConsultar('$xFlag','$xCriterio')";
		//         echo $sql;exit;
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	public function Asis_MarcadorMantenimiento($xFlag = '', $xAnio = '', $xListaMarcacion = '', $xIp = '0.0.0.0', $xMac = '00:00:00:00:00:00', $xActivoCodigo = '', $xTotalRegistrosMarcador = 0, $xResumenMarcacion = '',$xOnline = '0', $xUsuarioCrea = ''){
		$data = array();
		$sql = "CALL sp_apiAsisMarcadorMantenimiento(
                                            '{$xFlag}',
                                            '{$xAnio}',
                                            '{$xListaMarcacion}',
                                            '{$xIp}',
                                            '{$xMac}',
                                            '{$xActivoCodigo}',
                                             {$xTotalRegistrosMarcador},
                                            '{$xResumenMarcacion}',
                                            '{$xOnline}',
                                            '{$xUsuarioCrea}'
                )";
		//         echo $sql;
		//         exit;
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	public function Asis_MarcadorSincronizacion($xFlag = '', $xFechaInicio = '0000-00-00', $xFechaTermino = '0000-00-00', $xListaPersona = '', $xTotalPersona = '0', $xListaEstructura = '', $xTotalEstructura = 0, $xUsuario = ''){
		$data = array();
		$sql = "CALL sp_apiAsisSincronizarMarcacion(
                                            '{$xFlag}',
                                            '{$xFechaInicio}',
                                            '{$xFechaTermino}',
                                            '{$xListaPersona}',
                                            '{$xTotalPersona}',
                                            '{$xListaEstructura}',
                                             {$xTotalEstructura},
                                            '{$xUsuario}'
                )";
		//         echo $sql;
		//         exit;
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	
	public function Asis_UsuarioMantenimiento($xFlag = '', $xCriterio = '', $xCantidad = 0){
		$data = array();
		$sql = "CALL sp_apiAsistUsuarioMantenimiento(
                                            '{$xFlag}',
                                            '{$xCriterio}',
                                             {$xCantidad}
                )";
		//         echo $sql;
		//         exit;
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	
	#mestradal - 24.09.2019
	public function Cert_Consultar_InicioCapacitaciones($flag){
		$data = array();
		$sql = "CALL sp_apiCertMantenimientoEnvioCorreoInicioCapacitacion('$flag','','','','','','')";
		// echo $sql;exit;
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	
	public function Cert_Actualizar_InicioCapacitaciones($flag,$identificador,$estado,$mensajerespuesta,$codigorespuesta)
	{
		$data = array();
		$sql = "CALL sp_apiCertMantenimientoEnvioCorreoInicioCapacitacion('" . $flag . "','" . $identificador . "','','" . $codigorespuesta . "','" . $estado . "','" . $mensajerespuesta ."','')";
		
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
	}
	
	
	public function Grui_Consultar_VencimientoConvenio($flag){
		$data = array();
		$sql = "CALL sp_apiGruiMantenimientoEnvioCorreoVencimientoConvenio_V2('$flag','','','','','','','')";
		// echo $sql;exit;
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	
	public function Grui_Actualizar_VencimientoConvenio($flag,$identificador,$estado,$mensajerespuesta,$codigorespuesta)
	{
		$data = array();
		$sql = "CALL sp_apiGruiMantenimientoEnvioCorreoVencimientoConvenio_V2('" . $flag . "','" . $identificador . "','','','" . $codigorespuesta . "','" . $estado . "','" . $mensajerespuesta ."','')";
		
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
	}
	
	public function Grui_Consultar_VencimientoPlanTrabajo($flag){
		$data = array();
		$sql = "CALL sp_apiGruiMantenimientoEnvioCorreoVencimientoPlanTrabajo('$flag','','','','','','','','')";
		// echo $sql;exit;
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	
	public function Grui_Actualizar_VencimientoPlanTrabajo($flag,$identificador,$estado,$mensajerespuesta,$codigorespuesta)
	{
		$data = array();
		$sql = "CALL sp_apiGruiMantenimientoEnvioCorreoVencimientoPlanTrabajo('" . $flag . "','" . $identificador . "','','','','" . $codigorespuesta . "','" . $estado . "','" . $mensajerespuesta ."','')";
		
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
	}
	
	public function Cert_ConsultarMovimientos($flag)
	{
		
		$data = array();
		$sql = "CALL sp_apiCertMantenimientoEnvioCorreoMovimientoBandeja('" . $flag . "','','','','','','','','','')";
		//echo $sql;exit;
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	
	public function Cert_ActualizarMovimientos($flag,$identificador,$estado,$mensajerespuesta,$codigorespuesta)
	{
		$data = array();
		$sql = "CALL sp_apiCertMantenimientoEnvioCorreoMovimientoBandeja('" . $flag . "','" . $identificador . "','','','','" . $codigorespuesta . "','" . $estado . "','" . $mensajerespuesta ."','','')";
		
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
	}
	
	public function Grui_ConsultarMovimientos($flag)
	{
		
		$data = array();
		$sql = "CALL sp_apiGruiMantenimientoEnvioCorreoMovimientoBandeja('" . $flag . "','','','','','','','','','')";
		//echo $sql;exit;
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	
	public function Grui_ActualizarMovimientos($flag,$identificador,$estado,$mensajerespuesta,$codigorespuesta)
	{
		$data = array();
		$sql = "CALL sp_apiGruiMantenimientoEnvioCorreoMovimientoBandeja('" . $flag . "','" . $identificador . "','','','','" . $codigorespuesta . "','" . $estado . "','" . $mensajerespuesta ."','','')";
		
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
	}
	
	# mestradal 30.09.2019
	public function adm_consultar_ReglamentoPostulante($flag){
		$data = array();
		$sql = "CALL spweb_AdMantenedorEnvioCorreoRegitroPostulantes('$flag','','','','','','','');";
		
		// echo $sql;exit;
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	
	public function adm_actualizar_ReglamentoPostulante($flag,$identificador,$estado,$mensajerespuesta,$codigorespuesta)
	{
		$data = array();
		$sql = "CALL spweb_AdMantenedorEnvioCorreoRegitroPostulantes('" . $flag . "','" . $identificador . "','','','" . $codigorespuesta . "','" . $estado . "','" . $mensajerespuesta ."','')";
		
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
	}
	
	public function adm_obtener_archivos_adjuntos_postulantes($flag , $identificador) {
		
		$data = array();
		$sql = "CALL spweb_AdMantenedorEnvioCorreoRegitroPostulantes('$flag','" . $identificador . "','','','','','','');";
		#echo $sql;
		
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	
	public function adm_listar_postulantes_envio_carne()
	{
		
		$data = array();
		
		$sql = "call sp_admision_listar_preinscripcionpostulante ('',0,0,3)";
		// echo $sql;exit;
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	
	function actualizar_envio_correo($postulante , $indiceregistro , $usuario,$codigorespuesta , $mensajerespuesta,$param_concat_res_correo='0|0',$tipoenvio = '0')
	{
		$data = array();
		$query  = "call sp_admision_registrar_preinscripcion_postulante('4','$postulante',$indiceregistro,'$mensajerespuesta','$codigorespuesta','$param_concat_res_correo','$tipoenvio','',NULL,'0','0','','','','','','','','','','','','','','','','','','','','','','','','','','$usuario','0');";
		//echo $query;             exit;
		
		$result = parent::query($query);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	
	function ConstanciaIngreso($postulante,$periodo,$sede,$escuela,$modalidad,$fase,$tipo = 'A')
	{
		
		$data      = array();
		$escuela   = $escuela=='_all_'?'%':   $escuela;
		$modalidad = $modalidad=='_all_'?'%': $modalidad;
		
		$query     = "CALL spweb_AdConstanciaInsgresoLote('$sede','$periodo','$escuela','$modalidad','$tipo','$postulante','$fase')";
		
		$result = parent::query($query);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		
		return $data;
		
	}
	
	function mantenedora_envio_constancia_admision($tipo , $criterio = '' , $codigorespuesta = '' , $mensajerespuesta  = '', $ippublica = '', $iplocal = '', $usuario = '')
	{
		
		
		$data = array();
		
		$query = "call sp_admision_mantenedora_envio_constancia ( ".$tipo." , '" . $criterio . "','" . $codigorespuesta . "','" . $mensajerespuesta . "','" . $ippublica . "','".$iplocal."','".$usuario."');";
		

		
		$result = parent::query($query);
		
		if (!isset($result['error'])) {
			foreach ($result as $value) {
				$data[] = $value;
			}
		} else {
			$this->setMsgErr($result['error']);
		}
		
		return $data;
		
	}
	
	function getTokenApiEmail() {
		$data = array();
		$sql = " CALL sp_apiConsultarParametro('TOKENEMAIL')";
		$result = parent::query($sql);
		if (!isset($result['error'])) {
			
			$data = $result[0]['valor'];
			
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
	public function consultarTiposUsuarios() {
		$data = array();
		
		$sql = "call sp_loginConsultarTiposUsuarios()";
		
		$result = mysqli_query($this->link, $sql);
		if ($result) {
			if (mysqli_more_results($this->link)) {
				mysqli_next_result($this->link);
				while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
					$item = array();
					foreach ($row as $col_label => $col_value) {
						$item[$col_label] = $col_value;
					}
					$data[] = $item;
				}
			}
		} else {
			$this->setMsgErr($this->messageError(mysqli_errno($this->link)));
		}
		
		return $data;
	}
	function saveResponseMail($Dominio,$Modulo,$From,$Asunto,$Tos,$Ccos, $Bccos, $TipoTexto,$Contenido, $Adjuntos
		, $codRpta, $rptaArray, $rpta00, $rpta01, $rpta02, $rpta03, $rpta04, $rpta05, $rpta06, $rpta07, $rpta08
		, $rpta09, $rpta10, $rpta11, $rpta12,$Usuario){
		$data = array();
		$sql = " CALL sp_apiSaveResponseMail('01','', '$Dominio','$Modulo','$From','$Asunto','$Tos','$Ccos','$Bccos','$TipoTexto','$Contenido','$Adjuntos',
                                             '$codRpta','$rptaArray','$rpta00','$rpta01','$rpta02','$rpta03','$rpta04','$rpta05','$rpta06','$rpta07','$rpta08',
                                             '$rpta09','$rpta10','$rpta11','$rpta12','$Usuario')";
		
		$result = parent::query($sql);
		
		if (!isset($result['error'])) {
			
			$data = $result[0]['mensaje'];
			
		} else {
			$this->setMsgErr($result['error']);
		}
		return $data;
	}
}
?>