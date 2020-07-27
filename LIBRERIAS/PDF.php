<?php
include_once 'vendor/autoload.php';

class Email {
	
	private $MPDF;
	
	protected function getMPDF()
	{
		$this->MPDF = new \Mpdf\Mpdf();
		
	}
	
	public function generar_pdf($plantilla_html, $ruta = '/' ,$nombre_archivo = '')
	{
		$plantilla_html = '<h1>Hello world!</h1>';
		
		$mpdf = $this->getMPDF();
		
		$mpdf->WriteHTML($plantilla_html);
		
		$mpdf->Output($ruta.$nombre_archivo, 'F');
		
	}

}
