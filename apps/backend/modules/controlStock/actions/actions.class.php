<?php

require_once dirname(__FILE__).'/../lib/controlStockGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/controlStockGeneratorHelper.class.php';

/**
 * controlStock actions.
 *
 * @package    deluxebuys
 * @subpackage controlStock
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class controlStockActions extends autoControlStockActions
{
	
  protected function executeBatchDescargarReposicion(sfWebRequest $request)
  {
  	set_time_limit(0);
  	
    $ids = $request->getParameter('ids');
    
    $productosItem = productoItemTable::getInstance()->listByIdsProductoItem( $ids );
    
    $marca = $productosItem->getFirst()->getProducto()->getMarca();
  	
  	$dateNow = date('Y-m-d H:i:s');
  	
	$phpExcel = new PHPExcel();
	
	$phpExcel->getProperties()->setCreator("DeluxeBuys");
	$activeSheet = $phpExcel->setActiveSheetIndex(0);
	 
	$activeSheet->setCellValue('A1', 'Deluxebuys - Planilla de Reposición');
	$activeSheet->mergeCells('A1:D1');
	$activeSheet->mergeCells('A2:D2');
				
	$activeSheet->setCellValue('A3', 'Generada: ' . $dateNow);
	$activeSheet->mergeCells('A3:D3');
	$activeSheet->mergeCells('A4:D4');
	
	$activeSheet->setCellValue('A5', 'Marca: ' . $marca->getNombre() );
	$activeSheet->mergeCells('A5:D5');
	$activeSheet->mergeCells('A6:D6');
	
	
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
		
	$activeSheet->setCellValue('A7', 'Producto');
	$activeSheet->getStyle('A7')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('B7', 'Artículo');
	$activeSheet->getStyle('B7')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('C7', 'Talle');
	$activeSheet->getStyle('C7')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('D7', 'Color');
	$activeSheet->getStyle('D7')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('E7', 'Cantidad');
	$activeSheet->getStyle('E7')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('F7', 'Total');
	$activeSheet->getStyle('F7')->applyFromArray($headerCellStyle);
	
	$activeSheet->setCellValue('G7', 'Trajeron');
	$activeSheet->getStyle('G7')->applyFromArray($headerCellStyle);	
	
	$activeSheet->getColumnDimensionByColumn('A')->setAutosize(true);
	$activeSheet->getColumnDimension('A')->setWidth(18);
	
	$activeSheet->getColumnDimensionByColumn('B')->setAutosize(true);
	$activeSheet->getColumnDimension('B')->setWidth(18);
	
	$activeSheet->getColumnDimensionByColumn('C')->setAutosize(true);
	$activeSheet->getColumnDimension('C')->setWidth(12);
	
	$activeSheet->getColumnDimensionByColumn('D')->setAutosize(true);
	$activeSheet->getColumnDimension('D')->setWidth(12);
	
	$activeSheet->getColumnDimensionByColumn('E')->setAutosize(true);
	$activeSheet->getColumnDimension('E')->setWidth(10);
	
	$activeSheet->getColumnDimensionByColumn('F')->setAutosize(true);
	$activeSheet->getColumnDimension('F')->setWidth(8);
	
	$activeSheet->getColumnDimensionByColumn('G')->setAutosize(true);
	$activeSheet->getColumnDimension('G')->setWidth(10);
	
	
	$i = 8;
	foreach ($productosItem as $productoItem)
	{
		$producto = $productoItem->getProducto();
		$productoTalle = $productoItem->getproductoTalle();
		$productoColor = $productoItem->getproductoColor();
		
		$activeSheet->setCellValue('A' . $i, $producto->getDenominacion() );
		$activeSheet->getStyle('A' . $i)->applyFromArray($dataCellStyle);
		
		$activeSheet->setCellValue('B' . $i, $productoItem->getCodigo() );
		$activeSheet->getStyle('B' . $i)->applyFromArray($dataCellStyle);
		
		$activeSheet->setCellValue('C' . $i, $productoTalle->getDenominacion() );
		$activeSheet->getStyle('C' . $i)->applyFromArray($dataCellStyle);
		
		$activeSheet->setCellValue('D' . $i, $productoColor->getDenominacion() );
		$activeSheet->getStyle('D' . $i)->applyFromArray($dataCellStyle);
		
		$activeSheet->setCellValue('E' . $i, $productoItem->getStockLimite() * 2 );
		$activeSheet->getStyle('E' . $i)->applyFromArray($dataCellStyle);
		
		$activeSheet->setCellValue('F' . $i, '');
		$activeSheet->getStyle('F' . $i)->applyFromArray($dataCellStyle);
					
		$activeSheet->setCellValue('G' . $i, '');
		$activeSheet->getStyle('G' . $i)->applyFromArray($dataCellStyle);
		
		$i++;
	}
	

	$filename = $marca->getNombre() . ' - Planilla de Reposición.xls';
	
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="' . $filename . '"');
	header('Cache-Control: max-age=0');
	
	$writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
	$writer->save('php://output');
	
	exit;
  }
  
  public function executeDescargarExcel(sfWebRequest $request)
  {
      set_time_limit(0);
          
      $filters = $this->getFilters();

      $resumenFiltro['marca'] = 'Todas';
      if (isset($filters["marca"]) ) $resumenFiltro['marca'] = marcaTable::getInstance()->getOneById( $filters["marca"] );
            
      $resumenFiltro['diversidad'] = 'Todas';
      if (isset($filters["diversidad"]) ) $resumenFiltro['diversidad'] = productoItemFormFilter::$choicesDiversidad[ $filters["diversidad"] ];
      
      $resumenFiltro['activo'] = 'Si/No';
      if (isset($filters["activo"]) ) $resumenFiltro['activo'] = ($filters["activo"]) ? 'Si' : 'No';
      
      $resumenFiltro['atencion'] = 'No';
      if (isset($filters["atencion"]) && $filters["atencion"]) $resumenFiltro['atencion'] = 'Si';
                	
      $dateNow = date('Y-m-d H:i:s');
      	
      $phpExcel = new PHPExcel();
        
      $phpExcel->getProperties()->setCreator("DeluxeBuys");
      $activeSheet = $phpExcel->setActiveSheetIndex(0);
      
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
         
      $activeSheet->setCellValue('A1', 'Deluxebuys - Control de Stock');
      $activeSheet->mergeCells('A1:F1');
      $activeSheet->mergeCells('A2:F2');
        			
      $activeSheet->setCellValue('A3', 'Generada: ' . $dateNow);
      $activeSheet->mergeCells('A3:F3');
        	
      $activeSheet->setCellValue('A4', 'Marca: ' . $resumenFiltro['marca']);
      $activeSheet->mergeCells('A4:F4');
        
      $activeSheet->setCellValue('A5', 'Diversidad: ' . $resumenFiltro['diversidad']);
      $activeSheet->mergeCells('A5:F5');
        
      $activeSheet->setCellValue('A6', 'Productos Activos: ' . $resumenFiltro['activo']);
      $activeSheet->mergeCells('A6:F6');
      
      $activeSheet->setCellValue('A7', 'Listar solo productos que requieran atención: ' . $resumenFiltro['atencion']);
      $activeSheet->mergeCells('A7:F7');
        
      $activeSheet->setCellValue('A9', 'Marca: ' . $resumenFiltro['marca']);
      $activeSheet->mergeCells('A9:F9');
    	
      $activeSheet->setCellValue('A11', 'Marca');
      $activeSheet->setCellValue('B11', 'Diversidad');
      $activeSheet->setCellValue('C11', 'Codigo');
      $activeSheet->setCellValue('D11', 'Denominacion');
      $activeSheet->setCellValue('E11', 'Costo');
      $activeSheet->setCellValue('F11', 'Talle');
      $activeSheet->setCellValue('G11', 'Color');
      $activeSheet->setCellValue('H11', 'No Pag.');
      $activeSheet->setCellValue('I11', 'Pag.');
      $activeSheet->setCellValue('J11', 'Ent.');
      $activeSheet->setCellValue('K11', 'STK Lim.');
      $activeSheet->setCellValue('L11', 'Waitlist');
      $activeSheet->setCellValue('M11', 'STK');
      
      $activeSheet->getStyle('A11:M11')->applyFromArray($headerCellStyle);
      
      $productoItems = $this->buildQuery()->execute();
      
      $i = 12;      
      foreach ($productoItems as $productoItem)
      {
          $producto = $productoItem->getProducto();
          $marca = $producto->getMarca();
          $productoTalle = $productoItem->getProductoTalle(); 
          $productoColor = $productoItem->getProductoColor();
          
          
          $noPag = pedidoProductoItemTable::getInstance()->getCantidadNoPagadosByIdProductoItem( $productoItem->getIdProductoItem() );
          $pag   = pedidoProductoItemTable::getInstance()->getCantidadPagadosByIdProductoItem( $productoItem->getIdProductoItem() );
          $ent   = pedidoProductoItemTable::getInstance()->getCantidadEntregadosByIdProductoItem( $productoItem->getIdProductoItem() );
          $waitList = waitingListTable::getInstance()->listByIdProductoItem( $productoItem->getIdProductoItem() );
          
          $activeSheet->setCellValue('A' . $i, $marca->getNombre() );
          $activeSheet->setCellValue('B' . $i, $producto->esOferta() ? 'Flash Sale' : 'Stock Permanente' );
          $activeSheet->setCellValue('C' . $i, $productoItem->getCodigo() );
          $activeSheet->setCellValue('D' . $i, $producto->getDenominacion() );
          $activeSheet->setCellValue('E' . $i, $producto->getCosto() );
          $activeSheet->setCellValue('F' . $i, $productoTalle->getDenominacion() );
          $activeSheet->setCellValue('G' . $i, $productoColor->getDenominacion() );
          $activeSheet->setCellValue('H' . $i, $noPag );
          $activeSheet->setCellValue('I' . $i, $pag );
          $activeSheet->setCellValue('J' . $i, $ent );
          $activeSheet->setCellValue('K' . $i, $productoItem->getStockLimite() );
          $activeSheet->setCellValue('L' . $i, $waitList );
          
          $activeSheet->setCellValue('M' . $i, $productoItem->getstockPermanente() );
          
          $activeSheet->getStyle('A' . $i . ':L' . $i)->applyFromArray($dataCellStyle);
          
          
          $color = array('rojo' => 'FCC7C7', 'amarillo' => 'FCFCC7', 'verde' => 'DBFCC7');
          
          $stockCellStyle = array(
                  'borders' => array(
                          'allborders' => array(
                                  'style' => PHPExcel_Style_Border::BORDER_THIN,
                                  'color' => array('argb' => '000000'))),
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb'=> $color[ $productoItem->getColorStock() ] )));
          
          $activeSheet->getStyle('M' . $i)->applyFromArray($stockCellStyle);
          
          $i++;
      }
      
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="reporte.xls"');
      header('Cache-Control: max-age=0');
      
      $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
      $writer->save('php://output');
      
      exit;
  }
	
}
