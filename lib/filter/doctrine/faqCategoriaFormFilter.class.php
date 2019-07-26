<?php

/**
 * faqCategoria filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class faqCategoriaFormFilter extends BasefaqCategoriaFormFilter
{
  public function configure()
  {
      // Widget para eShops
      $choices = array();
      $eshops = eshopTable::getInstance()->listAll();
      $choices[''] = '';
      $choices[ eshop::ESHOP_DELUXE ] = 'Deluxe Buys';
      foreach ($eshops as $eshop)
      {
          $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
      }
      $this->setWidget( 'id_eshop', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
      $this->setValidator( 'id_eshop', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ) );
  }  
  

  public function addIdEshopColumnQuery($query, $field, $value)
  {

      if ( $value  == eshop::ESHOP_DELUXE ) {
          $query->addWhere( 'id_eshop IS NULL' );
      } else {
          $query->addWhere( 'id_eshop = ?', $value );
      }
  }
  
  public function buildQuery(array $values)
  {
      $values = $this->processValues($values);
      $q = parent::doBuildQuery($values);
      $rootAlias = $q->getRootAlias();
      $q->select( $rootAlias .'.*');

      $q->orderBy( $rootAlias . '.orden ASC');
      
      // Fuerzo a que se filtro por eShop
      if ( !isset($values['id_eshop']) ) {
          $q->addWhere('false');
      }
  
      return $q;
  }
  
}
