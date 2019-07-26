<?php

/**
 * descuento filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class descuentoFormFilter extends BasedescuentoFormFilter
{
  public function configure()
  {
  	$this->setWidget('vigencia_desde',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate())));
  	$this->setWidget('vigencia_hasta',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate())));
  	
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
