<?php

/**
 * devolucion filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class devolucionFormFilter extends BasedevolucionFormFilter
{
	static public  $choicesEstado = array
	(
			'TODOS' => 'Todos',
			'SINESTADO' => 'Sin Estado',
			'RECIBIDO' => 'Recibido',
			'NORECIBIDO' => 'No Recibido',
	        'OCA' => 'Enviado al correo',
	        'OCA,NORECIBIDO' => 'Enviado al correo y No Recibido',
			'FINALIZADO' => 'Finalizado',
			'NOFINALIZADO' => 'No Finalizado',
	);
	
  public function configure()
  {
  	$this->setWidget('id_bonificacion',  new sfWidgetFormInputText());
  	$this->setWidget('id_localidad',  new sfWidgetFormInputText());

  	$this->setWidget('id_pedido',  new sfWidgetFormInputText());
  	$this->setValidator('id_pedido', new sfValidatorPass(array('required' => false)));
  	
  	$this->setWidget('buscador',  new sfWidgetFormInputText());
  	$this->setValidator('buscador', new sfValidatorPass(array('required' => false)));
  	
  	$this->setWidget( 'estado', new sfWidgetFormChoice( array( 'choices' => self::$choicesEstado ) ) );
  	$this->setValidator('estado', new sfValidatorPass(array('required' => false)));
  	
  	$this->setWidget('fecha',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false)));
  	
  	// Widget para Motivos
  	$choices = devolucionMotivoTable::getInstance()->findAll( 'HYDRATE_KEY_VALUE_PAIR' );
  	$otros = $choices['OTROS'];
  	unset($choices['OTROS']);
  	$choices = array_merge( array('TODOS' => 'Todos'), $choices, array('OTROS' => $otros) );  	
  	$this->setWidget( 'motivo', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
  	
  	$motivosPrefijados = $choices;
  	unset( $motivosPrefijados['Otros'], $motivosPrefijados['TODOS'] );
  	$this->motivosPrefijados = array_values( $motivosPrefijados );
  	$this->setValidator('motivo',new sfValidatorPass(array('required' => false)));
  	
  	// Widget para Marcas
  	$choices = array();
  	$marcas = marcaTable::getInstance()->listAll();
  	$choicesMarcas[''] = 'Todas';
  	foreach ($marcas as $marca)
  	{
  	    $choicesMarcas[$marca->getIdMarca()] = $marca->getNombre();
  	}
  	$this->setWidget( 'marca', new sfWidgetFormChoice( array( 'choices' => $choicesMarcas ) ) );
  	$this->setValidator( 'marca', new sfValidatorChoice( array( 'choices' => array_keys($choicesMarcas), 'required' => false ) ) );
  	
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
  }
  
  public function addIdEshopColumnQuery(Doctrine_Query $query, $field, $values) { }
  
  public function buildQuery(array $values)
  {
  
  	$values = $this->processValues($values);
  
  	$q = parent::doBuildQuery($values);
  	$rootAlias = $q->getRootAlias();
  
  
  	$q->innerJoin( $rootAlias . '.devolucionProductoItem dpi' );
  	$q->innerJoin( 'dpi.pedidoProductoItem ppi' );
  	$q->innerJoin( 'ppi.pedido pe' );
  	$q->innerJoin( 'pe.usuario u' );
  	$q->innerJoin( 'ppi.productoItem pi' );
  	$q->innerJoin( 'pi.producto pr' );
  
  	// Filtro de Buscador
  	if ( isset($values['buscador']) && $values['buscador'] )
  	{
  		$txt = $values['buscador'];
  		$q->addWhere('(' . $rootAlias . '.id_devolucion = ? OR pr.denominacion LIKE ? OR CONCAT(u.nombre," ",u.nombre) LIKE ? OR CONCAT(u.apellido," ",u.nombre) LIKE ?)', array($txt, "%$txt%", "%$txt%", "%$txt%"));
  	}
  	
  	// Filtro por id_pedido
  	if ( isset($values['id_pedido']) && $values['id_pedido'] )
  	{
  	    $q->addWhere('ppi.id_pedido = ?', $values['id_pedido']);
  	}
  
  	// Filtro de Marca
  	if ( isset($values['marca']) && $values['marca'] )
  	{
  		$q->addWhere('pr.id_marca = ?', $values['marca']);
  	}
  	
  	// Filtro de Estado
  	$wheresEstado = array
  	(
  			'SINESTADO' => "$rootAlias.fecha_envio_oca IS NULL AND $rootAlias.fecha_recibido IS NULL AND $rootAlias.fecha_cierre IS NULL",
  			'RECIBIDO' => "$rootAlias.fecha_recibido IS NOT NULL",
  			'NORECIBIDO' => "$rootAlias.fecha_recibido IS NULL",
  	        'OCA' => "$rootAlias.fecha_envio_oca IS NOT NULL",
  	        'OCA,NORECIBIDO' => "( ($rootAlias.fecha_envio_oca IS NOT NULL) AND ($rootAlias.fecha_recibido IS NULL) )",
  			'FINALIZADO' => "$rootAlias.fecha_cierre IS NOT NULL",
  			'NOFINALIZADO' => "$rootAlias.fecha_cierre IS NULL",
  	        'NOFINALIZADO' => "$rootAlias.fecha_cierre IS NULL",
  	);
  	
	// Filtro de Estado
  	if ( isset($values['estado']) && $values['estado'] != 'TODOS' )
  	{
  		$q->addWhere( $wheresEstado[$values['estado']] );
  	}
  	  	
  	// Filtro de Estado
  	if ( isset($values['motivo']) && $values['motivo'] != 'TODOS' )
  	{  	    
  	    if ( $values['motivo'] == 'Otros')
  	    {
  	        $q->whereNotIn($rootAlias . '.id_devolucion_motivo', $this->motivosPrefijados );
  	    }
  	    else
  	    {
  	        $q->addWhere( $rootAlias . '.id_devolucion_motivo = ?', $values['motivo']);
  	    }  	    
  	}
  	
  	// Filtro de eShop
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
  	  
  	$q->orderBy( $rootAlias . '.id_devolucion DESC');
  	
  	return $q;
  }
  
}
