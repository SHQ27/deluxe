<?php

/**
 * eshopTienda filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseeshopTiendaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'denominacion'    => new sfWidgetFormFilterInput(),
      'direccion'       => new sfWidgetFormFilterInput(),
      'telefono'        => new sfWidgetFormFilterInput(),
      'latitud'         => new sfWidgetFormFilterInput(),
      'longitud'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_eshop'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
      'denominacion'    => new sfValidatorPass(array('required' => false)),
      'direccion'       => new sfValidatorPass(array('required' => false)),
      'telefono'        => new sfValidatorPass(array('required' => false)),
      'latitud'         => new sfValidatorPass(array('required' => false)),
      'longitud'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop_tienda_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopTienda';
  }

  public function getFields()
  {
    return array(
      'id_eshop_tienda' => 'Number',
      'id_eshop'        => 'ForeignKey',
      'denominacion'    => 'Text',
      'direccion'       => 'Text',
      'telefono'        => 'Text',
      'latitud'         => 'Text',
      'longitud'        => 'Text',
    );
  }
}
