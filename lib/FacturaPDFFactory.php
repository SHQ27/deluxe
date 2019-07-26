<?php

class FacturaPDFFactory
{
    static protected $instance;
    CONST ORIGINAL = 'ORIGINAL';
    CONST DUPLICADO = 'ORIGINAL';

    protected $configWS;
    protected $configComprobante;
    protected $dirSave;

    protected function __construct()
    {
        $this->configWS = sfConfig::get('app_afip_ws');
        $this->configComprobante = sfConfig::get('app_afip_comprobante');
        $this->dirSave = str_replace('%env%', $this->configWS['env'], $this->configComprobante['dir_save_factura']);
    }

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new FacturaPDFFactory();
        }

        return self::$instance;
    }

    public function create($factura, $copia = self::ORIGINAL)
    {
        $pedido = $factura->getPedido();

        // create new PDF document
        $pdf = new ComprobanteAfipPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('DeluxeBuys');

        //set margins
        $pdf->SetMargins(15, 5, 15);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        $lang['a_meta_charset'] = 'UTF-8';
        $lang['a_meta_dir'] = 'ltr';
        $lang['a_meta_language'] = 'es';
        $lang['w_page'] = 'página';
        $pdf->setLanguageArray($lang);

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10);

        // add a page
        $pdf->AddPage();


        // Armo el Header de la Factura
        $headerHtml =
        '
        <style>

        h2 { font-size: 60px; }

        .align-center { text-align: center; }

        table
        {
        width: 100%;
    }

    .height3 { height: 3px; line-height: 3px; font-size: 3px; }
    .height5 { height: 5px; line-height: 5px; font-size: 5px; }
    .height10 { height: 10px; }
    .height25 { height: 25px; }
    .height31 { height: 31px; }

    .header .copia
    {
    text-align: center;
    font-weight: bold;
    font-size: 42px;
    width: 100%;
    }

    .header td
    {
    width: 50%;
    border: solid 1px #000000;
    font-size: 31px;
    }

    .boxLeftSpace
    {
    width: 2%;
    }

    .boxLeftWidth
    {
    width: 98%;
    }

    .boxRightSpace
    {
    width: 16%;
    }

    .boxRightWidth
    {
    width: 84%;
    }

    .boxRightHalfWidth
    {
    width: 42%;
    }

    .customerData
    {
    border: solid 1px #000000;
    }

    .customerData td
    {
    font-size: 31px;
    line-height: 7px;
    }

    .customerData td.boxLeft
    {
    width: 58%;
    }

    .customerData td.boxRight
    {
    width: 42%;
    }

    .productData tr th
    {
    background-color: rgb(204, 204 ,204);
    border: solid 1px #000000;
    color: #000000;
    font-size: 25px;
    line-height: 6px;
    font-weight: bold;
    }

    .productData tr td
    {
    background-color: rgb(255, 255, 255);
    border: none;
    color: #000000;
    font-size: 23px;
    line-height: 5px;
    }

    </style>

    <table class="header">
    <tr>
    <td class="copia" colspan="4">
    <table>
    <tr><td class="height3"></td></tr>
    <tr><td>' . $copia . '</td></tr>
    <tr><td class="height3"></td></tr>
    </table>
    </td>
    </tr>
    <tr>
    <td>
    <table>
    <tr>
    <td class="boxLeftSpace" rowspan="6"></td>
    <td class="boxLeftWidth height10"></td>
    </tr>
    <tr><td class="boxLeftWidth align-center"><h2>' . $this->configComprobante['razon_social'] . '</h2></td></tr>
    <tr><td class="boxLeftWidth height10"></td></tr>

    <tr><td class="boxLeftWidth height31"><strong>Razón Social:</strong> ' . $this->configComprobante['razon_social'] . '</td></tr>
    <tr><td class="boxLeftWidth height31"><strong>Domicilio Comercial:</strong> ' . $this->configComprobante['domicilio_comercial'] . '</td></tr>
    <tr><td class="boxLeftWidth height31"><strong>Condición frente al IVA:</strong> ' . $this->configComprobante['condicion_iva'] . '</td></tr>
    </table>
    </td>
    <td>
    <table>
    <tr>
    <td class="boxRightSpace" rowspan="8"></td>
    <td class="boxRightWidth" colspan="2" class="height10"></td>
    </tr>
    <tr><td class="boxRightWidth" colspan="2"><h2>FACTURA</h2></td></tr>
    <tr><td class="boxRightWidth height10" colspan="2"></td></tr>

    <tr>
    <td class="boxRightHalfWidth height10"><strong>Punto de Venta: ' . sprintf('%04d', $this->configWS['punto_de_venta'] ) . '</strong></td>
    <td class="boxRightHalfWidth  height10"><strong>Comp. Nro: ' . sprintf('%07d', $factura->getComprobante() ) . '</strong></td>
    </tr>
    <tr><td class="boxRightWidth height25" colspan="2"><strong>Fecha de Emisión: ' . $factura->getFechaEmision() . '</strong></td></tr>
    <tr><td class="boxRightWidth height10" colspan="2"><strong>CUIT:</strong> ' . $this->configWS['cuit'] . '</td></tr>
    <tr><td class="boxRightWidth height10" colspan="2"><strong>Ingresos Brutos:</strong> ' . $this->configComprobante['ingresos_brutos'] . '</td></tr>
    <tr><td class="boxRightWidth height10" colspan="2"><strong>Fecha de Inicio de Actividades:</strong> ' . $this->configComprobante['inicio_actividad'] . '</td></tr>
    </table>
    </td>
    </tr>
    </table>

    <table><tr><td class="height3"></td></tr></table>

    <table class="customerData">
    <tr>
    <td class="boxLeft"><strong>Apellido y Nombre: </strong> ' . $pedido->getNombreCompleto() . '</td>
    ';

        if ( $pedido->getDocumento() )
        {
            $headerHtml .=
            '
            <td class="boxRight">&nbsp;<strong>' . $pedido->getTipoDocumento() . ':</strong> ' . $pedido->getDocumento() . '</td>
            ';
        }
        else
        {
            $headerHtml .=
            '
            <td class="boxRight"></td>
            ';
        }

        $remitoPedido = remitoPedidoTable::getInstance()->getByIdPedido( $pedido->getIdPedido() );
        $idRemito = ($remitoPedido) ? $remitoPedido->getIdFormateado() : $pedido->getIdPedido();

        $headerHtml .=
        '
        </tr>
        <tr>
        <td class="boxLeft"><strong>Condicion frente al IVA:</strong> Consumidor Final</td>
        <td class="boxRight">&nbsp;<strong>Nro. Remito:</strong> ' . $idRemito . '</td>
        </tr>
        </table>

        <table><tr><td class="height5"></td></tr></table>

        <table class="productData">
        <tr>
        <th width="120">Codigo</th>
        <th width="85">Marca</th>
        <th width="208">Producto</th>
        <th width="70">Talle</th>
        <th width="70">Color</th>
        <th width="30">Cant.</th>
        <th width="55">Subtotal</th>
        </tr>
        ';


        $pedidoProductoItems = $pedido->getPedidoProductoItem();

        $bonificacion = $pedido->getMontoDescuento() +  $pedido->getMontoBonificacion();

        $porcBonif = ( $bonificacion > 0 ) ? $bonificacion/$pedido->getMontoProductos() : 0;

        $sumImporteBonif = 0;
        $sumSubTotal = 0;
        foreach ($pedidoProductoItems as $pedidoProductoItem)
        {
            $productoItem = $pedidoProductoItem->getProductoItem();
            $producto     = $productoItem->getProducto();

            $headerHtml .=
            '
            <tr>
            <td>' . $productoItem->getCodigo() . '</td>
            <td>' . $producto->getMarca()->getNombre() . '</td>
            <td>' . $producto->getDenominacion() . '</td>
            <td>' . $pedidoProductoItem->getProductoTalle()->getDenominacion() . '</td>
            <td>' . $pedidoProductoItem->getProductoColor()->getDenominacion() . '</td>
            <td>' . $pedidoProductoItem->getCantidad() . '</td>
            <td>' . formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() ) . '</td>
            </tr>
            ';
        }

        $headerHtml .=
        '
        </table>
        ';

        $pdf->writeHTML($headerHtml, true, false, true, false, '');


        $footerHtml =
        '
        <style>
        .boxTotals
        {
        border: 1px solid black;
    }

    .boxTotals tr td
    {
    font-size: 31px;
    font-weight: bold;
    line-height: 6px;
    text-align: right;
    }

    .boxTotals .space { width: 50%; }
    .boxTotals .label { width: 35%; }
    .boxTotals .value { width: 15%; }

    .boxTotals tr td.leyenda
    {
    font-size: 20px;
    font-weight: bold;
    line-height: 10px;
    text-align: left;
    }

    .footer tr td
    {
    font-size: 30px;
    font-weight: bold;
    line-height: 6px;
    text-align: right;
    }

    .footer tr td.align-left
    {
    text-align: left;
    }

    .footer tr td.leyenda
    {
    font-size: 15px;
    font-weight: bold;
    line-height: 15px;
    text-align: left;
    }

    .footer tr td.space
    {
    line-height: 5px;
    height: 5px;
    font-size: 5px;
    }

    </style>

    <table class="boxTotals">
    <tr>
    <td class="space leyenda" rowspan="5">Flete/envio  a cargo del cliente';

    if ( $pedido->getMontoBonificacion() > 0 )
    {
        $footerHtml .= '<br/>En esta factura se utilizo una bonificacion por $' . formatHelper::getInstance()->decimalNumber( $pedido->getMontoBonificacion() ) . ' como parte de pago.';
    }  
    
    $footerHtml .= '
    </td>
    <td class="label">Costo de Envío: $</td>
    <td class="value">' . formatHelper::getInstance()->decimalNumber( $pedido->getMontoEnvio() ) . '</td>
    </tr>
    <tr>
    <td class="label">Descuentos: $</td>
    <td class="value">(' . formatHelper::getInstance()->decimalNumber( $pedido->getMontoDescuento() ) . ')</td>
    </tr>
    <tr>
    <td class="label">Subtotal: $</td>
    <td class="value">' . formatHelper::getInstance()->decimalNumber( $pedido->getMontoFacturacion() ) . '</td>
    </tr>
    <tr>
    <td class="label">Importe Otros Tributos: $</td>
    <td class="value">0,00</td>
    </tr>
    <tr>
    <td class="label">Importe Total: $ </td>
    <td class="value">' . formatHelper::getInstance()->decimalNumber( $pedido->getMontoFacturacion() ) . '</td>
    </tr>
    </table>

    <table class="footer">
    <tr>
    <td class="space" colspan="5"></td>
    </tr>
    <tr>
    <td width="140"></td>
    <td width="175" class="align-left"><em>Comprobante Autorizado</em></td>
    <td width="88">Pág. 1/1</td>
    <td width="133">CAE N°:</td>
    <td width="95">' . $factura->getCAE() . '</td>
    </tr>
    <tr>
    <td width="140"></td>
    <td class="leyenda" width="263" colspan="2">Esta Administracion Federal no se responsabiliza por los datos ingresados en el datalle de la operación</td>
    <td width="133">Fecha de Vto. de CAE:</td>
    <td width="95">' . $factura->getFormatedCAEVencimiento() . '</td>
    </tr>
    </table>
    ';

        // Agrego los totales
        $pdf->writeHTMLCell(182, 30, 14, 230, $footerHtml, 0, 0, false );

        $pdf->Image( sfConfig::get('sf_web_dir') . '/images/logo_afip.png', 16, 258, 35, 12, 'PNG');


        // Agrego el tipo de factura
        $pdf->SetFillColor(255, 255, 255);
        $pdf->writeHTMLCell(16, 12, 97, 12, '<style>.tipoComprobante { background: #FFFFFF; font-size: 80px; text-align: center; font-weight: bold; } .codigotipoComprobante { background: #FFFFFF; text-align: center; font-size: 30px; font-weight: bold;  }</style><table><tr><td class="tipoComprobante">B</td></tr><tr><td class="codigotipoComprobante">COD. 06</td></tr></table>', 1, 0, true );

        $filepath = sfConfig::get('sf_root_dir') . $this->dirSave . 'factura_B_' . $copia . '_' . $factura->getComprobante() . '.pdf';
        $pdf->Output($filepath , 'F');
        chmod( $filepath , 0777);
    }


    public function getDownloadPath( $factura, $copia = self::ORIGINAL )
    {
        $filepath = sfConfig::get('sf_root_dir') . $this->dirSave . 'factura_B_' . $copia . '_' . $factura->getComprobante() . '.pdf';

        $existFile = file_exists($filepath);
        if ( !$existFile ) $this->create($factura, $copia );

        return $filepath;
    }

    public function getDownloadName( $factura, $copia = self::ORIGINAL )
    {
        return 'factura_B_' . $copia . '_' . $factura->getComprobante() . '.pdf';
    }

}
