<?php

/**
 * talleSetZona form base class.
 *
 * @method talleSetZona getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasetalleSetZonaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_talle_set_zona' => new sfWidgetFormInputHidden(),
      'id_talle_set'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('talleSet'), 'add_empty' => false)),
      'id_talle_zona'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('talleZona'), 'add_empty' => false)),
      'id_producto_talle' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoTalle'), 'add_empty' => false)),
      'desde'             => new sfWidgetFormInputText(),
      'hasta'             => new sfWidgetFormInputText(),
      'orden'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_talle_set_zona' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_talle_set_zona')), 'empty_value' => $this->getObject()->get('id_talle_set_zona'), 'required' => false)),
      'id_talle_set'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('talleSet'))),
      'id_talle_zona'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('talleZona'))),
      'id_producto_talle' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoTalle'))),
      'desde'             => new sfValidatorInteger(array('required' => false)),
      'hasta'             => new sfValidatorInteger(array('required' => false)),
      'orden'             => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('talle_set_zona[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'talleSetZona';
  }

}
