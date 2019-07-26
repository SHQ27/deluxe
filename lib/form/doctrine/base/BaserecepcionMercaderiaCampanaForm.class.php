<?php

/**
 * recepcionMercaderiaCampana form base class.
 *
 * @method recepcionMercaderiaCampana getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaserecepcionMercaderiaCampanaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_recepcion_mercaderia_campana' => new sfWidgetFormInputHidden(),
      'id_campana'                      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('campana'), 'add_empty' => false)),
      'id_producto_item'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => false)),
      'fecha'                           => new sfWidgetFormDateTime(),
      'cantidad'                        => new sfWidgetFormInputText(),
      'observacion'                     => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id_recepcion_mercaderia_campana' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_recepcion_mercaderia_campana')), 'empty_value' => $this->getObject()->get('id_recepcion_mercaderia_campana'), 'required' => false)),
      'id_campana'                      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('campana'))),
      'id_producto_item'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'))),
      'fecha'                           => new sfValidatorDateTime(),
      'cantidad'                        => new sfValidatorInteger(array('required' => false)),
      'observacion'                     => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recepcion_mercaderia_campana[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'recepcionMercaderiaCampana';
  }

}
