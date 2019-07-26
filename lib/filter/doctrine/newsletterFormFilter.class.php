<?php

/**
 * newsletter filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletterFormFilter extends BasenewsletterFormFilter
{
  public function configure()
  {
      // Widget para fecha alta
      $this->setWidget('fecha_alta',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false)));

      // Widget para Sexo
      $this->setWidget( 'sexo', new sfWidgetFormSelect( array( 'choices' => array('' => 'Indistinto','h' => 'Hombre', 'm' => 'Mujer') ) ) );
      
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
      $q->leftJoin( $r . '.eshop e');
  
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

      if ( isset($values['sexo']) && $values['sexo'] )
      {
          $q->addWhere( $r . '.sexo = ?', $values['sexo']);
      }
  
      return $q;
  }
  
}
