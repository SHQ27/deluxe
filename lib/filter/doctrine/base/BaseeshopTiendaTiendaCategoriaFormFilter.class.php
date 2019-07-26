<?php

/**
 * eshopTiendaTiendaCategoria filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseeshopTiendaTiendaCategoriaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('eshop_tienda_tienda_categoria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopTiendaTiendaCategoria';
  }

  public function getFields()
  {
    return array(
      'id_eshop_tienda'           => 'Number',
      'id_eshop_tienda_categoria' => 'Number',
    );
  }
}
