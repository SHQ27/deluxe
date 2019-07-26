<?php

require_once dirname(__FILE__).'/../lib/devolucionesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/devolucionesGeneratorHelper.class.php';

/**
 * devoluciones actions.
 *
 * @package    deluxebuys
 * @subpackage devoluciones
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class devolucionesActions extends autoDevolucionesActions
{

    public function executeVer(sfWebRequest $request)
    {
        $idDevolucion = $request->getParameter('idDevolucion');
        $this->devolucion = devolucionTable::getInstance()->getByIdDevolucion($idDevolucion);
    }

    public function executeEnvioCorreo(sfWebRequest $request)
    {
        $devolucion = devolucionTable::getInstance()->getByIdDevolucion( $request->getParameter('idDevolucion') );

        $form = new devolucionEnvioForm( array('provincia' => $devolucion->getIdProvincia() ) );

        $this->enviado = false; 
        if( $request->isMethod('post') )
        {
            $form->bind( $request->getParameter('devolucionEnvio') );
            if ( $form->isValid() )
            {
                $this->enviado = true;
                $result = $form->enviarAOCA($devolucion);
                $this->status = $result['status'];
                $this->responseEP = $result['response'];
            }
        }

        $this->form = $form;
        $this->devolucion = $devolucion;
    }

    public function executeMarcaRecibido(sfWebRequest $request)
    {
        $devolucion = devolucionTable::getInstance()->getByIdDevolucion( $request->getParameter('idDevolucion') );
        $devolucion->setFechaRecibido( new Doctrine_Expression('now()') );
        $devolucion->save();

        $this->redirect('@devolucion');
    }

    protected function executeBatchMarcaRecibido(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $devolucion = devolucionTable::getInstance()->updateFechaRecibido($ids);
    }

    public function executeProcesar(sfWebRequest $request)
    {
        $devolucion = devolucionTable::getInstance()->getByIdDevolucion( $request->getParameter('idDevolucion') );

        $form = new procesarDevolucionForm( array(), array('devolucion' => $devolucion ) );

        if( $request->isMethod('post') )
        {
            $form->bind( $request->getParameter('procesarDevolucion') );
            if ( $form->isValid() )
            {
                $result = $form->procesar();

                if ( $result )
                {
                    $this->mensaje = $this->getUser()->setFlash('devolucion_status_ok', 'La devolucion #' . $devolucion->getIdDevolucion() . ' se procesó correctamente.');
                }
                else
                {
                    $this->mensaje = $this->getUser()->setFlash('devolucion_status_ko', 'Hubo un error al procesar la devolucion #' . $devolucion->getIdDevolucion() . '. Por favor intentelo nuevamente.');
                }

                $this->redirect('@devolucion');
            }
        }

        $this->form = $form;
        $this->devolucion = $devolucion;
        $this->usuario = $devolucion->getUsuario();

    }

    public function executeDescargarExcel(sfWebRequest $request)
    {
        set_time_limit(0);

        $filters = $this->getFilters();
         
        $buscador       = ( isset( $filters["buscador"] ) ) ? $filters["buscador"] : '-';
        $marca          = ( isset( $filters["marca"] ) ) ? $filters["marca"] : '-';
        $idPedido       = ( isset( $filters["id_pedido"] ) ) ? $filters["id_pedido"] : '-';
        $fechaDesde     = ( isset( $filters["fecha"]["from"] ) ) ? $filters["fecha"]["from"] : '-';
        $fechaHasta     = ( isset( $filters["fecha"]["to"] ) ) ? $filters["fecha"]["to"] : '-';
        $estado         = ( isset( $filters["estado"] ) ) ? devolucionFormFilter::$choicesEstado[ $filters["estado"] ] : '-';
        $idBonificacion = ( isset( $filters["id_bonificacion"] ) ) ? $filters["id_bonificacion"] : '-';

        $motivo = '-';
        if ( isset($filters["motivo"]) )
        {
            $motivo         = devolucionMotivoTable::getInstance()->findOneByIdDevolucionMotivo( $filters["motivo"] );
            $motivo         = ( $motivo ) ? utf8_decode($motivo->getDenominacion()) : 'Todos';
        }


        $marca = '-';
        if ( isset($filters['marca']) )
        {
            $marca = marcaTable::getInstance()->findOneByIdMarca( $filters['marca'] );
            $marca = $marca->getNombre();
        }

        $devoluciones = $this->buildQuery()->execute();

        $dateNow = date('Y-m-d H:i:s');

        $headerCellStyle = array(
                'font' => array('bold' => true),
                'borders' => array(
                        'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN,
                                'color' => array('argb' => '000000'))));

        $phpExcel = new PHPExcel();

        $phpExcel->getProperties()->setCreator("DeluxeBuys");
        $activeSheet = $phpExcel->setActiveSheetIndex(0);

        $activeSheet->setCellValue('A1', 'Deluxebuys - Faltantes');
        $activeSheet->mergeCells('A1:D1');
        $activeSheet->mergeCells('A2:D2');

        $activeSheet->setCellValue('A3', 'Generada: ' . $dateNow);
        $activeSheet->mergeCells('A3:D3');

        $activeSheet->setCellValue('A4', 'Buscador: ' . $buscador);
        $activeSheet->mergeCells('A4:D4');
         
        $activeSheet->setCellValue('A5', 'Marca: ' . $marca);
        $activeSheet->mergeCells('A5:D5');
         
        $activeSheet->setCellValue('A6', 'Id Pedido: ' . $idPedido);
        $activeSheet->mergeCells('A6:D6');

        $activeSheet->setCellValue('A7', 'Desde: ' . $fechaDesde);
        $activeSheet->mergeCells('A7:D7');

        $activeSheet->setCellValue('A8', 'Hasta: ' . $fechaHasta);
        $activeSheet->mergeCells('A8:D8');

        $activeSheet->setCellValue('A9', 'Estado: ' . $estado);
        $activeSheet->mergeCells('A9:D9');
         
        $activeSheet->setCellValue('A10', 'Id Bonificación: ' . $idBonificacion);
        $activeSheet->mergeCells('A10:D10');
         
        $activeSheet->setCellValue('A11', 'Motivo: ' . $motivo);
        $activeSheet->mergeCells('A11:D11');
         

         
        $activeSheet->setCellValue('A15', 'Id Devolucion');
        $activeSheet->getStyle('A15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('A')->setAutosize(true);
        $activeSheet->getColumnDimension('A')->setWidth(5);

        $activeSheet->setCellValue('B15', 'Fecha');
        $activeSheet->getStyle('B15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('B')->setAutosize(true);
        $activeSheet->getColumnDimension('B')->setWidth(16);

        $activeSheet->setCellValue('C15', 'Usuario');
        $activeSheet->getStyle('C15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('C')->setAutosize(true);
        $activeSheet->getColumnDimension('C')->setWidth(25);

        $activeSheet->setCellValue('D15', 'Tipo envio');
        $activeSheet->getStyle('D15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('D')->setAutosize(true);
        $activeSheet->getColumnDimension('D')->setWidth(15);

        $activeSheet->setCellValue('E15', 'Tipo credito');
        $activeSheet->getStyle('E15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('E')->setAutosize(true);
        $activeSheet->getColumnDimension('E')->setWidth(15);
         
        $activeSheet->setCellValue('F15', 'Motivo');
        $activeSheet->getStyle('F15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('F')->setAutosize(true);
        $activeSheet->getColumnDimension('F')->setWidth(15);

        $activeSheet->setCellValue('G15', 'Estado');
        $activeSheet->getStyle('G15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('G')->setAutosize(true);
        $activeSheet->getColumnDimension('G')->setWidth(15);

        $activeSheet->setCellValue('H15', 'Id Bonif.');
        $activeSheet->getStyle('H15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('H')->setAutosize(true);
        $activeSheet->getColumnDimension('H')->setWidth(10);

        $activeSheet->setCellValue('I15', 'Codigo envio');
        $activeSheet->getStyle('I15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('I')->setAutosize(true);
        $activeSheet->getColumnDimension('I')->setWidth(30);

        $activeSheet->setCellValue('J15', 'Id Pedido');
        $activeSheet->getStyle('J15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('J')->setAutosize(true);
        $activeSheet->getColumnDimension('J')->setWidth(10);
         
        $activeSheet->setCellValue('K15', 'Codigo');
        $activeSheet->getStyle('K15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('K')->setAutosize(true);
        $activeSheet->getColumnDimension('K')->setWidth(15);
         
        $activeSheet->setCellValue('L15', 'Producto');
        $activeSheet->getStyle('L15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('L')->setAutosize(true);
        $activeSheet->getColumnDimension('L')->setWidth(40);
         
        $activeSheet->setCellValue('M15', 'Diversidad');
        $activeSheet->getStyle('M15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('M')->setAutosize(true);
        $activeSheet->getColumnDimension('M')->setWidth(17);
         
        $activeSheet->setCellValue('N15', 'Marca');
        $activeSheet->getStyle('N15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('N')->setAutosize(true);
        $activeSheet->getColumnDimension('N')->setWidth(15);

        $activeSheet->setCellValue('O15', 'Talle');
        $activeSheet->getStyle('O15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('O')->setAutosize(true);
        $activeSheet->getColumnDimension('O')->setWidth(10);
         
        $activeSheet->setCellValue('P15', 'Color');
        $activeSheet->getStyle('P15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('P')->setAutosize(true);
        $activeSheet->getColumnDimension('P')->setWidth(14);
         
        $activeSheet->setCellValue('Q15', 'Cantidad');
        $activeSheet->getStyle('Q15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('Q')->setAutosize(true);
        $activeSheet->getColumnDimension('Q')->setWidth(10);
         
        $activeSheet->setCellValue('R15', 'Costo');
        $activeSheet->getStyle('R15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('R')->setAutosize(true);
        $activeSheet->getColumnDimension('R')->setWidth(10);
        
        $activeSheet->setCellValue('S15', 'Precio');
        $activeSheet->getStyle('S15')->applyFromArray($headerCellStyle);
        $activeSheet->getColumnDimensionByColumn('S')->setAutosize(true);
        $activeSheet->getColumnDimension('S')->setWidth(10);
         

        $i = 16;
        foreach ($devoluciones as $devolucion)
        {
            $usuario = $devolucion->getUsuario();
             
            $tipoEnvio   = $devolucion->getTipoCredito() == 'DELUXE' ? 'Bonificación' : 'Mercado Pago';
            $tipoCredito = $devolucion->getTipoEnvio() == 'DELUXE' ? 'Propio' : 'Via OCA';
             
            if ($devolucion->getFechaEnvioOca() || $devolucion->getFechaRecibido() || $devolucion->getFechaCierre() )
            {
                if ( $devolucion->getFechaEnvioOca() ) $estado = 'Enviado a OCA';
                if ( $devolucion->getFechaRecibido() ) $estado = 'Recibido';
                if ( $devolucion->getFechaCierre() ) $estado = 'Trámite finalizado';
            }
            else
            {
                $estado = 'Sin estado';
            }

            $activeSheet->setCellValue('A' . $i, $devolucion->getIdDevolucion() );
            $activeSheet->setCellValue('B' . $i, $devolucion->getDateTimeObject('fecha')->format("d/m/Y H:i") );
            $activeSheet->setCellValue('C' . $i, $usuario->getNombre() . "\n" . $usuario->getApellido() . "\n" . $usuario->getEmail() );
            $activeSheet->setCellValue('D' . $i, $tipoEnvio );
            $activeSheet->setCellValue('E' . $i, $tipoCredito );
            $activeSheet->setCellValue('F' . $i, $devolucion->getDevolucionMotivo()->getDenominacion() );
            $activeSheet->setCellValue('G' . $i, $estado );
            $activeSheet->setCellValue('H' . $i, $devolucion->getIdBonificacion() );
            $activeSheet->setCellValue('I' . $i, $devolucion->getCodigoEnvio() );
             
             
            foreach($devolucion->getDevolucionProductoItem() as $devolucionProductoItem)
            {
                $pedidoProductoItem = $devolucionProductoItem->getPedidoProductoItem();
                $productoItem = $pedidoProductoItem->getProductoItem();
                $producto = $productoItem->getProducto();

                $activeSheet->setCellValue('J' . $i, $pedidoProductoItem->getIdPedido() );
                $activeSheet->setCellValue('K' . $i, $productoItem->getCodigo() );
                $activeSheet->setCellValue('L' . $i, $producto->getDenominacion() );
                $activeSheet->setCellValue('N' . $i, $pedidoProductoItem->getDiversidad() );
                $activeSheet->setCellValue('M' . $i, $producto->getMarca()->getNombre() );
                $activeSheet->setCellValue('O' . $i, $pedidoProductoItem->getProductoTalle()->getDenominacion() );
                $activeSheet->setCellValue('P' . $i, $pedidoProductoItem->getProductoColor()->getDenominacion() );
                $activeSheet->setCellValue('Q' . $i, $devolucionProductoItem->getCantidad() );
                $activeSheet->setCellValue('R' . $i, '$' . formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getCosto() ) );
                $activeSheet->setCellValue('S' . $i, '$' . formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() ) );
                $i++;
            }
             
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="devoluciones.xls"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
        $writer->save('php://output');

        exit;
    }

}
