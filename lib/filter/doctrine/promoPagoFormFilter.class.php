<?php

/**
 * promoPago filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class promoPagoFormFilter extends BasepromoPagoFormFilter
{
  public function configure()
  {

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

	// Widget para forma de pago  	
  	$choices = array( '' => '', 'DECID' => 'Decidir', 'PANPS' => 'NPS' );
  	$this->setWidget('id_forma_pago', new sfWidgetFormSelect( array('choices' => $choices) ) );
  	$this->setValidator('id_forma_pago', new sfValidatorChoice( array('choices' => array_keys($choices), 'required' => false ) ) );
  }

  public function addIdEshopColumnQuery(Doctrine_Query $query, $field, $values) { }

  public function buildQuery(array $values)
  {     
  	$values = $this->processValues($values);
  	  	
  	$q = parent::doBuildQuery($values);
  	$rootAlias = $q->getRootAlias();
	
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
	
	$q->orderBy( $rootAlias . '.orden DESC');

    return $q;
  }

}
