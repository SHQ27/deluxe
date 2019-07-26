<?php

/**
 * bonificacion form base class.
 *
 * @method bonificacion getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasebonificacionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_bonificacion'      => new sfWidgetFormInputHidden(),
      'id_usuario'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => false)),
      'id_tipo_descuento'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tipoDescuento'), 'add_empty' => false)),
      'id_tipo_bonificacion' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tipoBonificacion'), 'add_empty' => false)),
      'valor'                => new sfWidgetFormInputText(),
      'fue_utilizada'        => new sfWidgetFormInputCheckbox(),
      'vencimiento'          => new sfWidgetFormDate(),
      'es_interna'           => new sfWidgetFormInputCheckbox(),
      'observaciones'        => new sfWidgetFormTextarea(),
      'fecha_alta'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_bonificacion'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_bonificacion')), 'empty_value' => $this->getObject()->get('id_bonificacion'), 'required' => false)),
      'id_usuario'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'))),
      'id_tipo_descuento'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('tipoDescuento'))),
      'id_tipo_bonificacion' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('tipoBonificacion'))),
      'valor'                => new sfValidatorNumber(array('required' => false)),
      'fue_utilizada'        => new sfValidatorBoolean(array('required' => false)),
      'vencimiento'          => new sfValidatorDate(array('required' => false)),
      'es_interna'           => new sfValidatorBoolean(array('required' => false)),
      'observaciones'        => new sfValidatorString(array('required' => false)),
      'fecha_alta'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('bonificacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'bonificacion';
  }

}
