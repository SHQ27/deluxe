<?php

/**
 * devueltoOca filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class devueltoOcaFormFilter extends BasedevueltoOcaFormFilter
{
  public function configure()
  {
  	$this->setWidgets(array());
  	$this->setValidators(array());
  	 	
  	$this->widgetSchema->setNameFormat('devuelto_oca_filters[%s]');
  	
  	// Widget para id pedido
  	$this->setWidget( 'id_pedido', new sfWidgetFormInput() );
  	$this->setValidator('id_pedido', new sfValidatorPass() );
  	
  	// Widget para usuario
  	$this->setWidget('usuario',  new sfWidgetFormInput() );
  	$this->setValidator('usuario', new sfValidatorPass() );
  	
  	// Widget para email
  	$this->setWidget('email',  new sfWidgetFormInput() );
  	$this->setValidator('email', new sfValidatorPass() );

  	// Widget para fecha
  	$this->setWidget('fecha',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false)));
  	$this->setValidator('fecha', new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))));
  	
    // Widget de Retiro
    $this->setWidget('retirado', new sfWidgetFormSelect( array('choices' => array( '' => 'Indistinto', '1' => 'Sí', '0' => 'No'))) );
    $this->setValidator('retirado', new sfValidatorPass() );

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
  	$q->select( $rootAlias . '.*');

  	if ( isset($values['usuario']) || isset($values['email']) )
  	{
  		$q->innerJoin( $rootAlias . '.pedido p');
  		$q->innerJoin( 'p.usuario u');
  	}
  	
  	if ( isset($values['usuario']) && $values['usuario'] )
  	{
  		$txt = $values['usuario'];
  		$q->addWhere( '(u.nombre LIKE ? OR u.apellido LIKE ?)', array("%$txt%", "%$txt%") );
  	}
  	
  	if ( isset($values['email']) && $values['email'] )
  	{
  		$txt = $values['email'];
  		$q->addWhere( 'u.email LIKE ?', array("%$txt%") );
  	}


    if ( isset($values['retirado']) )
    {
      if ( $values['retirado'] == '1' ) { $q->addWhere( $rootAlias . '.fecha_retirado is not null'); }
      if ( $values['retirado'] == '0' ) { $q->addWhere( $rootAlias . '.fecha_retirado is null'); }
    }
  	
  	if ( isset($values['id_eshop']) && $values['id_eshop'] )
  	{
  	    if ( $values['id_eshop'] == eshop::ESHOP_DELUXE )
  	    {
  	        $q->addWhere( 'p.id_eshop IS NULL');
  	    }
  	    else
  	    {
  	        $q->addWhere( 'p.id_eshop = ?', $values['id_eshop']);
  	    }
  	}
  	
  	return $q;
  	
  	
  }
  
  
}
