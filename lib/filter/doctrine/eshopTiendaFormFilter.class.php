<?php

/**
 * eshopTienda filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eshopTiendaFormFilter extends BaseeshopTiendaFormFilter
{
  public function configure()
  {
  }
  
  public function buildQuery(array $values)
  {
      $idEshop = $_GET['id_eshop'];
  
      $values = $this->processValues($values);
       
      $q = parent::doBuildQuery($values);
      $rootAlias = $q->getRootAlias();
      $q->addWhere( $rootAlias . '.id_eshop = ?', $idEshop);
  
      return $q;
  }
}
