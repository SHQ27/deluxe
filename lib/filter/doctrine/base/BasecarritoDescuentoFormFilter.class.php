<?php

/**
 * carritoDescuento filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecarritoDescuentoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_descuento'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('descuento'), 'add_empty' => true)),
      'id_session'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('session'), 'add_empty' => true)),
      'info_adicional'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_descuento'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('descuento'), 'column' => 'id_descuento')),
      'id_session'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('session'), 'column' => 'id_session')),
      'info_adicional'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('carrito_descuento_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'carritoDescuento';
  }

  public function getFields()
  {
    return array(
      'id_carrito_descuento' => 'Number',
      'id_descuento'         => 'ForeignKey',
      'id_session'           => 'ForeignKey',
      'info_adicional'       => 'Text',
    );
  }
}
