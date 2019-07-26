<?php

require_once dirname(__FILE__).'/../lib/devueltosOcaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/devueltosOcaGeneratorHelper.class.php';

/**
 * devueltosOca actions.
 *
 * @package    deluxebuys
 * @subpackage devueltosOca
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class devueltosOcaActions extends autoDevueltosOcaActions
{
	
	/**
	 * Executes enviar action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeEnviar(sfWebRequest $request)
	{
		$form = new devueltosOcaForm();
	
		if( $request->isMethod('post') )
		{
			$form->bind( $request->getParameter('devueltosOca') );
	
			if ( $form->isValid() ) 
			{
				$guiasEnvio = $form->prepare();
				$this->redirect( $this->getController()->genUrl(array('sf_route' => 'devueltosOca_procesar'), false ) . '?guiasEnvio=' . $guiasEnvio );
			}
		}
	
		$this->form = $form;
	
	}
	
	/**
	 * Executes procesar action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeProcesar(sfWebRequest $request)
	{
		$guiasEnvio = explode(',', $request->getParameter('guiasEnvio') );
		
		$this->pedidos = pedidoTable::getInstance()->listByGuiasEnvio( $guiasEnvio );
			
		/* Procesamiento */
		$form = new procesarDevueltosOcaForm();
	
		if( $request->isMethod('post') )
		{
			$form->bind( $request->getParameter('procesarDevueltosOca') );
	
			if ( $form->isValid() )
			{
			    $idsPedido = $form->getValue('id_pedido');
			    
			    $pedidos = pedidoTable::getInstance()->listByIds($idsPedido);
			    
			    $mailsEnviados = 0;
			    foreach ($pedidos as $pedido)
			    {
			        $devueltoOca = new devueltoOca();
			        $devueltoOca->setIdPedido( $pedido->getIdPedido() );
			        $devueltoOca->save();
			        $this->enviarMail($pedido);
			        $mailsEnviados++;
			    }

				$this->mailsEnviados = $mailsEnviados;
			}
		}
	
		$this->form = $form;
	}
	

	public function executeListFueRetirado(sfWebRequest $request)
	{
		$devueltoOca = $this->getRoute()->getObject();
		$devueltoOca->setFechaRetirado( new Doctrine_Expression('now()') );
		$devueltoOca->save();
		$this->redirect('devuelto_oca');
	}
	
	public function executeListReenviarMail(sfWebRequest $request)
	{
	    $devueltoOca = $this->getRoute()->getObject();
	    $pedido = $devueltoOca->getPedido();
        $this->enviarMail($pedido);
        sfContext::getInstance()->getUser()->setFlash('devueltosOCA_envioOK', 1);	    
        $this->redirect('devuelto_oca');
	}
	
	protected function executeBatchReenviarMail(sfWebRequest $request)
	{
	    $ids = $request->getParameter('ids');
	    $devueltosOca = devueltoOcaTable::getInstance()->listByIds($ids);
	    foreach( $devueltosOca as $devueltoOca )
	    {
	        $pedido = $devueltoOca->getPedido();
	        $this->enviarMail($pedido);
	    }
	    sfContext::getInstance()->getUser()->setFlash('devueltosOCA_envioOK', 2);
	    $this->redirect('devuelto_oca'); 
	}
	
	protected function executeBatchFueRetirado(sfWebRequest $request)
	{
	    $ids = $request->getParameter('ids');
	    devueltoOcaTable::getInstance()->marcarComoRetirados($ids);
	    $this->redirect('devuelto_oca');
	}
	
	/**
	 * Executes descargar action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeDescargar(sfWebRequest $request)
	{
		set_time_limit(0);
		
		$devueltosOca = $this->buildQuery()->execute();
				
		$phpExcel = new PHPExcel();
		
		$phpExcel->getProperties()->setCreator("DeluxeBuys");
		$activeSheet = $phpExcel->setActiveSheetIndex(0);
		
		$activeSheet->setCellValue('A1', 'Deluxebuys - Devueltos Oca');
		$activeSheet->mergeCells('A1:D1');
		$activeSheet->mergeCells('A2:D2');

		$headerCellStyle = array(
				'font' => array('bold' => true),
				'borders' => array(
						'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => '000000'))));
		
		$dataCellStyle = array(
				'borders' => array(
						'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => '000000'))));
		
		
		$activeSheet->setCellValue('A3', 'Id Devuelto Oca');
		$activeSheet->getStyle('A3')->applyFromArray($headerCellStyle);
		$activeSheet->getColumnDimension('A')->setWidth(15);
		
		$activeSheet->setCellValue('B3', 'Fecha Devolucion');
		$activeSheet->getStyle('B3')->applyFromArray($headerCellStyle);
		$activeSheet->getColumnDimension('B')->setWidth(20);
		
		$activeSheet->setCellValue('C3', 'Id Pedido');
		$activeSheet->getStyle('C3')->applyFromArray($headerCellStyle);
		$activeSheet->getColumnDimension('C')->setWidth(12);
		
		$activeSheet->setCellValue('D3', 'Datos Cliente');
		$activeSheet->getStyle('D3')->applyFromArray($headerCellStyle);
		$activeSheet->getColumnDimension('D')->setWidth(40);
		
		$activeSheet->setCellValue('E3', 'Monto');
		$activeSheet->getStyle('E3')->applyFromArray($headerCellStyle);
		$activeSheet->getColumnDimension('E')->setWidth(10);

		$activeSheet->setCellValue('F3', 'Fecha de Retiro');
		$activeSheet->getStyle('F3')->applyFromArray($headerCellStyle);
		$activeSheet->getColumnDimension('F')->setWidth(15);
		
		$i = 4;
		foreach ($devueltosOca as $devueltoOca)
		{	
			$pedido = $devueltoOca->getPedido();
			
			$activeSheet->setCellValue('A' . $i, $devueltoOca->getIdDevueltoOca() );
			$activeSheet->getStyle('A' . $i)->applyFromArray($dataCellStyle);
			
			$activeSheet->setCellValue('B' . $i, $devueltoOca->getDateTimeObject('fecha')->format("d/m/Y H:i") );
			$activeSheet->getStyle('B' . $i)->applyFromArray($dataCellStyle);
			
			$activeSheet->setCellValue('C' . $i, $pedido->getIdPedido() );
			$activeSheet->getStyle('C' . $i)->applyFromArray($dataCellStyle);
			
			$activeSheet->setCellValue('D' . $i, $pedido->getUsuario()->getNombre() . "\n" . $pedido->getUsuario()->getApellido() . "\n" . $pedido->getUsuario()->getEmail() );
			$activeSheet->getStyle('D' . $i)->applyFromArray($dataCellStyle);
			
			$monto = sprintf('%.2f', $pedido->getMontoTotal() );
			$activeSheet->setCellValue('E' . $i, $monto );
			$activeSheet->getStyle('E' . $i)->applyFromArray($dataCellStyle);

			if ( $devueltoOca->getFechaRetirado() ) {
				$activeSheet->setCellValue('F' . $i, $devueltoOca->getDateTimeObject('fecha_retirado')->format("d/m/Y") );
			}
			$activeSheet->getStyle('F' . $i)->applyFromArray($dataCellStyle);
			
			$i++;
		}
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte-devueltos-oca.xls"');
		header('Cache-Control: max-age=0');
		
		$writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
		$writer->save('php://output');
		
		exit;
	}
	
	
	protected function enviarMail($pedido)
	{
	    if ( $pedido->getIdEshop() ) {
	        $eshop = $pedido->getEshop();
	        $from = $eshop->getEmailNoReply();
	        $tipoMail  = 'ESHOP';
	    } else {
	        $eshop = false;
	        $from = sfConfig::get('app_email_from_noreply');
	        $tipoMail  = 'DELUXE';
	    }
	    
        $usuario = $pedido->getUsuario();
        $subject = 'Tu pedido fue devuelto por el correo a nuestras oficinas';
        $vars = array( 'eshop' => $eshop,'title' => $subject, 'pedido' => $pedido, 'usuario' => $usuario );
        $mailer = new Mailer('devueltoOca' . $tipoMail, $vars);	        
        $mailer->send( $subject, $usuario->getEmail(), $from );
	}
	
}
