<?php

require_once dirname(__FILE__).'/../lib/pedidosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/pedidosGeneratorHelper.class.php';

/**
 * pedidos actions.
 *
 * @package    deluxebuys
 * @subpackage pedidos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pedidosActions extends autoPedidosActions
{
		
  public function executeListView(sfWebRequest $request)
  {      
  	$this->pedido = $this->getRoute()->getObject();
  	$this->factura = $this->pedido->getFactura();
  	$this->usuario = $this->pedido->getUsuario();
  	  	
  	$this->pedidoNotaForm = new pedidoNotaForm( array(), array('pedido' => $this->pedido) );
  	
  	$pedidoDescuento = $this->pedido->getPedidoDescuento();
  	$this->descuento = ( count($pedidoDescuento) )? $pedidoDescuento->getFirst()->getDescuento() : null;

  	$pedidoBonificacion = $this->pedido->getPedidoBonificacion();
  	$this->bonificacion = ( count($pedidoBonificacion) ) ? $pedidoBonificacion->getFirst()->getBonificacion() : null;
  	
  	$this->faltantes = faltanteTable::getInstance()->listByIdsPedido( array( $this->pedido->getIdPedido() ) );

  	$this->devolucionProductoItems = devolucionProductoItemTable::getInstance()->listByIdPedido( $this->pedido->getIdPedido() );  	
  	  	
  	$this->remitos = remitoTable::getInstance()->listByIdsPedido( array( $this->pedido->getIdPedido() ) );  	
  }
  
  public function executeReciboDevolucion(sfWebRequest $request)
  {
  	$monto = sprintf('%.2f', $request->getParameter('monto') );
  	$this->monto = str_replace('.', ',', $monto);    	
  	$this->devolucion = $request->getParameter('devolucion');
  	$this->idPedido = $request->getParameter('idPedido');
  	
  	$detalle = $request->getParameter('detalle');
  	$detalle = explode(',', $detalle);
  	
  	$productos = array(); 
  	foreach ($detalle as $row)
  	{
  		list($idProductoItem, $cantidad) = explode('|', $row);
  		$productoItem = productoItemTable::getInstance()->findOneByIdProductoItem( $idProductoItem );
  		  		
  		$producto = $productoItem->getProducto();
  		
  		$row 					= array();
  		$row['denominacion']	= $producto->getDenominacion(); 
  		$row['talle']			= $productoItem->getProductoTalle()->getDenominacion();
  		$row['color']			= $productoItem->getProductoColor()->getDenominacion();
  		$row['marca']			= $producto->getMarca()->getNombre();
  		$row['cantidad']		= $cantidad;
  		
  		$productos[] = $row;
  	}
  	
  	$this->productos = $productos;
  	
  	$this->setLayout(false);
  }
  
  public function executeSaveNota(sfWebRequest $request)
  {
  	$idPedido = $request->getParameter('idPedido');
  	$pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);
  	
	$form = new pedidoNotaForm( array(), array('pedido' => $pedido) );
  	
  	if( $request->isMethod('post') )
  	{
  		$form->bind( $request->getParameter('nota') );
  		
  		if ( $form->isValid() )
  		{
  			$form->save();	
  		}
  	}
  	
  	$this->redirect('/backend/pedidos/' . $idPedido . '/ListView');
  }
  
  public function executeDescargarExcel(sfWebRequest $request)
  {
  	set_time_limit(0);
  	
  	$resumenFiltros = $this->getResumenFiltros();
  	
	$filters = $this->getFilters();
	$idCampana = $filters['campana'];
	$idMarca = $filters['marca'];
	$idDiversidad = $filters['diversidad'];
  	
  	$pedidos = $this->buildQuery()->execute();
  	
  	$dateNow = date('Y-m-d H:i:s');
  	
	$phpExcel = new PHPExcel();
	
	$phpExcel->getProperties()->setCreator("DeluxeBuys");
	$activeSheet = $phpExcel->setActiveSheetIndex(0);
	 
	$activeSheet->setCellValue('A1', 'Deluxebuys - Planilla de pedidos');
	$activeSheet->mergeCells('A1:D1');
	$activeSheet->mergeCells('A2:D2');
				
	$activeSheet->setCellValue('A3', 'Generada: ' . $dateNow);
	$activeSheet->mergeCells('A3:D3');
		
	$activeSheet->setCellValue('A4', 'Desde: ' . $resumenFiltros['fecha']['desde']);
	$activeSheet->mergeCells('A4:D4');
	
	$activeSheet->setCellValue('A5', 'Hasta: ' . $resumenFiltros['fecha']['hasta']);
	$activeSheet->mergeCells('A5:D5');

	$activeSheet->setCellValue('A6', 'Estado: ' . $resumenFiltros['estado']);
	$activeSheet->mergeCells('A6:D6');

	$activeSheet->setCellValue('A7', 'Diversidad: ' . $resumenFiltros['diversidad']);
	$activeSheet->mergeCells('A7:D7');
	
	$activeSheet->setCellValue('A8', 'Campaña: ' . $resumenFiltros['campana']);
	$activeSheet->mergeCells('A8:D8');
	
	$activeSheet->setCellValue('A9', 'Marca: ' . $resumenFiltros['marca']);
	$activeSheet->mergeCells('A9:D9');
	
	$headerCellStyle = array(
	    'font' => array('bold' => true, 'size' => '10', 'color' => array('rgb' => 'FFFFFF')),
	    'fill' => array(
	        'type' => PHPExcel_Style_Fill::FILL_SOLID,
	        'color' => array('rgb' => '333333')
	    ),
	    'borders' => array(
	        'allborders' => array(
	            'style' => PHPExcel_Style_Border::BORDER_THIN,
	            'color' => array('argb' => '000000'))));
	
	$dataCellStyle = array(
	    'font' => array('size' => "10"),
	    'borders' => array(
	        'allborders' => array(
	            'style' => PHPExcel_Style_Border::BORDER_THIN,
	            'color' => array('argb' => '000000'))));
	
	
	$activeSheet->setCellValue('A12', 'CodPedido');
	$activeSheet->setCellValue('B12', 'Marca');
	$activeSheet->setCellValue('C12', 'Condicion Fiscal');
	
	
	$activeSheet->setCellValue('D12', 'Vigencia');
	$activeSheet->setCellValue('E12', 'Cod prod');
	$activeSheet->setCellValue('F12', 'Producto');
	$activeSheet->setCellValue('G12', 'Color');
	$activeSheet->setCellValue('H12', 'Talle');
	$activeSheet->setCellValue('I12', 'Precio lista');
	$activeSheet->setCellValue('J12', 'Precio DB');
	$activeSheet->setCellValue('K12', 'Precio DB (Sin IVA)');
	$activeSheet->setCellValue('L12', 'Costo');
	$activeSheet->setCellValue('M12', 'Costo (Sin IVA)');	
	$activeSheet->setCellValue('N12', 'Contr marg');
	$activeSheet->setCellValue('O12', 'Cnt');
	$activeSheet->setCellValue('P12', 'Desc');
	$activeSheet->setCellValue('Q12', 'Bonif');
	$activeSheet->setCellValue('R12', 'Envío');
	$activeSheet->setCellValue('S12', 'Financ');
	$activeSheet->setCellValue('T12', 'Total');
	$activeSheet->setCellValue('U12', 'Facturación');
	$activeSheet->setCellValue('V12', 'Ganancia');
	$activeSheet->setCellValue('W12', '%');
	$activeSheet->setCellValue('X12', 'Cliente');
	$activeSheet->setCellValue('Y12', 'Teléfono');
	$activeSheet->setCellValue('Z12', 'Pagado?');
	$activeSheet->setCellValue('AA12', 'Forma pago');
	$activeSheet->setCellValue('AB12', 'Fecha');
	$activeSheet->setCellValue('AC12', 'Guía envío');
	$activeSheet->setCellValue('AD12', 'Dirección');
	$activeSheet->setCellValue('AE12', 'Código Postal');
	$activeSheet->setCellValue('AF12', 'Localidad');
	$activeSheet->setCellValue('AG12', 'Provincia');
	$activeSheet->setCellValue('AH12', 'Email');
	$activeSheet->setCellValue('AI12', 'DNI');
	$activeSheet->setCellValue('AJ12', 'Observaciones');
	$activeSheet->setCellValue('AK12', 'Notas');
	
	$activeSheet->getStyle('A12:AK12')->applyFromArray($headerCellStyle);
	
	$i = 13;
	foreach ($pedidos as $pedido)
	{
		$pedidoProductoItems = $pedido->getPedidoProductoItem();
		$usuario = $pedido->getUsuario();
		
		$activeSheet->setCellValue('P' . $i, $pedido->getMontoDescuento() );
		$activeSheet->setCellValue('Q' . $i, $pedido->getMontoBonificacion() );
		$activeSheet->setCellValue('R' . $i, $pedido->getMontoEnvio() );
		$activeSheet->setCellValue('S' . $i, $pedido->getInteres() );
		$activeSheet->setCellValue('T' . $i, $pedido->getMontoTotal());
		
		$facturacion = $pedido->getFacturacion();
		$activeSheet->setCellValue('U' . $i, $facturacion);			
		
		$ganancia = $pedido->getGanancia();
		$activeSheet->setCellValue('V' . $i, $ganancia);
					
		$activeSheet->setCellValue('W' . $i, ( $ganancia ) ? $facturacion/$ganancia : 0 );
		
		$activeSheet->setCellValue('AC' . $i, $pedido->getCodigoEnvio());
		
		$activeSheet->setCellValue('AH' . $i, $usuario->getEmail() );
		$activeSheet->setCellValue('AI' . $i, $usuario->getTipoDocumento() . ' ' . $usuario->getDocumento() );
		$activeSheet->setCellValue('AJ' . $i, $pedido->getObservaciones() );
		$activeSheet->setCellValue('AK' . $i, $pedido->getNota());
		
		foreach ($pedidoProductoItems as $pedidoProductoItem)
		{
			$productoItem = $pedidoProductoItem->getProductoItem();
			$producto = $productoItem->getProducto();
						
			$marca = $producto->getMarca();
			
			// Filtro opcional  por campaña
			if ( $idCampana )
			{
				$pedidoProductoItemCampanas = $pedidoProductoItem->getPedidoProductoItemCampana();
				$existeCampana = false;
				foreach ($pedidoProductoItemCampanas as $pedidoProductoItemCampana)
				{
					if ($pedidoProductoItemCampana->getIdCampana() == $idCampana)
					{ 
						$existeCampana = true;
					}
				}
				
				if ( !$existeCampana ) continue;
			}
			
			$activeSheet->setCellValue('A' . $i, $pedido->getIdPedido() );
			$activeSheet->setCellValue('B' . $i, $producto->getMarca()->getNombre() );
			$activeSheet->setCellValue('C' . $i, $producto->getMarca()->getCondicionFiscalDenominacion() );
			
			$pedidoProductoItemCampanas = $pedidoProductoItem->getPedidoProductoItemCampana();
			$vigencias = array();
			foreach($pedidoProductoItemCampanas as $pedidoProductoItemCampana)
			{
				$campana = $pedidoProductoItemCampana->getCampana();
				$desde = $campana->getDateTimeObject('fecha_inicio')->format("y-m-d");
				$hasta = $campana->getDateTimeObject('fecha_fin')->format("y-m-d");
				$vigencias[] = 'de ' . $desde . ' a ' . $hasta; 
			}
			$vigencia = ($vigencias)? implode(' / ', $vigencias) : 'Permanente';			
			$activeSheet->setCellValue('D' . $i, $vigencia);
			
			$activeSheet->setCellValue('E' . $i, $productoItem->getCodigo() );
			$activeSheet->setCellValue('F' . $i, $producto->getDenominacion() );
			$activeSheet->setCellValue('G' . $i, $pedidoProductoItem->getProductoColor()->getDenominacion() );
			$activeSheet->setCellValue('H' . $i, $pedidoProductoItem->getProductoTalle()->getDenominacion() );
			$activeSheet->setCellValue('I' . $i, $pedidoProductoItem->getPrecioLista() );
			
			$activeSheet->setCellValue('J' . $i, $pedidoProductoItem->getPrecioDeluxe() );
			$activeSheet->setCellValue('K' . $i, $pedidoProductoItem->getPrecioDeluxeSinIva() );

			
			$activeSheet->setCellValue('L' . $i, $pedidoProductoItem->getCosto());
			$activeSheet->setCellValue('M' . $i, $pedidoProductoItem->getCostoSinIva() );
			
			if ( $pedidoProductoItem->getCosto() != 0 ) {
			    $contribucionMarginal = ( $pedidoProductoItem->getPrecioDeluxe() ) ? ( $pedidoProductoItem->getPrecioDeluxe() / $pedidoProductoItem->getCosto() ) : 0;
			    $contribucionMarginal = ceil(($contribucionMarginal - 1)*100) . '%';			    
			} else {
			    $contribucionMarginal = 0;
			}
 
			$activeSheet->setCellValue('N' . $i, $contribucionMarginal);
			
			$activeSheet->setCellValue('O' . $i, $pedidoProductoItem->getCantidad());
			
			$activeSheet->setCellValue('X' . $i, $usuario->getNombre() . ' ' . $usuario->getApellido() );
			$activeSheet->setCellValue('Y' . $i, $usuario->getTelefono() );
			
			$fuePagado = ($pedido->getFechaPago())? 'Si' : 'No';			
			$activeSheet->setCellValue('Z' . $i, $fuePagado);
			
			$activeSheet->setCellValue('AA' . $i, $pedido->getDescripcionFormaPago(' - ') );
			
			$activeSheet->setCellValue('AB' . $i, $pedido->getDateTimeObject('fecha_alta')->format("y-m-d") );
			
			$envioDetalle = $pedido->getArrayEnvioDetalle();

			if ($envioDetalle['tipo'] == CarritoEnvio::SUCURSAL) {
				$activeSheet->setCellValue('AD' . $i, 'SUCURSAL: ' . $envioDetalle['sucursal'] . ' - ' . $envioDetalle['direccion'] );
				$activeSheet->setCellValue('AE' . $i, $envioDetalle['codigo_postal'] );
			} else {
				$activeSheet->setCellValue('AD' . $i, $envioDetalle['direccion'] );
				$activeSheet->setCellValue('AE' . $i, $envioDetalle['codigo_postal'] );
			}	
			
			$activeSheet->setCellValue('AF' . $i, $envioDetalle['localidad'] );
			$activeSheet->setCellValue('AG' . $i, $pedido->getProvincia()->getNombre() );
			
			$activeSheet->getStyle('A' . $i . ':AK' . $i )->applyFromArray($dataCellStyle);

			$i++;
		}
	}
	
			 
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="reporte.xls"');
	header('Cache-Control: max-age=0');
	
	$writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
	$writer->save('php://output');
	
	exit;
  }
  
  public function executeExportarComprobantes(sfWebRequest $request)
  {
  	set_time_limit(0);
  	
  	$dateNow = date('Y-m-d H:i:s');
  	  	
  	$resumenFiltros = $this->getResumenFiltros();
  	$pedidos = $this->buildQuery()->execute();
  	
  	// Armo el txt
  	$txt  = ''; 
	$txt .= 'FILTROS UTILIZADOS EN LA EXPORTACION DE COMPROBANTES DEL ' . $dateNow . "\n\n";
	$txt .= 'Desde: ' . $resumenFiltros['fecha']['desde'] . "\n";
	$txt .= 'Hasta: ' . $resumenFiltros['fecha']['hasta'] . "\n";
	$txt .= 'Estado: ' . $resumenFiltros['estado'] . "\n";
	$txt .= 'Diversidad: ' . $resumenFiltros['diversidad'] . "\n";
	$txt .= 'Campaña: ' . $resumenFiltros['campana'] . "\n";
	$txt .= 'Marca: ' . $resumenFiltros['marca'] . "\n";
		
	file_put_contents( '/tmp/detalle.txt' , $txt );
	
	
  	// Armo BookClientes.xls
	$phpExcel = new PHPExcel();

	$phpExcel->getProperties()->setCreator("DeluxeBuys");
	
	$activeSheet = $phpExcel->setActiveSheetIndex(0);

	$activeSheet->setCellValue('A1', 'nombre');
	$activeSheet->setCellValue('B1', 'cuit');
	$activeSheet->setCellValue('C1', 'email');
	$activeSheet->setCellValue('D1', 'desc_tipocontrib');
	$activeSheet->setCellValue('E1', 'desc_clase');
	$activeSheet->setCellValue('F1', 'iibbexento');
	$activeSheet->setCellValue('G1', 'desc_tipopago');
	$activeSheet->setCellValue('H1', 'desc_provincia');
	$activeSheet->setCellValue('I1', 'desc_pais');
	$activeSheet->setCellValue('J1', 'domicilio');
	$activeSheet->setCellValue('K1', 'localidad');
	$activeSheet->setCellValue('L1', 'telefonos');
	$activeSheet->setCellValue('M1', 'codigopostal');
	$activeSheet->setCellValue('N1', 'tel_aternat');
	$activeSheet->setCellValue('O1', 'nro_cuenta');
	$activeSheet->setCellValue('P1', 'en_dolares');
	$activeSheet->setCellValue('Q1', 'vendedor');
	$activeSheet->setCellValue('R1', 'observaciones');
	$activeSheet->setCellValue('S1', 'cuit_empresa');
	
	$i = 2;
	$controlRepetidos = array();
	foreach ($pedidos as $pedido)
	{
		
		if ( isset($controlRepetidos[$pedido->getIdUsuario()]) ) continue;
		$controlRepetidos[$pedido->getIdUsuario()] = true;
		
		$usuario = $pedido->getUsuario();
		
		$activeSheet->setCellValue('A' . $i, $usuario->getNombre() . ' ' . $usuario->getApellido() );
		$activeSheet->setCellValue('B' . $i, '00-00000000-0');
		$activeSheet->setCellValue('C' . $i, $usuario->getEmail() );
		$activeSheet->setCellValue('D' . $i, 'Consumidor Final');
		$activeSheet->setCellValue('E' . $i, '');
		$activeSheet->setCellValue('F' . $i, 'si');
		$activeSheet->setCellValue('G' . $i, $pedido->getFormaPago()->getDenominacion() );
		$activeSheet->setCellValue('H' . $i, $pedido->getProvincia()->getNombre() );
		$activeSheet->setCellValue('I' . $i, 'Argentina');
		

		$envioDetalle = $pedido->getArrayEnvioDetalle();

		if ($envioDetalle['tipo'] == CarritoEnvio::SUCURSAL) {
			$activeSheet->setCellValue('J' . $i, 'SUCURSAL: ' . $envioDetalle['sucursal'] . ' - ' . $envioDetalle['direccion'] );
		} else {
			$activeSheet->setCellValue('J' . $i,  $envioDetalle['direccion'] );
		}	

		$activeSheet->setCellValue('K' . $i, $envioDetalle['localidad'] );
		$activeSheet->setCellValue('L' . $i, $usuario->getTelefono() );
		$activeSheet->setCellValue('M' . $i, $envioDetalle['codigo_postal'] );
		$activeSheet->setCellValue('N' . $i, '');
		$activeSheet->setCellValue('O' . $i, $usuario->getIdUsuario() );
		$activeSheet->setCellValue('P' . $i, 'no');
		$activeSheet->setCellValue('Q' . $i, '');
		$activeSheet->setCellValue('R' . $i, '');
		$activeSheet->setCellValue('S' . $i, sfConfig::get('app_cuit_deluxe') );
		
		$i++;
	}
	
	$writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
	$writer->save('/tmp/BookClientes.xls');
	
	
  	// Armo BookProductos.xls
	$phpExcel = new PHPExcel();
	$phpExcel->getProperties()->setCreator("DeluxeBuys");
	
	$activeSheet = $phpExcel->setActiveSheetIndex(0);
	
	$activeSheet->setCellValue('A1', 'Identificación');
	$activeSheet->setCellValue('B1', 'Descripción');
	$activeSheet->setCellValue('C1', 'Clase');
	$activeSheet->setCellValue('D1', 'Rubro');
	$activeSheet->setCellValue('E1', 'Importe');
	$activeSheet->setCellValue('F1', 'IVA');
	$activeSheet->setCellValue('G1', 'cuit_empresa');
	
	$i = 2;
	$controlRepetidos = array();
	foreach ($pedidos as $pedido)
	{
		$pedidoProductoItems = $pedido->getPedidoProductoItem();
		
		foreach ($pedidoProductoItems as $pedidoProductoItem)
		{		
			if ( isset($controlRepetidos[$pedidoProductoItem->getIdProductoItem()]) ) continue;
			$controlRepetidos[$pedidoProductoItem->getIdProductoItem()] = true;
						
			$activeSheet->setCellValue('A' . $i, $pedidoProductoItem->getIdProductoItem() );
			
			$producto = $pedidoProductoItem->getProductoItem()->getProducto();
			$productoNombre = $producto->getDenominacion();
			$talle = $pedidoProductoItem->getProductoColor()->getDenominacion();
			$color = $pedidoProductoItem->getProductoTalle()->getDenominacion();
			
			$activeSheet->setCellValue('B' . $i, $productoNombre . ' / ' . $talle . ' / ' . $color);
			
			$pedidoProductoItemCampanas = $pedidoProductoItem->getPedidoProductoItemCampana();
			$clases = array();
			foreach($pedidoProductoItemCampanas as $pedidoProductoItemCampana)
			{
				$campana = $pedidoProductoItemCampana->getCampana();
				$clases[] = $campana->getDenominacion(); 
			}
			$vigencia = ($clases)? implode(' / ', $clases) : 'Permanente';			
			$activeSheet->setCellValue('C' . $i, $vigencia);
						
			$activeSheet->setCellValue('D' . $i, '');
			$activeSheet->setCellValue('E' . $i,  round( $pedidoProductoItem->getPrecioDeluxe()/(1.21), 2) );
			$activeSheet->setCellValue('F' . $i, '21');
			$activeSheet->setCellValue('G' . $i, sfConfig::get('app_cuit_deluxe') );
			
			$i++;
		}
	}
	
	
	$activeSheet->setCellValue('A' . $i, 'xxx_envio');
	$activeSheet->setCellValue('B' . $i, 'Cargo de envío');
	$activeSheet->setCellValue('E' . $i, '1');
	$activeSheet->setCellValue('F' . $i, '21');
	$activeSheet->setCellValue('G' . $i, sfConfig::get('app_cuit_deluxe') );
	
	$i++;
	$activeSheet->setCellValue('A' . $i, 'xxx_financiacion');
	$activeSheet->setCellValue('B' . $i, 'Cargo de financiación');
	$activeSheet->setCellValue('E' . $i, '1');
	$activeSheet->setCellValue('F' . $i, '21');
	$activeSheet->setCellValue('G' . $i, sfConfig::get('app_cuit_deluxe') );
	
	;
	
	
	$writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
	$writer->save('/tmp/BookProductos.xls');

	
	// Armo comprobantes.xml
	$xml  = "";
	$xml .= "<?xml version='1.0' encoding='utf-8' ?>";
	$xml .= "<empresa>";
	$xml .= sfConfig::get('app_cuit_deluxe');
		
	$i = 2;
	$controlRepetidos = array();
	foreach ($pedidos as $pedido)
	{
		$xml .= "<comprobantes>";
		$xml .= "	<cabecera>";
		$xml .= "		<emision>" . $dateNow . "</emision>";				
		$xml .= "		<tipoCbante>06</tipoCbante>";
		$xml .= "		<nroCuentaCliente>" . $pedido->getIdUsuario() . "</nroCuentaCliente>";
		$xml .= "		<cuitCliente>00-00000000-0</cuitCliente>";
		$xml .= "		<tipoPago>" . $pedido->getFormaPago()->getDenominacion() . "</tipoPago>";
		$xml .= "		<vendedor></vendedor>";
		$xml .= "		<descuento>" . $pedido->getMontoDescuento() . "</descuento>";
		$xml .= "		<bonificacion>" . $pedido->getMontoBonificacion() . "</bonificacion>";
		$xml .= "		<subTotalNeto>". round( $pedido->getMontoTotal()/(1.21), 2) ."</subTotalNeto>";
		$xml .= "		<iva1>". round(($pedido->getMontoTotal()*0.21)/(1.21), 2) . "</iva1>";
		$xml .= "		<iva2/>";
		$xml .= "		<total>" . $pedido->getMontoTotal() . "</total>";
		$xml .= "	</cabecera>";
		
		$xml .= "	<detalle>";
		
		$pedidoProductoItems = $pedido->getPedidoProductoItem();
		
		foreach ($pedidoProductoItems as $pedidoProductoItem)
		{		
			$xml .= "	<item>";
			$xml .= "		<producto>" . $pedidoProductoItem->getIdProductoItem() . "</producto>";
			$xml .= "		<importe>" . round( $pedidoProductoItem->getPrecioDeluxe()/(1.21), 2) . "</importe>";
			$xml .= "		<cantidad>" . $pedidoProductoItem->getCantidad() . "</cantidad>";
			$xml .= "		<iva>21</iva>";
			$xml .= "	</item>";
		}
		
		if ( $pedido->getMontoEnvio() )
		{
			$xml .= "		<item>";
			$xml .= "			<producto>xxx_envio</producto>";
			$xml .= "			<importe>" . round( $pedido->getMontoEnvio()/(1.21), 2) . "</importe>";
			$xml .= "			<cantidad>1</cantidad>";
			$xml .= "			<iva>21</iva>";
			$xml .= "		</item>";
		}
		
		if ( $pedido->getInteres() )
		{
			$xml .= "		<item>";
			$xml .= "			<producto>xxx_financiacion</producto>";
			$xml .= "			<importe>" . round( $pedido->getInteres()/(1.21), 2) . "</importe>";
			$xml .= "			<cantidad>1</cantidad>";
			$xml .= "			<iva>21</iva>";
			$xml .= "		</item>";
		}
		
		$xml .= "	</detalle>";
		$xml .= "</comprobantes>";
	}
	
	$xml .= "</empresa>";

	file_put_contents( '/tmp/comprobantes.xml' , $xml );
	
	
	// Creo el zip
	$zip = new ZipArchive();
	$zipName = "comprobantes-$dateNow.zip";
	$archivo_exitoso[] = $zip->open('/tmp/'.$zipName, ZIPARCHIVE::CREATE);
	$archivo_exitoso[] = $zip->addFile('/tmp/comprobantes.xml', 'comprobantes.xml');
	$archivo_exitoso[] = $zip->addFile('/tmp/BookProductos.xls', 'BookProductos.xls');
	$archivo_exitoso[] = $zip->addFile('/tmp/BookClientes.xls', 'BookClientes.xls');
	$archivo_exitoso[] = $zip->addFile('/tmp/detalle.txt', 'detalle.txt');
	$zip->close();
	
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header('Content-type: application/zip');
	header("Content-Length: ".filesize('/tmp/'.$zipName));	
	header('Content-Disposition: attachment; filename="' . $zipName . '"');

	readfile('/tmp/'.$zipName);
	
  	exit;
	
  }
  
  protected function getResumenFiltros()
  {
	$filters = $this->getFilters();
	
	$resumenFiltros['fecha']['desde'] = '';
	$resumenFiltros['fecha']['hasta'] = '';
	$resumenFiltros['estado'] = 'Todos';
	$resumenFiltros['diversidad'] = 'Ambas';
	$resumenFiltros['campana'] = 'Todas';
	$resumenFiltros['marca'] = 'Todas';
	
	if ($filters)
	{
		
		$resumenFiltros['fecha']['desde'] = $filters['fecha_pago']['from'];
		$resumenFiltros['fecha']['hasta'] = $filters['fecha_pago']['to'];

		$resumenFiltros['estado'] = pedidoFormFilter::getNombreEstado( $filters['estado'] );
		$resumenFiltros['diversidad'] = pedidoFormFilter::getNombreDiversidad( $filters['diversidad'] );
		
		if ($filters['campana'])
		{
			$campana = campanaTable::getInstance()->findOneByIdCampana( $filters['campana'] );
			$resumenFiltros['campana'] = $campana->getDenominacion();
		}
		
		if ($filters['marca'])
		{
			$marcas = marcaTable::getInstance()->getById( $filters['marca'] );
			$aux = array();
			foreach ($marcas as $marca) {
				$aux[] = $marca->getNombre();
			}
			$marcas = $aux;

			$resumenFiltros['marca'] = implode(', ', $marcas);
		}
		
		
	}
	
	return $resumenFiltros;
  }
  
  public function executeOrdenCompra(sfWebRequest $request)
  {         
	$form = new ordenCompraForm();
	
	$executeForm = false;
	if ( $request->isMethod('post') )
	{
	    $params = $request->getParameter('ordenCompra');
	    $executeForm = true;
	}
		
	if ( isset( $_GET['id_campana'] ) && isset( $_GET['id_marca'] ) )
	{
	    $idCampana = $_GET['id_campana'];
	    $idMarca = $_GET['id_marca'];
	    $descargar = ( isset( $_GET['descargar'] ) ) ? (bool) $_GET['descargar'] : false;
	    
	    
	    $params = array();
	    
	    if ( $descargar )
	    {
	        $params['action'] = 'Descargar';
	    }   
	    
	    $params['stock_campana'] = $idCampana;
	    $params['marca'] = $idMarca;
	    $params['origen_stock'] = false;
	    $params['_csrf_token'] = $form->getCSRFToken();
	    
	    $executeForm = true;
	}
		
	if( $executeForm  )
	{		
		$form->bind( $params );

		if ( $form->isValid() ) {
			$this->mostrarPedidos = $params['mostrar_pedidos'];
			$this->data = $form->download();
		} else {
			$this->getUser()->setFlash('ordenesDeCompra_error', "Faltan completar los datos sobre la orden de compra que se quiere obtener");
		}
	}  	
	
	$this->form = $form;
  	
  }
  
  
  public function executeArmado(sfWebRequest $request)
  {
  	set_time_limit(0);
  	
  	$dateNow = date('Y-m-d H:i:s');
  	  	
  	$resumenFiltros = $this->getResumenFiltros();
  	
  	$query = $this->buildQuery();
  	$query->orderBy( $query->getRootAlias() . '.envio_destinatario');
  	$pedidos = $query->execute();
  		
	
	// Armo el xls
  	$dateNow = date('Y-m-d H:i:s');
  	
	$phpExcel = new PHPExcel();
	
	$phpExcel->getProperties()->setCreator("DeluxeBuys");
	$activeSheet = $phpExcel->setActiveSheetIndex(0);
	$activeSheet->getDefaultStyle()->getFont()->setName('times new roman');
	$activeSheet->getDefaultStyle()->getFont()->setSize(10);
	$activeSheet->getDefaultStyle()->getAlignment()->setWrapText(true);
	
	$headerCellStyle = array(
		  'font' => array('bold' => true),
	      'borders' => array(
	        'allborders' => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array('argb' => '000000'))));	
		
	$activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	 
	$activeSheet->setCellValue('A1', 'Deluxebuys - Planilla de pedidos');
	$activeSheet->mergeCells('A1:D1');
	$activeSheet->mergeCells('A2:D2');
				
	$activeSheet->setCellValue('A3', 'Generada: ' . $dateNow);
	$activeSheet->mergeCells('A3:D3');
		
	$activeSheet->setCellValue('A4', 'Desde: ' . $resumenFiltros['fecha']['desde']);
	$activeSheet->mergeCells('A4:D4');
	
	$activeSheet->setCellValue('A5', 'Hasta: ' . $resumenFiltros['fecha']['hasta']);
	$activeSheet->mergeCells('A5:D5');

	$activeSheet->setCellValue('A6', 'Estado: ' . $resumenFiltros['estado']);
	$activeSheet->mergeCells('A6:D6');

	$activeSheet->setCellValue('A7', 'Diversidad: ' . $resumenFiltros['diversidad']);
	$activeSheet->mergeCells('A7:D7');
	
	$activeSheet->setCellValue('A8', 'Campaña: ' . $resumenFiltros['campana']);
	$activeSheet->mergeCells('A8:D8');
	
	$activeSheet->setCellValue('A9', 'Marca: ' . $resumenFiltros['marca']);
	$activeSheet->mergeCells('A9:D9');
	
	
	$activeSheet->setCellValue('A12', 'IdPedido');
	$activeSheet->getStyle('A12')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('B12', 'FechaPed');
	$activeSheet->getStyle('B12')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('C12', 'Mezcla?');
	$activeSheet->getStyle('C12')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('D12', 'Tiene Outlet?');
	$activeSheet->getStyle('D12')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('E12', 'Recibe');
	$activeSheet->getStyle('E12')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('F12', 'Env.');
	$activeSheet->getStyle('F12')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('G12', 'CodProducto');
	$activeSheet->getStyle('G12')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('H12', 'Marca');
	$activeSheet->getStyle('H12')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('I12', 'Producto');
	$activeSheet->getStyle('I12')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('J12', 'C.');
	$activeSheet->getStyle('J12')->applyFromArray($headerCellStyle);

	$activeSheet->setCellValue('K12', 'Observaciones');
	$activeSheet->getStyle('K12')->applyFromArray($headerCellStyle);
	
	$activeSheet->getColumnDimensionByColumn('A')->setAutosize(true);
	$activeSheet->getColumnDimension('A')->setWidth(5);
	
	$activeSheet->getColumnDimensionByColumn('B')->setAutosize(true);
	$activeSheet->getColumnDimension('B')->setWidth(11);
	
	$activeSheet->getColumnDimensionByColumn('C')->setAutosize(true);
	$activeSheet->getColumnDimension('C')->setWidth(9);
	
	$activeSheet->getColumnDimensionByColumn('D')->setAutosize(true);
	$activeSheet->getColumnDimension('D')->setWidth(9);
		
	$activeSheet->getColumnDimensionByColumn('E')->setAutosize(true);
	$activeSheet->getColumnDimension('E')->setWidth(16);
	
	$activeSheet->getColumnDimensionByColumn('F')->setAutosize(true);
	$activeSheet->getColumnDimension('F')->setWidth(5);
	
	$activeSheet->getColumnDimensionByColumn('G')->setAutosize(true);
	$activeSheet->getColumnDimension('G')->setWidth(19);
	
	$activeSheet->getColumnDimensionByColumn('H')->setAutosize(true);
	$activeSheet->getColumnDimension('H')->setWidth(16);
	
	$activeSheet->getColumnDimensionByColumn('I')->setAutosize(true);
	$activeSheet->getColumnDimension('I')->setWidth(6);
	
	$activeSheet->getColumnDimensionByColumn('J')->setAutosize(true);
	$activeSheet->getColumnDimension('J')->setWidth(3);

	$activeSheet->getColumnDimensionByColumn('K')->setAutosize(true);
	$activeSheet->getColumnDimension('K')->setWidth(30);
	
	$i = 13;

	$dataCellStyle = array(
	        'borders' => array(
	                'allborders' => array(
	                        'style' => PHPExcel_Style_Border::BORDER_THIN,
	                        'color' => array('argb' => '000000'))));

	$faltanteCellStyle = array(
			'font' => array('bold' => true, 'size' => '10', 'color' => array('rgb' => 'FF0000')),
	        'borders' => array(
	                'allborders' => array(
	                        'style' => PHPExcel_Style_Border::BORDER_THIN,
	                        'color' => array('argb' => '000000'))));
	
	$nombreUsuario = '';
	foreach ($pedidos as $pedido)
	{	    
		$usuario = $pedido->getUsuario();
	
		$activeSheet->setCellValue('A' . $i, $pedido->getIdPedido() );
		$activeSheet->setCellValue('B' . $i, $pedido->getDateTimeObject('fecha_pago')->format("d-m-y") );
		
		$activeSheet->setCellValue('C' . $i, $pedido->tieneMezcla()? 'Si' : 'No' );
		$activeSheet->setCellValue('D' . $i, $pedido->tieneOutlet()? 'Si' : 'No' );
		
		$envioDetalle = $pedido->getArrayEnvioDetalle();

		$rowNombreUsuario = $envioDetalle['destinatario'];
		
		if ($rowNombreUsuario != $nombreUsuario)
		{
			$nombreUsuario = $rowNombreUsuario;
			$activeSheet->setCellValue('E' . $i, $nombreUsuario );
		}
		
		if ($envioDetalle['tipo'] == CarritoEnvio::SUCURSAL) {
			$activeSheet->setCellValue('F' . $i, 'S');
		} else {
			$activeSheet->setCellValue('F' . $i, 'P');
		}	
		
		
		$pedidoProductoItems = $pedido->getPedidoProductoItem();
		
		$resumenfaltantes = faltanteTable::getInstance()->resumenFaltantes( $pedido->getIdPedido() );

		foreach ($pedidoProductoItems as $pedidoProductoItem)
		{
			$productoItem = $pedidoProductoItem->getProductoItem();
			$producto = $productoItem->getProducto();
			$marca = $producto->getMarca();
			
			$activeSheet->setCellValue('G' . $i, $productoItem->getCodigo() );
			$activeSheet->setCellValue('H' . $i, $producto->getMarca()->getNombre() );
			
			$productoNombre = $producto->getDenominacion();
			$talle = $pedidoProductoItem->getProductoColor()->getDenominacion();
			$color = $pedidoProductoItem->getProductoTalle()->getDenominacion();
			$activeSheet->setCellValue('I' . $i, $productoNombre . "\n" . $talle . "\n" . $color);
			$activeSheet->setCellValue('J' . $i, $pedidoProductoItem->getCantidad() );

			$cantidadFaltante = ( isset($resumenfaltantes[ $pedidoProductoItem->getIdProductoItem() ]) ) ? $resumenfaltantes[ $pedidoProductoItem->getIdProductoItem() ] : 0;
									
			$esOutlet = ( $pedidoProductoItem->esOutlet() ) ? ' / Es Outlet' : '';
			
			if ( $cantidadFaltante ) {
				$cellStyle = $faltanteCellStyle;
				$activeSheet->setCellValue('k' . $i, 'Producto con Faltantes' );
			} else {
				$cellStyle = $dataCellStyle;
			}
			

			$activeSheet->getRowDimension($i)->setRowHeight(-1);
			$activeSheet->getStyle('A' . $i)->applyFromArray($cellStyle);
			$activeSheet->getStyle('B' . $i)->applyFromArray($cellStyle);
			$activeSheet->getStyle('C' . $i)->applyFromArray($cellStyle);
			$activeSheet->getStyle('D' . $i)->applyFromArray($cellStyle);
			$activeSheet->getStyle('E' . $i)->applyFromArray($cellStyle);
			$activeSheet->getStyle('F' . $i)->applyFromArray($cellStyle);
			$activeSheet->getStyle('G' . $i)->applyFromArray($cellStyle);
			$activeSheet->getStyle('H' . $i)->applyFromArray($cellStyle);
			$activeSheet->getStyle('I' . $i)->applyFromArray($cellStyle);
			$activeSheet->getStyle('J' . $i)->applyFromArray($cellStyle);
			$activeSheet->getStyle('K' . $i)->applyFromArray($cellStyle);
			
			$i++;
		}		
		
	}
	
	$writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
	$writer->save('/tmp/armado-pedidos.xls');
	
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="armado-pedidos-' . $dateNow . '.xls"');
	header('Cache-Control: max-age=0');
	
	$writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
	$writer->save('php://output');
	exit;

  }
  
  protected function executeBatchReimprimirRemitos(sfWebRequest $request, $formato)
  {
  	$ids = $request->getParameter('ids');
  	$params['ids'] = implode(',', $ids);
  	$params['formato'] = $formato;
  	
  	$url = $this->getController()->genUrl( array(	'sf_route' => 'pedido_preparar_remitos') );
  
  	$this->redirect( $url . '?' . http_build_query($params) );
  }
  

  protected function executeBatchReimprimirRemitosHTML(sfWebRequest $request)
  {
  	$this->executeBatchReimprimirRemitos($request, 'HTML');
  }

  protected function executeBatchReimprimirRemitosXLS(sfWebRequest $request)
  {
	$this->executeBatchReimprimirRemitos($request, 'XLS');
  }
  
  protected function executeBatchPrepararEnvio(sfWebRequest $request)
  {  
    $ids = $request->getParameter('ids');
    $params['ids'] = implode(',', $ids); 
    $params['ocultarPreFiltro'] = true;    
    
    $url = $this->getController()->genUrl( array(	'sf_route' => 'pedido_preparar_envio') );
    
    $this->redirect( $url . '?' . http_build_query($params) );
  }
  
  public function executePrepararEnvio(sfWebRequest $request)
  {      
  	$ocultarPreFiltro = $request->getParameter('ocultarPreFiltro');
  	$idMarca = $request->getParameter('idMarca', false);
  	$idsPedido = $request->getParameter('ids');
  	$idsPedido = explode(',', $idsPedido);
  	  	
  	$pedidos = pedidoTable::getInstance()->listByIds( $idsPedido );
  	$marca = marcaTable::getInstance()->getOneById( $idMarca );

  	$c = count($pedidos);
  	$idsPedido = array();
  	for($i = 0 ; $i < $c ; $i++)
  	{  		
  		$idsPedido[] = $pedidos[$i]->getIdPedido();
  		$idEshop = $pedidos[$i]->getIdEshop();
  	}

  	$eshop = eshopTable::getInstance()->getById( $idEshop );
  	  	
  	// Armado del Form
  	$form = new prepararEnvioForm( array(), array('eshop' => $eshop) );
  	
  	if( $request->isMethod('post') )
  	{
  		$form->bind( $request->getParameter('prepararEnvio') );
  		if ( $form->isValid() )
  		{
  			$form->enviar();
  			$this->redirect('notificacion_backend_start');
  			exit;
  		}
  	}
  	
  	$this->form = $form;
  	$this->pedidos = $pedidos;
  	$this->idsPedido = implode(',', $idsPedido);
  	$this->eshop = $eshop;
  	$this->mostrarPreFiltro = !$eshop && !$ocultarPreFiltro;
  	$this->eshopNombre = ( $eshop ) ? $eshop->getDenominacion() : 'Deluxe Buys';
  	$this->marca = $marca;
  }

  public function executePrepararRemitos(sfWebRequest $request)
  {
  	// Obtengo el formato en el que se van a obtener los remitos
  	$formato = $request->getParameter('formato');

  	// Obtengo los pedidos
  	$idsPedido = $request->getParameter('ids');
  	$idsPedido = explode(',', $idsPedido);

	$pedidos = pedidoTable::getInstance()->listByIds( $idsPedido );

  	// Obtengo el shop  	
	$idEshop = $pedidos[0]->getIdEshop();
  	$eshop = eshopTable::getInstance()->getById( $idEshop );

  	// Obtengo los remitos y sus faltantes
  	$remitos = remitoTable::getInstance()->ultimosRemitosByIdsPedido( $idsPedido, 'p.envio_correo' );
  	$faltantesXPedido = faltanteTable::getInstance()->resumenesFaltantes( $idsPedido );

  	$this->faltantesXPedido = $faltantesXPedido;


  	// Muestro el formato deseado
  	if ( $formato == 'HTML' ) {
  		$this->prepararRemitosHTML($remitos, $idsPedido, $eshop, $faltantesXPedido);
  		$this->setTemplate('prepararRemitosHTML');
  		$this->setLayout('nolayout');
  	} else {
  		$this->prepararRemitosXLS($remitos, $idsPedido, $eshop, $faltantesXPedido);
  	}
  }
  
  protected function prepararRemitosHTML($remitos, $idsPedido, $eshop, $faltantesXPedido)
  {

  	// Defino los parametros de eshop para el remito HTML
  	$configComprobante = sfConfig::get('app_afip_comprobante');
  	$configWS = sfConfig::get('app_afip_ws');
  	if ( $eshop ) {
  	    $razonSocial = $eshop->getRazonSocial();
  	    $domicilioComercial = $eshop->getDomicilioComercial();
  	    $cuit = $eshop->getCuit();
  	    $idEshop = $eshop->getIdEshop();
  	} else {
  	    $razonSocial = $configComprobante['razon_social'];
  	    $domicilioComercial = $configComprobante['domicilio_comercial'];
  	    $cuit = $configWS['cuit'];
  	    $idEshop = null;
  	}
  	  	  	
	// Se arma un array con la informacion de cada remito y su etiqueta correspondiente
  	$data = array();
  	foreach($remitos as $remito)
  	{
  		$etiqueta = base64_encode( EnvioPack::getInstance( $idEshop )->etiqueta( $remito->getIdEnvio() ) );
  		$data[] = array( 'remito' => $remito, 'etiqueta' => $etiqueta );
  	}
  	
  	// Seteo de variables en el template
  	$this->data = $data;
  	$this->dateNow = date('Y-m-d H:i:s');
  	$this->configComprobante = $configComprobante;
  	$this->configWS = $configWS;
  	$this->razonSocial = $razonSocial;
  	$this->cuit = $cuit;  
  	$this->domicilioComercial = $domicilioComercial;
  	
  }

  protected function prepararRemitosXLS($remitos, $idsPedido, $eshop, $faltantesXPedido)
  {
  	set_time_limit(0);
  	
 	
	$phpExcel = new PHPExcel();
	
	$phpExcel->getProperties()->setCreator("DeluxeBuys");
	$activeSheet = $phpExcel->setActiveSheetIndex(0);
	 
	
	$headerCellStyle = array(
	    'font' => array('bold' => true, 'size' => '10', 'color' => array('rgb' => 'FFFFFF')),
	    'fill' => array(
	        'type' => PHPExcel_Style_Fill::FILL_SOLID,
	        'color' => array('rgb' => '333333')
	    ),
	    'borders' => array(
	        'allborders' => array(
	            'style' => PHPExcel_Style_Border::BORDER_THIN,
	            'color' => array('argb' => '000000'))));
	
	$dataCellStyle = array(
	    'font' => array('size' => "10"),
	    'borders' => array(
	        'allborders' => array(
	            'style' => PHPExcel_Style_Border::BORDER_THIN,
	            'color' => array('argb' => '000000'))));
	
	

	$activeSheet->setCellValue('A1', 'Vendedor');
	$activeSheet->getColumnDimension('A')->setWidth(10);

	$activeSheet->setCellValue('B1', 'Referencia Externa');
	$activeSheet->getColumnDimension('B')->setWidth(10);

	$activeSheet->setCellValue('C1', 'Servicio');
	$activeSheet->getColumnDimension('C')->setWidth(20);

	$activeSheet->setCellValue('D1', 'ID Sucursal');
	$activeSheet->getColumnDimension('D')->setWidth(30);

	$activeSheet->setCellValue('E1', 'Nombre');
	$activeSheet->getColumnDimension('E')->setWidth(15);

	$activeSheet->setCellValue('F1', 'Apellido');
	$activeSheet->getColumnDimension('F')->setWidth(15);

	$activeSheet->setCellValue('G1', 'Email');
	$activeSheet->getColumnDimension('G')->setWidth(8);

	$activeSheet->setCellValue('H1', 'Dirección');
	$activeSheet->getColumnDimension('H')->setWidth(22);

	$activeSheet->setCellValue('I1', 'Código Postal');
	$activeSheet->getColumnDimension('I')->setWidth(22);

	$activeSheet->setCellValue('J1', 'Ciudad');
	$activeSheet->getColumnDimension('J')->setWidth(20);

	$activeSheet->setCellValue('K1', 'Provincia');
	$activeSheet->getColumnDimension('K')->setWidth(8);

	$activeSheet->setCellValue('L1', 'Teléfono');
	$activeSheet->getColumnDimension('L')->setWidth(5);

	$activeSheet->setCellValue('M1', 'Referecia Externa del Item');
	$activeSheet->getColumnDimension('M')->setWidth(8);

	$activeSheet->setCellValue('N1', 'Cantidad');
	$activeSheet->getColumnDimension('N')->setWidth(12);

	$activeSheet->setCellValue('O1', 'Titulo del Item');
	$activeSheet->getColumnDimension('O')->setWidth(10);

	$activeSheet->setCellValue('P1', 'Shipping External Reference');
	$activeSheet->getColumnDimension('P')->setWidth(10);

	$activeSheet->setCellValue('Q1', 'Tracking Number');
	$activeSheet->getColumnDimension('Q')->setWidth(20);

	
	$activeSheet->getStyle('A1:Q1')->applyFromArray($headerCellStyle);
	
	$i = 2;
	foreach ($remitos as $remito)
	{
		$pedidos = $remito->getPedidos();

		foreach ($pedidos as $pedido)  {

			$pedidoProductoItems = $pedido->getPedidoProductoItem();
			$usuario = $pedido->getUsuario();
			$eshop = ( $pedido->getIdEshop() ) ? $pedido->getEshop() : null;

					
			foreach ($pedidoProductoItems as $pedidoProductoItem)
			{
				$productoItem = $pedidoProductoItem->getProductoItem();
				$producto = $productoItem->getProducto();

				$cantidadFaltante = ( isset($faltantesXPedido[$pedido->getIdPedido()]) && isset($faltantesXPedido[$pedido->getIdPedido()][ $pedidoProductoItem->getIdProductoItem() ]) ) ? $faltantesXPedido[$pedido->getIdPedido()][ $pedidoProductoItem->getIdProductoItem() ] : 0 ;
				$cantidad = $pedidoProductoItem->getCantidad() - $cantidadFaltante;

				if ( $cantidad <= 0 ) {
					continue;
				}
				
				$activeSheet->setCellValue('A' . $i, '54' );
				$activeSheet->setCellValue('B' . $i, $pedido->getIdPedido() );
				$activeSheet->setCellValue('C' . $i, 'custom_service' );
				$activeSheet->setCellValue('D' . $i, '' );
				$activeSheet->setCellValue('E' . $i, $pedido->getNombre() );
				$activeSheet->setCellValue('F' . $i, $pedido->getApellido() );
				$activeSheet->setCellValue('G' . $i, $pedido->getEmail() );


				$envioDetalle = $pedido->getArrayEnvioDetalle();
		
				if ($envioDetalle['tipo'] == CarritoEnvio::SUCURSAL) {
					$activeSheet->setCellValue('H' . $i, 'Sucursal: ' . $envioDetalle['direccion'] );
					
				} else {
					$activeSheet->setCellValue('H' . $i, $envioDetalle['direccion'] );
				}	

				$activeSheet->setCellValue('I' . $i, $envioDetalle['codigo_postal'] );
				$activeSheet->setCellValue('J' . $i, $envioDetalle['localidad'] );
				$activeSheet->setCellValue('K' . $i, $envioDetalle['provincia'] );
				
				if ( $pedido->getCelular() ) {
					$activeSheet->setCellValueExplicit('L' . $i, $pedido->getCelular(), PHPExcel_Cell_DataType::TYPE_STRING);

				} else {
					$activeSheet->setCellValueExplicit('L' . $i, $pedido->getTelefono(), PHPExcel_Cell_DataType::TYPE_STRING);
				}

				$activeSheet->setCellValue('M' . $i, $productoItem->getCodigo() );
				$activeSheet->setCellValue('N' . $i, $cantidad );
				$activeSheet->setCellValue('O' . $i, $producto->getDenominacion() . ' Talle: ' . $pedidoProductoItem->getProductoTalle()->getDenominacion() . ' Color: ' . $pedidoProductoItem->getProductoColor()->getDenominacion() );
				
				$activeSheet->setCellValue('P' . $i, $pedido->getEnvioCorreo() );
				$activeSheet->setCellValue('Q' . $i, $pedido->getCodigoEnvio() );

				$activeSheet->getStyle('A' . $i . ':Q' . $i )->applyFromArray($dataCellStyle);

				$i++;
			}
		}
	}
	
			 
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="remitos.xls"');
	header('Cache-Control: max-age=0');
	
	$writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
	$writer->save('php://output');
	exit;
  }
  
  protected function executeBatchFacturar(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    
    $pedidos = pedidoTable::getInstance()->listByIds( $ids );

    foreach ($pedidos as $pedido)
    {
    	$pedido->setFechaFacturacion( new Doctrine_Expression('now()') );
    	$pedido->save();
    }
    
    $this->getUser()->setFlash('notice', 'Los pedidos seleccionados se han marcado como facturados.');
    $this->redirect('@pedido');
  }
  
  protected function executeBatchRecepcionMercaderiaEshop(sfWebRequest $request)
  {  
    $ids = $request->getParameter('ids');
    $params['ids'] = implode(',', $ids); 
    
    $url = $this->getController()->genUrl( array(	'sf_route' => 'pedidos_recepcion_mercaderia_eshop') );
    
    $this->redirect( $url . '?' . http_build_query($params) );
  }

  public function executeRecepcionMercaderiaEshop(sfWebRequest $request)
  {
  	$idsPedido = $request->getParameter('ids');
  	$idsPedido = explode(',', $idsPedido);
  	  	
  	$pedidos = pedidoTable::getInstance()->listByIds( $idsPedido );
  	$faltantes = productoItemTable::getInstance()->getCantidadFaltantesByIdsPedido( $idsPedido );

  	$idEshop = $pedidos[0]->getIdEshop();

  	$productos = array();
  	foreach ($pedidos as $pedido) {
  		$pedidoProductoItems = $pedido->getPedidoProductoItem();

  		foreach ($pedidoProductoItems as $pedidoProductoItem) {
  			$productoItem = $pedidoProductoItem->getProductoItem();
  			$producto = $productoItem->getProducto();

  			if ( !isset($productos[ $productoItem->getIdProductoItem() ]) ) {

  				$idProductoItem = $pedidoProductoItem->getIdProductoItem();
  				$faltante = isset( $faltantes[ $idProductoItem ] ) ? $faltantes[ $idProductoItem ] : 0;
				
				$row = array(
					'id_producto_item'   => $pedidoProductoItem->getIdProductoItem(),
		            'nombre' 			 => $producto->getDenominacion(),
		            'img' 				 => imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto ) ,
		            'img_grande' 		 => imageHelper::getInstance()->getUrl('producto_detalle_mediana', $producto ) ,
		            'codigo' 			 => $productoItem->getCodigo(),
		            'color' 			 => $pedidoProductoItem->getProductoColor()->getDenominacion(),
		            'talle' 			 => $pedidoProductoItem->getProductoTalle()->getDenominacion(),
		            'costo' 			 => $pedidoProductoItem->getCosto(),
		            'costoSinIva' 		 => $pedidoProductoItem->getCostoSinIva(),
		            'cantidad' 			 => $pedidoProductoItem->getCantidad(),
		            'faltantesInformado' => $faltante,
		            'cantidadARecibir' 	 => $pedidoProductoItem->getCantidad() - $faltante
				);

	            $productos[ $productoItem->getIdProductoItem() ] = $row;

  			} else {
  				$productos[ $productoItem->getIdProductoItem() ]['cantidad'] += $pedidoProductoItem->getCantidad();
  				$productos[ $productoItem->getIdProductoItem() ]['cantidadARecibir'] += $pedidoProductoItem->getCantidad();
  			}
  		}
  	}

    $form = new recepcionMercaderiaEshopForm( array(), array( 'productos' => $productos) );

    if( $request->isMethod('post') )
    {
      $form->bind( $request->getParameter('recepcionMercaderiaEshop') );

      if ( $form->isValid() )
      {
        $faltantes = $form->execute();

        $idsPedido = array();
        foreach ($pedidos as $pedido) {
        	if ( !$pedido->todosSonFaltantes() ) {
        		$idsPedido[] = $pedido->getIdPedido();	
        	}
        	
        }

        if ( count( $faltantes ) ) {
          $params = array( 'tipo' => 'ESHOP', 'idEshop' => $idEshop, 'faltantes' => implode(',', $faltantes), 'idsPedido' => implode(',', $idsPedido) ); 
          $url = $this->getController()->genUrl( array( 'sf_route' => 'faltantes_generacionAutomatica') );          
          $this->redirect( $url . '?' . http_build_query($params) );
        } else if( count( $idsPedido ) ) {
          $params = array( 'ids' => implode(',', $idsPedido) ); 
          $url = $this->getController()->genUrl( array( 'sf_route' => 'pedido_preparar_envio') );          
          $this->redirect( $url . '?' . http_build_query($params) );
        } else {
          $this->redirect( 'pedidos_recepcionMercaderia_no_envios' );
        }
      }
    }

    $this->form = $form;
    $this->productos = $productos;
    $this->faltantes = $faltantes;
  }

  public function executeNoHayEnviosDisponibles(sfWebRequest $request)
  {

  }

  public function executeChangeEstado(sfWebRequest $request)
  {
  	$idPedido = $request->getParameter('idPedido');
  	$estado = $request->getParameter('estado');
  	
  	$pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);
  	  	  	  	
  	switch ($estado)
  	{
  		case 'NO_PAGADO':
  				$pedido->setFechaPago( null );
  				break;
  		case 'PROCESAR_PAGO':
  				$pedido->procesarPago();
  				break;
		case 'PAGADO':
				$pedido->marcarComoPagado();
		        break;
  				
  		case 'NO_FACTURADO':
  				$pedido->setFechaFacturacion( null );
  				break;
  		case 'FACTURADO':
  				$pedido->setFechaFacturacion( new Doctrine_Expression('now()') );
  				break;
  		case 'BAJA':
				$pedido->procesarBajaManual();
  				break;
		case 'BAJA_SIN_MODIF_STOCK':
    			$pedido->procesarBajaManual(false);
		        break;
  		case 'ALTA':
  				$pedido->procesarAltaManual();
  				break;
		case 'ALTA_SIN_MODIF_STOCK':
		        $pedido->procesarAltaManual(false);
		        break;
        case 'OCA_ERROR_ENVIO':
                $pedido->setTieneProblemaOca(true);
          		$pedido->setCodigoEnvio(null);
          		$pedido->setFechaEnvio( null );
                break;
        case 'OCA_NO_ERROR_ENVIO':
                $pedido->setTieneProblemaOca(false);
                break;
  	}
  	
  	$pedido->setRequiereIntervencionManual(pedido::INTEVENCION_MANUAL_NO_REQUIERE);  	
    $pedido->save();
  	
  	$this->redirect('/backend/pedidos/' . $idPedido . '/ListView');
  }
  
  public function executeChangeEstadoEnvio(sfWebRequest $request)
  {
  	$idPedido = $request->getParameter('idPedido');
  	$codigo = $request->getParameter('codigo');
  	
  	$pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);
  	
  	if ($codigo)
  	{
	  	$pedido->setCodigoEnvio($codigo);
	  	$pedido->setFechaEnvio( new Doctrine_Expression('now()') );
	  	$pedido->enviarGuiaEnvio();
	  	
	  	$pedido->setRequiereIntervencionManual(pedido::INTEVENCION_MANUAL_NO_REQUIERE);	
  	}
  	else
  	{
  		$pedido->setCodigoEnvio(null);
  		$pedido->setFechaEnvio( null );
  	}
  	$pedido->save();  	
  	  	
  	$this->redirect('/backend/pedidos/' . $idPedido . '/ListView');
  }
  
  public function executeQuitarIntervencionManual(sfWebRequest $request)
  {
  	$idPedido = $request->getParameter('idPedido');
  	
  	$pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);
  	$pedido->setRequiereIntervencionManual(pedido::INTEVENCION_MANUAL_NO_REQUIERE);
  	$pedido->save();
  
  	$this->redirect('/backend/pedidos/' . $idPedido . '/ListView');
  }
  
  
  protected function isValidSortColumn($column)
  {
  	return (Doctrine::getTable('pedido')->hasColumn($column) || $column == 'datos_cliente');
  }
  
  protected function addSortQuery($query)
  {
  	if (array(null, null) == ($sort = $this->getSort()))
  	{
  		return;
  	}
  	
  	if ($sort[0] == 'datos_cliente')
  	{
  		$rootAlias = $query->getRootAlias();
  		$query->innerJoin( $rootAlias . '.usuario u');
  		$query->orderBy( 'u.nombre ' . $sort[1] . ', u.apellido ' . $sort[1]);
  	}
  	else
  	{
  		if (!in_array(strtolower($sort[1]), array('asc', 'desc')))
  		{
  			$sort[1] = 'asc';
  		}
  		
  		$query->addOrderBy($sort[0] . ' ' . $sort[1]);
  	}
  }
  
  public function executeGetJsonInfo(sfWebRequest $request)
  {
      $idPedido = $request->getParameter('idPedido');
            
      $pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);
      
      if ( !$pedido )
      {
          echo json_encode(array('status' => false));
          exit;
      }

      $pedidoProductoItems = $pedido->getPedidoProductoItem();
      
      $data = array();
      $data['pedido'] = $pedido->getData();
      $data['pedidoProductoItem'] = array();
      
      foreach ( $pedidoProductoItems as $pedidoProductoItem )
      {
          $row = array();
          
          $productoItem = $pedidoProductoItem->getProductoItem();
          $producto = $productoItem->getProducto();
          
          $row['idPedidoProductoItem'] = $pedidoProductoItem->getIdPedidoProductoItem(); 
          $row['denominacion'] = $producto->getDenominacion();
          $row['marca'] = $producto->getMarca()->getNombre();
          $row['talle'] = $productoItem->getProductoTalle()->getDenominacion();
          $row['color'] = $productoItem->getProductoColor()->getDenominacion();
          $row['cantidad'] = $pedidoProductoItem->getCantidad();
          
          $data['pedidoProductoItem'][] = $row;
      }      
      
      echo json_encode( array('status' => true, 'data' => $data) );
      exit;
  }
   
  
}
