<?php

/**
 * usuario filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuarioFormFilter extends BaseusuarioFormFilter
{
  public function configure()
  {
  	$this->setWidgets(array());
  	
  	$this->widgetSchema->setNameFormat('usuario_filters[%s]');

  	// Nombre
  	$this->setWidget( 'nombre', new sfWidgetFormFilterInput(array('with_empty' => false) ) );
  	
  	// Apellido
  	$this->setWidget( 'apellido', new sfWidgetFormFilterInput(array('with_empty' => false) ) );
  	
  	// Email
  	$this->setWidget( 'email', new sfWidgetFormFilterInput() );
  	
  	// Compras
  	$this->setWidget( 'compras_desde', new sfWidgetFormInput() );
  	$this->setWidget( 'compras_hasta', new sfWidgetFormInput() );
  	
  	// Sexo
  	$this->setWidget( 'sexo', new sfWidgetFormSelect( array( 'choices' => array('' => 'Indistinto','h' => 'Hombre', 'm' => 'Mujer') ) ) );
  	
  	// Edad
  	$this->setWidget( 'edad_desde', new sfWidgetFormInput() );
  	$this->setWidget( 'edad_hasta', new sfWidgetFormInput() );
  	
  	// Provincia
  	$provincias = provinciaTable::getInstance()->listAll();
  	$choicesProvincia = array();
  	$choicesProvincia[ '' ] = 'Seleccionar';
  	foreach ($provincias as $provincia)
  	{
  		$choicesProvincia[ $provincia->getIdProvincia() ] = $provincia->getNombre();
  	}
  	$this->setWidget( 'provincia', new sfWidgetFormSelect( array( 'choices' => $choicesProvincia) ) );	
  	
  	// Fecha Alta
  	$this->setWidget('fecha_alta',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false)));
  	
  	// Source
  	$this->setWidget( 'source', new sfWidgetFormInput() );
  	
  	// Validadores
  	$this->setValidators(array(
  			'nombre'             => new sfValidatorPass(array('required' => false)),
  			'apellido'           => new sfValidatorPass(array('required' => false)),
  			'email'   		     => new sfValidatorPass(array('required' => false)),
  			'compras_desde'      => new sfValidatorPass(array('required' => false)),
  			'compras_hasta'      => new sfValidatorPass(array('required' => false)),
  			'sexo'               => new sfValidatorPass(array('required' => false)),
  			'edad_desde'         => new sfValidatorPass(array('required' => false)),
  			'edad_hasta'         => new sfValidatorPass(array('required' => false)),
  			'provincia'          => new sfValidatorPass(array('required' => false)),
            'fecha_alta'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
  	        'source'   		     => new sfValidatorPass(array('required' => false))
  	));
  	
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
  	$r = $q->getRootAlias();
  	$q->addSelect( $r . '.id_usuario, ' . $r . '.nombre, ' . $r . '.apellido, ' . $r . '.email, ' . $r . '.telefono, ' . $r . '.activo, ' . $r . '.sexo, e.denominacion as nombre_eshop' );

    $q->addSelect( '(SELECT count(*) FROM pedido p1 WHERE (p1.id_usuario = ' . $r . '.id_usuario) AND p1.fecha_pago IS NOT NULL AND p1.fecha_baja IS NULL) as compras');

    $q->addSelect( '(SELECT sum(monto_total) FROM pedido p2 WHERE (p2.id_usuario = ' . $r . '.id_usuario) AND p2.fecha_pago IS NOT NULL AND p2.fecha_baja IS NULL) as monto_compras');

  	$q->leftJoin( $r . '.eshop e');  	
  	  	
  	if ( isset($values["provincia"]) && $values["provincia"] )
  	{
  		$q->innerJoin( $r . '.direccionesEnvios de' );
  		$q->addWhere('de.id_provincia = ?', $values['provincia']);
  	}

	if ( isset($values["sexo"]) && $values["sexo"] ) $q->addWhere( $r . '.sexo = ?', $values['sexo']);
		
	
	if ( isset($values["edad_desde"]) && isset($values["edad_hasta"]) && ($values["edad_desde"] || $values["edad_hasta"]) ) $q->addWhere('fecha_nacimiento IS NOT NULL');
		
	
	if ( isset($values["edad_desde"]) && $values["edad_desde"] ) $q->addWhere( 'YEAR( CURDATE() ) - YEAR(fecha_nacimiento) >= ?', $values["edad_desde"]);
	if ( isset($values["edad_hasta"]) && $values["edad_hasta"] ) $q->addWhere( 'YEAR( CURDATE() ) - YEAR(fecha_nacimiento) <= ?', $values["edad_hasta"]);

		
	if ( isset($values["compras_desde"]) && is_numeric( $values["compras_desde"] ) ) $q->addWhere('(SELECT count(*) FROM pedido p1 WHERE (p1.id_usuario = ' . $r . '.id_usuario) AND p1.fecha_pago IS NOT NULL AND p1.fecha_baja IS NULL) >= ?', $values['compras_desde']);
	if ( isset($values["compras_hasta"]) && is_numeric( $values["compras_hasta"] ) ) $q->addWhere('(SELECT count(*) FROM pedido p2 WHERE (p2.id_usuario = ' . $r . '.id_usuario) AND p2.fecha_pago IS NOT NULL AND p2.fecha_baja IS NULL) <= ?', $values['compras_hasta']);
	
	if ( isset($values["source"]) && $values["source"] ) $q->addWhere( $r . '.source like ?', '%' . $values['source'] . '%');
	
	if ( isset($values['id_eshop']) && $values['id_eshop'] )
	{
	    if ( $values['id_eshop'] == eshop::ESHOP_DELUXE )
	    {
	        $q->addWhere( $r . '.id_eshop IS NULL');
	    }
	    else
	    {
	        $q->addWhere( $r . '.id_eshop = ?', $values['id_eshop']);
	    }
	}
  		
  	return $q;
  }
  
}
