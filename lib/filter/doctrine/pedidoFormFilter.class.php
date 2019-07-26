<?php

/**
 * pedido filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pedidoFormFilter extends BasepedidoFormFilter
{
  static protected  $choicesEstado = array
	  				(
	  					'NOELIMINADO' => 'No Eliminados',
						'TODOS' => 'Todos',
						'PAGADO' => 'Pagados',
						'PAGADO,NOENVIADO' => 'Pagados y no enviados',
						'PAGADO,INFOENV' => 'Pagados e informado a EnvioPack',
						'PAGADO,ENVIADO' => 'Pagados y enviados',
  						'PAGADO,ELIMINADO' => 'Pagados y eliminados',
						'NOPAGADO' => 'No pagados',
						'NOFACTURADO' => 'No facturados',
						'FACTURADO' => 'Facturados',
						'ELIMINADO' => 'Eliminados'
	  				);
    
  static protected  $choicesEstadoFacturacion = array
  (
          'NOFACTURADO' => 'No Facturados',
          'NOFACTURADO,ENVIADO' => 'No facturados y enviados',
          'NOFACTURADO,NOENVIADO' => 'No facturados y no enviados'
  );
  
  
  static protected  $choicesDiversidad = array
	  				(
						'' => 'Ambas',
						'STK_PER' => 'Solo Stock Permanente',
						'MIX' => 'Mixta'
	  				);
  
  protected $filterByEmail;


  public function configure()
  {
  	$this->setWidgets(array());
  	
  	// Widget para buscador
  	$this->setWidget( 'buscador', new sfWidgetFormInput() );

    // Widget para fecha pago
	$this->setWidget('fecha_pago',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDateTime(), 'to_date' => new pmWidgetFormDateTime(), 'with_empty' => false)));
	
  	// Widget para Estado
  	$this->setWidget( 'estado', new sfWidgetFormChoice( array( 'choices' => self::$choicesEstado ) ) );
  	
  	// Widget para Estado en Facturacion
  	$this->setWidget( 'estado_facturacion', new sfWidgetFormChoice( array( 'choices' => self::$choicesEstadoFacturacion ) ) );
  	
  	$this->widgetSchema->setNameFormat('pedido_filters[%s]');

  	// Widget para Diversidad
  	$this->setWidget( 'diversidad', new sfWidgetFormChoice( array( 'choices' => self::$choicesDiversidad ) ) );
  	
  	// Widget para Campañas
  	$choices = array();
  	$campanas = campanaTable::getInstance()->listAll();
  	$choicesCampanas[''] = 'Todas';
  	foreach ($campanas as $campana)
  	{
  		$desde = $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y");
  		$hasta = $campana->getDateTimeObject('fecha_fin')->format("d/m/Y");
  		$choicesCampanas[$campana->getIdCampana()] = $campana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')';
  	}
  	$this->setWidget( 'campana', new sfWidgetFormChoice( array( 'choices' => $choicesCampanas ) ) );

  	// Widget para Marcas
  	$this->setWidget( 'marca', new sfWidgetFormChoice( array( 'choices' => array(), 'multiple' => true ) ) );
  	
  	// Widget para idRemito
  	$this->setWidget( 'remito', new sfWidgetFormInput() );
  	
  	// Widget para Outlet
  	$this->setWidget( "tiene_outlet", new sfWidgetFormSelect( array('choices' => array( '' => 'Ambos', '1' => 'Sí', '0' => 'No' ))) );
  	
  	// Widget para Forma de Pago
  	$this->setWidget( 'id_forma_pago', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('formaPago'), 'add_empty' => true) ) );

  	// Widget para Tipo de Envio
  	$this->setWidget( 'envio_tipo', new sfWidgetFormSelect( array('choices' => array( '' => 'Todos', 'DOM' => 'Domicilio', 'SUC' => 'Sucursal'))) );

  	// Widget para Stock de Refuerzo
  	$choicesRefuerzo = array(
  		'' => 'Todos',
  		'TIENE-REFUERZO' => 'Con Stock de Refuerzo',
  		'NO-TIENE-REFUERZO' => 'Sin Stock de Refuerzo',
	);
  	$this->setWidget( 'refuerzo', new sfWidgetFormChoice( array( 'choices' => $choicesRefuerzo ) ) );

  	
  	
    $this->setValidators(array(
      'fecha_pago'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d H:i:s')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d H:i:s')))),
      'buscador'            => new sfValidatorString(array('required' => false)),
      'estado'	            => new sfValidatorChoice( array( 'choices' => array_keys(self::$choicesEstado), 'required' => false ) ),
      'estado_facturacion'	=> new sfValidatorChoice( array( 'choices' => array_keys(self::$choicesEstadoFacturacion), 'required' => false ) ),
      'diversidad'          => new sfValidatorChoice( array( 'choices' => array_keys(self::$choicesDiversidad), 'required' => false ) ),
      'campana'	            => new sfValidatorChoice( array( 'choices' => array_keys($choicesCampanas), 'required' => false ) ),
      'marca'	            => new sfValidatorPass(),
      'remito'              => new sfValidatorString(array('required' => false)),
      'tiene_outlet'        => new sfValidatorString(array('required' => false)),
      'id_forma_pago'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('formaPago'), 'column' => 'id_forma_pago')),
      'envio_tipo'	        => new sfValidatorPass(),
      'refuerzo'	        => new sfValidatorPass()
    ));
     
    // Filtro de intervencion manual
    $countIntervencionManual = pedidoTable::getInstance()->countIntervencionManual();
	$this->setWidget('intervencionManual', new sfWidgetFormInputCheckbox( ) );
	$pedidosPlural = ($countIntervencionManual > 1)? 's' : '';
	$requierePlural = ($countIntervencionManual > 1)? 'n' : '';
	$this->getWidget('intervencionManual')->setLabel("<img src='/backend/images/warning.png' /> Hay $countIntervencionManual pedido$pedidosPlural que requiere$requierePlural intervención manual");
	$this->setValidator( 'intervencionManual', new sfValidatorString( array('required' => false) ) );
	
	// Widget para eShops
	$choices = array();
	$eshops = eshopTable::getInstance()->listAll();
	$choices[''] = 'Todos';
	$choices[ eshop::ESHOP_DELUXE ] = 'Deluxe Buys';
	foreach ($eshops as $eshop)
	{
	    $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
	}
	$this->setWidget( 'id_eshop', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	$this->setValidator( 'id_eshop', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ) );
	
    // Filtro de email via URL
	$this->filterByEmail = sfContext::getInstance()->getRequest()->getParameter('email', false);
	if ( $this->filterByEmail )
	{
	    $this->getWidget( 'buscador' )->setDefault( $this->filterByEmail );
	    $this->getWidget( 'estado' )->setDefault( 'TODOS' );
	}

	// Widget para Mostrar pedidos de única marca
	$this->setWidget('unica_marca', new sfWidgetFormInputCheckbox( ) );
	$this->getWidget('unica_marca')->setLabel('Mostrar solo pedidos con todos los productos de una misma marca');
	$this->setValidator( 'unica_marca', new sfValidatorBoolean( array('required' => false) ) );

	// Widget para Mostrar solo los pedidos de campaña que se pueden despachar
	$this->setWidget('solo_despachables', new sfWidgetFormInputCheckbox( ) );
	$this->getWidget('solo_despachables')->setLabel('Mostrar solo los pedidos de campaña que se pueden despachar');
	$this->setValidator( 'solo_despachables', new sfValidatorBoolean( array('required' => false) ) );
  }
  
  public function addIdEshopColumnQuery(Doctrine_Query $query, $field, $values) { }

  public function buildQuery(array $values)
  {     
  	$values = $this->processValues($values);
  	  	
  	// Filtro de email via URL
  	if ( $this->filterByEmail )
    {
      	$values['buscador'] = $this->filterByEmail;
      	$values['estado'] = 'TODOS';
    }
  	

  	$q = parent::doBuildQuery($values);
    $rootAlias = $q->getRootAlias();
    $q->addSelect( $rootAlias . ".*, usu.*, fp.*");

    $q->addSelect( '(SELECT COUNT(*) FROM pedidoProductoItem s2_ppi WHERE s2_ppi.id_pedido = ' . $rootAlias . '.id_pedido AND s2_ppi.origen = \'' . producto::ORIGEN_OUTLET . '\') as tiene_outlet_calculado');

    $q->addSelect( '(SELECT COUNT(*) FROM pedidoProductoItem s3_ppi INNER JOIN s3_ppi.pedidoProductoItemCampana s3_ppic ON s3_ppi.id_pedido_producto_item = s3_ppic.id_pedido_producto_item WHERE s3_ppi.id_pedido = ' . $rootAlias . '.id_pedido) as tiene_ofertas_calculado');

    $q->addSelect( '(SELECT group_concat(distinct(s4_c.denominacion) separator \', \') FROM pedidoProductoItem s4_ppi INNER JOIN s4_ppi.pedidoProductoItemCampana s4_ppic ON s4_ppi.id_pedido_producto_item = s4_ppic.id_pedido_producto_item INNER JOIN s4_ppic.campana s4_c ON s4_c.id_campana = s4_ppic.id_campana WHERE s4_ppi.id_pedido = ' . $rootAlias . '.id_pedido) as campana');
   
	$q->innerJoin( $rootAlias . '.usuario usu' );
	$q->leftJoin( $rootAlias . '.formaPago fp' );
		
    $q->orderBy( $rootAlias . '.id_pedido DESC');
    

  	$wheresEstado = array
  			(
				'PAGADO' => "$rootAlias.fecha_pago IS NOT NULL AND $rootAlias.fecha_baja IS NULL",
				'PAGADO,INFOENV' => "$rootAlias.fecha_pago IS NOT NULL AND $rootAlias.fecha_envio IS NULL AND $rootAlias.fecha_baja IS NULL AND $rootAlias.envio_id_pedido_envio_pack IS NOT NULL",
  				'PAGADO,ENVIADO' => "$rootAlias.fecha_pago IS NOT NULL AND $rootAlias.fecha_envio IS NOT NULL AND $rootAlias.fecha_baja IS NULL",
  				'PAGADO,NOENVIADO' => "$rootAlias.fecha_pago IS NOT NULL AND $rootAlias.fecha_baja IS NULL AND $rootAlias.envio_id_pedido_envio_pack IS NULL AND $rootAlias.fecha_envio IS NULL",
  				'PAGADO,ELIMINADO' => "$rootAlias.fecha_pago IS NOT NULL AND $rootAlias.fecha_baja IS NOT NULL",
				'NOPAGADO' => "$rootAlias.fecha_pago IS NULL AND $rootAlias.fecha_baja IS NULL",
  				'NOFACTURADO' => "$rootAlias.fecha_facturacion IS NULL AND $rootAlias.fecha_pago IS NOT NULL AND $rootAlias.fecha_baja IS NULL",
  				'FACTURADO' => "$rootAlias.fecha_facturacion IS NOT NULL",
  				'ELIMINADO' => "$rootAlias.fecha_baja IS NOT NULL",
  				'NOELIMINADO' => "$rootAlias.fecha_baja IS NULL"
  			);
  	
  	$wheresEstadoFacturacion = array
  	(
  	        'NOFACTURADO' => "$rootAlias.fecha_facturacion IS NULL AND $rootAlias.fecha_pago IS NOT NULL AND $rootAlias.fecha_baja IS NULL",
  	        'NOFACTURADO,ENVIADO' => "$rootAlias.fecha_facturacion IS NULL AND $rootAlias.fecha_pago IS NOT NULL AND $rootAlias.fecha_baja IS NULL AND $rootAlias.fecha_envio IS NOT NULL",
  	        'NOFACTURADO,NOENVIADO' => "$rootAlias.fecha_facturacion IS NULL AND $rootAlias.fecha_pago IS NOT NULL AND $rootAlias.fecha_baja IS NULL AND $rootAlias.fecha_envio IS NULL"
  	);
  	
  	// Filtro de Estado
  	if ( isset($values['estado']) && $values['estado'] != 'TODOS' )
	{
		$q->addWhere( $wheresEstado[$values['estado']] );
	}
	elseif ( !isset($values['estado']) )
	{
		$q->addWhere( $wheresEstado['NOELIMINADO'] );
	}
	
	// Filtro de Estado Facturacion
	if ( stripos($_SERVER['REQUEST_URI'], 'facturacion') !== false )
	{
    	if ( isset($values['estado_facturacion']) )
    	{
    	    $q->addWhere( $wheresEstadoFacturacion[$values['estado_facturacion']] );
    	}
    	else
    	{
    	    $q->addWhere( $wheresEstadoFacturacion['NOFACTURADO'] );
    	}
	}
	
	
	// Filtro de Buscador
	if ( isset($values['buscador']) && $values['buscador'] )
	{
		$txt = $values['buscador'];

		$subFilters = array();
		$subFilters[] = array( 'field' => $rootAlias . '.id_pedido', 'operator' => '=');
		$subFilters[] = array( 'field' => 'usu.nombre', 'operator' => 'LIKE');
		$subFilters[] = array( 'field' => 'usu.apellido', 'operator' => 'LIKE');
		$subFilters[] = array( 'field' => 'usu.email', 'operator' => 'LIKE');
		$subFilters[] = array( 'field' => $rootAlias . '.nombre', 'operator' => 'LIKE');
		$subFilters[] = array( 'field' => $rootAlias . '.apellido', 'operator' => 'LIKE');
		$subFilters[] = array( 'field' => $rootAlias . '.email', 'operator' => 'LIKE');
		$subFilters[] = array( 'field' => $rootAlias . '.envio_destinatario', 'operator' => 'LIKE');
		$subFilters[] = array( 'field' => $rootAlias . '.envio_calle', 'operator' => 'LIKE');

		$wheres = array();
		foreach ($subFilters as $subFilter)
		{

			$wheres[] = $subFilter['field'] . ' ' . $subFilter['operator'] . ' ?';
		}

		$q->addWhere( implode(' OR ', $wheres), array($txt, "%$txt%", "%$txt%", "%$txt%", "%$txt%", "%$txt%", "%$txt%", "%$txt%", "%$txt%") );
	}

	// Filtro de Diversidad
	if ( isset($values['diversidad']) && $values['diversidad'] )
	{
		$subQ = $q->createSubquery()
		   ->from('pedidoProductoItem d_ppi')
		   ->innerJoin( 'd_ppi.pedidoProductoItemCampana d_ppic' )
		   ->addWhere('d_ppi.id_pedido = ' . $rootAlias . '.id_pedido');

		if ($values['diversidad'] == 'STK_PER')
		{
			$q->addWhere("NOT EXISTS (". $subQ->getDql() .")");
		}
		else
		{
			$q->addWhere("EXISTS (". $subQ->getDql() .")");
		}
	}


	// Filtro de Refuerzo
    if ( isset($values['refuerzo']) && $values['refuerzo'] )
	{
    	$cantidadRefuerzo = '(SELECT COUNT(*) FROM pedidoProductoItem s6_ppi INNER JOIN s6_ppi.stock s6_s ON s6_ppi.id_pedido_producto_item = s6_s.id_pedido_producto_item WHERE s6_ppi.id_pedido = ' . $rootAlias . '.id_pedido AND s6_s.id_stock_tipo = ' . stockTipo::SISTEMA_VENTA . ' and s6_s.origen = "' . producto::ORIGEN_REFUERZO . '")';

  		if ( $values['refuerzo'] == 'NO-TIENE-REFUERZO' ) {
  			$q->addWhere($cantidadRefuerzo . ' = 0');	
  		} else if ( $values['refuerzo'] == 'TIENE-REFUERZO' ) {
  			$q->addWhere($cantidadRefuerzo . ' > 0');	
  		}
	}

	// Filtro de Campaña
    if ( isset($values['campana']) && $values['campana'] )
	{
		$q->innerJoin( $rootAlias . '.pedidoProductoItem c_ppi' )
		  ->innerJoin( 'c_ppi.pedidoProductoItemCampana c_ppic' )
		  ->addWhere('c_ppic.id_campana = ?', $values['campana']);
	}


   	// Filtro de Marca
    if ( isset($values['marca']) && $values['marca'] && $values['marca'][0] )
	{
		$idsMarca = $values['marca'];

		$q->innerJoin( $rootAlias . '.pedidoProductoItem m_ppi' );
		$q->innerJoin( 'm_ppi.productoItem m_pi' );
		$q->innerJoin( 'm_pi.producto m_p' );
		$q->andWhereIn( 'm_p.id_marca', $idsMarca );
	}
	
	// Filtro de Única Marca
	if ( isset($values['unica_marca']) && $values['unica_marca'] )
	{
	    $q->addWhere( '(SELECT COUNT( DISTINCT s5_p.id_marca ) FROM pedidoProductoItem s7_ppi INNER JOIN s7_ppi.productoItem s7_pi ON s7_ppi.id_producto_item = s7_pi.id_producto_item INNER JOIN s7_pi.producto s7_p ON s7_pi.id_producto = s7_p.id_producto WHERE s7_ppi.id_pedido = ' . $rootAlias . '.id_pedido) = 1');
	}

	// Filtro de Despachables de campaña
	if ( isset($values['solo_despachables'] ) && $values['solo_despachables'] )
	{
		$idsPedidos = recepcionMercaderiaCampanaTable::getInstance()->getIdsPedidosEnviables( $values['campana'] );
		
		if ( count( $idsPedidos ) ) {
			$q->andWhereIn( $rootAlias . '.id_pedido', $idsPedidos );	
		} else {
			$q->addWhere('false');
		}
	    
	}
		
	// Filtro de IntervencionManual
    if ( isset($values['intervencionManual'] ) && $values['intervencionManual'] )
	{
		$q->addWhere( $rootAlias . '.requiere_intervencion_manual != 0');
	}
	
  	// Filtro de Id Remito
	if ( isset($values['remito']) && $values['remito'] )
	{
		$q->innerJoin( $rootAlias . '.remitoPedido r_rp' )
		  ->addWhere( 'r_rp.id_remito = ?', $values['remito'] );
	}

  	// Filtro de Tipo de Envio
	if ( isset($values['envio_tipo']) && $values['envio_tipo'] )
	{
		$q->addWhere( $rootAlias . '.envio_tipo = ?', $values['envio_tipo'] );
	}
		
	// Filtro de Id Remito
	if ( isset($values['tiene_outlet']) && $values['tiene_outlet'] != '' )
	{
		$q->innerJoin( $rootAlias . '.pedidoProductoItem eo_ppi' );
		
		if ( $values['tiene_outlet'] )
		{
		    $q->addWhere('eo_ppi.origen = ?', producto::ORIGEN_OUTLET);
		}
		else
		{
		    $q->addWhere('eo_ppi.origen <> ?', producto::ORIGEN_OUTLET);
		}	
	}
	
	if ( isset($values['id_eshop']) && $values['id_eshop'] )
	{
	    if ( $values['id_eshop'] == eshop::ESHOP_DELUXE )
	    {
	        $q->addWhere( $rootAlias . '.id_eshop IS NULL');
	    }
	    else
	    {
	        $q->addWhere( $rootAlias . '.id_eshop = ?', $values['id_eshop']);
	    }
	}

	if ( $this->isArrayEmpty($values) ) $q->addWhere('false');
	
    return $q;
  }

  public static function getNombreEstado($key)
  {
  	return self::$choicesEstado[$key];
  }

  public static function getNombreDiversidad($key)
  {
  	return self::$choicesDiversidad[$key];
  }
  
  public function isArrayEmpty($InputVariable)
  {
      $Result = true;
  
      if (is_array($InputVariable) && count($InputVariable) > 0)
      {
          foreach ($InputVariable as $Value)
          {
              $Result = $Result && $this->isArrayEmpty($Value);
          }
      }
      else
      {
          $Result = empty($InputVariable);
      }
  
      return $Result;
  }
  

}
