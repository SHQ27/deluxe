<?php

class ordenCompraHelper
{
	static protected $instance;
	
	protected $config;

	protected function __construct()
	{
	}
		
	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new ordenCompraHelper();
		}
		
		return self::$instance;
	}

	public function makeOrdenCompra($idEshop, $fechaDesde, $fechaHasta, $idMarca, $downloadEnabled, $idCampana = null, $zipGroup = null, $origenStock = false, $mostrarPedidos = false)
	{	    
	    if ($idCampana)
	    {
	        $pedidoProductoItems = pedidoProductoItemTable::getInstance()->ordenDeCompraByIdCampana( $fechaDesde, $fechaHasta, $idCampana, $idMarca, $origenStock);
	    }
	    else
	    {
	        $pedidoProductoItems = pedidoProductoItemTable::getInstance()->ordenDeCompraByIdMarca( $idEshop, $fechaDesde, $fechaHasta, $idMarca, $origenStock);
	    }	    
	
	    $productos = array();
	    foreach ($pedidoProductoItems as $pedidoProductoItem)
	    {
	        if (!isset($productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()]))
	        {
	        	$productoItem = $pedidoProductoItem->getProductoItem();
	            $producto = $productoItem->getProducto();
	
	            $marca = $producto->getMarca();
	
				$row['id_producto_item']   = $pedidoProductoItem->getIdProductoItem();
	            $row['nombre'] 			   = $producto->getDenominacion();
	            $row['img'] 			   = imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto ) ;
	            $row['img_grande'] 		   = imageHelper::getInstance()->getUrl('producto_detalle_mediana', $producto ) ;
	            $row['codigo'] 			   = $productoItem->getCodigo();
	            $row['color'] 			   = $pedidoProductoItem->getProductoColor()->getDenominacion();
	            $row['talle'] 			   = $pedidoProductoItem->getProductoTalle()->getDenominacion();
	            $row['costo'] 			   = $pedidoProductoItem->getCosto();
	            $row['costoSinIva'] 	   = $pedidoProductoItem->getCostoSinIva();
	            $row['precio'] 			   = $pedidoProductoItem->getPrecioDeluxe();
	            $row['cantidad'] 		   = 0;
	            $row['cantidadOutlet'] 	   = 0;
	            $row['cantidadSTKPER']     = 0;
	            $row['cantidadOFERTA']     = 0;
	            $row['cantidadREFUER']     = 0;
	            $row['ids_pedidos'] 	   = array();

	            $productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()] = $row;
	        }

	        if ($pedidoProductoItem->getOrigen() != producto::ORIGEN_OUTLET)
	        {
	        	$stocks = $pedidoProductoItem->getStock();
	        	$cantidad = 0;
	        	foreach ($stocks as $stock) {
	        		$cantidad += $stock->getCantidad();

					$productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()]['cantidad' . $stock->getOrigen()] += abs($stock->getCantidad());
	        	}

	        	$cantidad = abs($cantidad);

	            $productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()]['cantidad'] += $cantidad;
	        }
	        else
	        {
	            $productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()]['cantidadOutlet'] += $pedidoProductoItem->getCantidad();
	        }
	
	        $subTotal = round( $productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()]['cantidad'] * $productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()]['costo'], 2);
	        $subTotal = sprintf('%01.2f', $subTotal);
	        $productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()]['subtotal'] = $subTotal;
	
	        $subtotalSinIva = round( $productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()]['cantidad'] * $productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()]['costoSinIva'], 2);
	        $subtotalSinIva = sprintf('%01.2f', $subtotalSinIva);
	        $productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()]['subtotalSinIva'] = $subtotalSinIva;

			// Armado de columna para mostrar pedidos
			if ( $mostrarPedidos && !in_array($pedidoProductoItem->getIdPedido(), $row['ids_pedidos'] ) ) {
				$productos[$pedidoProductoItem->getIdProductoItem() . '_' . $pedidoProductoItem->getCosto()]['ids_pedidos'][] = $pedidoProductoItem->getIdPedido();	
			}
	
	    }
	    
	    if ( !$downloadEnabled ) return $productos;
	
	    $marca = marcaTable::getInstance()->getOneById( $idMarca );
	    $marcaNombre = ($marca)? $marca->getNombre() : 'Todas';
	    $marcaSlug = ($marca)? $marca->getSlug() : '';
	    
	    $eshop = eshopTable::getInstance()->getById( $idEshop );
	    $eshopNombre = ($eshop)? $eshop->getDenominacion() : 'Deluxe Buys';
	    $eshopSlug = StringHelper::getInstance()->slug( $eshopNombre ); 
	
	    $campana = campanaTable::getInstance()->getById( $idCampana );
	    $campanaDenominacion = ($campana)? $campana->getDenominacion() : '-';
	    $campanaSlug = ($campana)? $campana->getSlug() : '';
	
	    $dateNow = date('Y-m-d H:i:s');
	
	    // Armo orden_de_compra.xls
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
	
	    $dataCellStyle = array(
	            'borders' => array(
	                    'allborders' => array(
	                            'style' => PHPExcel_Style_Border::BORDER_THIN,
	                            'color' => array('argb' => '000000'))));
	
	
	
	
	    $activeSheet->setCellValue('A1', 'Deluxebuys - Orden de compra');
	    $activeSheet->mergeCells('A1:G1');
	    $activeSheet->mergeCells('A2:G2');
	
	    
	    $activeSheet->setCellValue('A3', 'Del ' . $fechaDesde . ' hasta el ' . $fechaHasta );
	    $activeSheet->mergeCells('A3:G3');
	    
	    $activeSheet->setCellValue('A4', 'eShop: ' . $eshopNombre );
	    $activeSheet->mergeCells('A4:G4');
	    	
	    $activeSheet->setCellValue('A5', 'Campaña: ' . $campanaDenominacion );
	    $activeSheet->mergeCells('A5:G5');
	
	    $activeSheet->setCellValue('A6', 'Marca: ' . $marcaNombre );
	    $activeSheet->mergeCells('A6:G6');
	
	    $activeSheet->setCellValue('A7', 'Generada: ' . $dateNow);
	    $activeSheet->mergeCells('A7:G7');
	
	    $activeSheet->setCellValue('A12', 'Cant.');
	    $activeSheet->getStyle('A12')->applyFromArray($headerCellStyle);
	    $activeSheet->getColumnDimensionByColumn('A')->setAutosize(true);
	    $activeSheet->getColumnDimension('A')->setWidth(8);
	
	    $activeSheet->setCellValue('B12', 'Producto');
	    $activeSheet->getStyle('B12')->applyFromArray($headerCellStyle);
	    $activeSheet->getColumnDimensionByColumn('B')->setAutosize(true);
	    $activeSheet->getColumnDimension('B')->setWidth(32);
	
	    $activeSheet->setCellValue('C12', 'Cod prod');
	    $activeSheet->getStyle('C12')->applyFromArray($headerCellStyle);
	    $activeSheet->getColumnDimensionByColumn('C')->setAutosize(true);
	    $activeSheet->getColumnDimension('C')->setWidth(18);
	
	    $activeSheet->setCellValue('D12', 'Color');
	    $activeSheet->getStyle('D12')->applyFromArray($headerCellStyle);
	    $activeSheet->getColumnDimensionByColumn('D')->setAutosize(true);
	    $activeSheet->getColumnDimension('D')->setWidth(14);
	
	    $activeSheet->setCellValue('E12', 'Talle');
	    $activeSheet->getStyle('E12')->applyFromArray($headerCellStyle);
	    $activeSheet->getColumnDimensionByColumn('E')->setAutosize(true);
	    $activeSheet->getColumnDimension('E')->setWidth(14);
	
	    $activeSheet->setCellValue('F12', 'Costo');
	    $activeSheet->getStyle('F12')->applyFromArray($headerCellStyle);
	    $activeSheet->getColumnDimensionByColumn('F')->setAutosize(true);
	    $activeSheet->getColumnDimension('F')->setWidth(8);
	
	    $activeSheet->setCellValue('G12', 'Costo (Sin Iva)');
	    $activeSheet->getStyle('G12')->applyFromArray($headerCellStyle);
	    $activeSheet->getColumnDimensionByColumn('G')->setAutosize(true);
	    $activeSheet->getColumnDimension('G')->setWidth(8);
	
	    $activeSheet->setCellValue('H12', 'Total');
	    $activeSheet->getStyle('H12')->applyFromArray($headerCellStyle);
	    $activeSheet->getColumnDimensionByColumn('H')->setAutosize(true);
	    $activeSheet->getColumnDimension('H')->setWidth(8);
	
	    $activeSheet->setCellValue('I12', 'Total (Sin Iva)');
	    $activeSheet->getStyle('I12')->applyFromArray($headerCellStyle);
	    $activeSheet->getColumnDimensionByColumn('I')->setAutosize(true);
	    $activeSheet->getColumnDimension('I')->setWidth(8);

	    if ( $mostrarPedidos ) {
		    $activeSheet->setCellValue('J12', 'Pedidos Relacionados');
		    $activeSheet->getStyle('J12')->applyFromArray($headerCellStyle);
		    $activeSheet->getColumnDimensionByColumn('J')->setAutosize(true);
		    $activeSheet->getColumnDimension('J')->setWidth(500);
	    }
	
	    $i = 13;
	    $total = 0;
	    $totalSinIva = 0;
	    $cantidadTotal = 0;
	    foreach($productos as $producto)
	    {
	        if ( $producto['cantidad'] <= 0 ) continue;
	
	        $cantidadTotal += $producto['cantidad'];
	        $activeSheet->setCellValue('A' . $i, $producto['cantidad']);
	        $activeSheet->setCellValue('B' . $i, $producto['nombre']);
	        $activeSheet->setCellValue('C' . $i, $producto['codigo']);
	        $activeSheet->setCellValue('D' . $i, $producto['color']);
	        $activeSheet->setCellValue('E' . $i, $producto['talle']);
	        $activeSheet->setCellValue('F' . $i, $producto['costo']);
	        $activeSheet->setCellValue('G' . $i, $producto['costoSinIva']);
	
	        $activeSheet->setCellValue('H' . $i, $producto['subtotal']);
	        $activeSheet->setCellValue('I' . $i, $producto['subtotalSinIva']);

		    if ( $mostrarPedidos ) {
		    	$activeSheet->setCellValueExplicit('J' . $i, implode(', ', $producto['ids_pedidos']), PHPExcel_Cell_DataType::TYPE_STRING);
		    }
	
	        $activeSheet->getRowDimension($i)->setRowHeight(-1);
	        $activeSheet->getStyle('A' . $i)->applyFromArray($dataCellStyle);
	        $activeSheet->getStyle('B' . $i)->applyFromArray($dataCellStyle);
	        $activeSheet->getStyle('C' . $i)->applyFromArray($dataCellStyle);
	        $activeSheet->getStyle('D' . $i)->applyFromArray($dataCellStyle);
	        $activeSheet->getStyle('E' . $i)->applyFromArray($dataCellStyle);
	        $activeSheet->getStyle('F' . $i)->applyFromArray($dataCellStyle);
	        $activeSheet->getStyle('G' . $i)->applyFromArray($dataCellStyle);
	        $activeSheet->getStyle('H' . $i)->applyFromArray($dataCellStyle);
	        $activeSheet->getStyle('I' . $i)->applyFromArray($dataCellStyle);

		    if ( $mostrarPedidos ) {
			    $activeSheet->getStyle('J' . $i)->applyFromArray($dataCellStyle);
		    }
	
	        $total += $producto['subtotal'];
	        $totalSinIva += $producto['subtotalSinIva'];
	
	        $i++;
	    }
	
	    $activeSheet->setCellValue('A' . $i, $cantidadTotal);
	    $activeSheet->getStyle('A' . $i)->applyFromArray($headerCellStyle);
	    $activeSheet->setCellValue('G' . $i, 'Totales');
	    $activeSheet->getStyle('G' . $i)->applyFromArray($headerCellStyle);
	    $activeSheet->setCellValue('H' . $i, $total);
	    $activeSheet->getStyle('H' . $i)->applyFromArray($headerCellStyle);
	    $activeSheet->setCellValue('I' . $i, $totalSinIva);
	    $activeSheet->getStyle('I' . $i)->applyFromArray($headerCellStyle);
	
	    $i = $i + 3;
	    $activeSheet->setCellValue('B' . $i, 'Datos para facturar:');
	
	    $i = $i + 1;
	    $activeSheet->setCellValue('B' . $i, 'Razón Social:');
	    $activeSheet->setCellValue('C' . $i, 'Deluxebuys SA');
	    $activeSheet->mergeCells("C$i:G$i");
	
	    $i = $i + 1;
	    $activeSheet->setCellValue('B' . $i, 'CUIT:');
	    $activeSheet->setCellValue('C' . $i, '30-71163524-2');
	    $activeSheet->mergeCells("C$i:G$i");
	
	    $i = $i + 1;
	    $activeSheet->setCellValue('B' . $i, 'Dirección:');
	    $activeSheet->setCellValue('C' . $i, 'Guatemala 4551 (Portería)');
	    $activeSheet->mergeCells("C$i:G$i");
	
	    $i = $i + 1;
	    $activeSheet->setCellValue('B' . $i, 'Teléfono:');
	    $activeSheet->setCellValue('C' . $i, '3970-5712');
	    $activeSheet->mergeCells("C$i:G$i");
	
	    $i = $i + 2;
	    $activeSheet->setCellValue('B' . $i, 'Contacto administrativo:');
	    $activeSheet->setCellValue('C' . $i, 'javier.deluxebuys@gmail.com');
	    $activeSheet->mergeCells("C$i:G$i");
	
	    $i = $i + 1;
	    $activeSheet->setCellValue('B' . $i, 'Contacto logística:');
	    $activeSheet->setCellValue('C' . $i, 'javier.deluxebuys@gmail.com');
	    $activeSheet->mergeCells("C$i:G$i");
	
	    $i = $i + 1;
	    $activeSheet->setCellValue('B' . $i, 'Contacto comercial:');
	    $activeSheet->setCellValue('C' . $i, 'javier.deluxebuys@gmail.com');
	    $activeSheet->mergeCells("C$i:G$i");
	
	    $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
	
	    if ($zipGroup)
	    {
	        $writer->save(sfConfig::get('sf_temp_dir') . '/orden_de_compra_' . $eshopSlug . '_' . $marcaSlug . '_' . $zipGroup . '.xls');
	    }
	    else
	    {
	        $identificador = ($campanaSlug)? $eshopSlug . '_' . $campanaSlug : $eshopSlug . '_' .$marcaSlug;
	
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="orden_de_compra_' . $identificador . '.xls"');
	        header('Cache-Control: max-age=0');
	        $writer->save('php://output');
	    }
	
	    return $productos;
	}
}



