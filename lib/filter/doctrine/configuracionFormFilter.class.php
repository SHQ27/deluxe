<?php

/**
 * configuracion filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class configuracionFormFilter extends BaseconfiguracionFormFilter
{
  public function configure()
  {
      $choices = array( '' => '', configuracion::TIPO_TEXTO => 'Valores', configuracion::TIPO_IMAGEN => 'Imagen' );
      $this->setWidget('tipo', new sfWidgetFormSelect( array('choices' => $choices) ) );      
  }
  
  public function buildQuery(array $values)
  {
      $values = $this->processValues($values);
 
      $q = parent::doBuildQuery($values);
      $rootAlias = $q->getRootAlias();
      $q->addWhere( $rootAlias . ".id_configuracion <> ?", configuracion::OUTLET );
      
      if ( isset($values['tipo']) && $values['tipo'] )
      {
          $q->addWhere( $rootAlias . ".tipo = ?", $values['tipo'] );
      }
       
  
      return $q;
  }
  
}
