<?php

/**
 * talleSet filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class talleSetFormFilter extends BasetalleSetFormFilter
{
  public function configure()
  {
      // Widget para Marcas
      $choices = array();
      $marcas = marcaTable::getInstance()->listAll();
      $choicesMarcas[''] = 'Todas';
      foreach ($marcas as $marca)
      {
          $choicesMarcas[$marca->getIdMarca()] = $marca->getNombre();
      }
      $this->setWidget( 'id_marca', new sfWidgetFormChoice( array( 'choices' => $choicesMarcas ) ) );
      $this->setValidator('id_marca', new sfValidatorChoice( array( 'choices' => array_keys($choicesMarcas), 'required' => true ) ) );
      
  }
}
