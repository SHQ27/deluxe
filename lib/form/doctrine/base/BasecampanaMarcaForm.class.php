<?php

/**
 * campanaMarca form base class.
 *
 * @method campanaMarca getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecampanaMarcaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_campana'                => new sfWidgetFormInputHidden(),
      'id_marca'                  => new sfWidgetFormInputHidden(),
      'id_comercial'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('comercial'), 'add_empty' => true)),
      'comision_comercial'        => new sfWidgetFormInputText(),
      'apertura_marca'            => new sfWidgetFormInputText(),
      'email_orden_compra'        => new sfWidgetFormInputText(),
      'telefono_orden_compra'     => new sfWidgetFormInputText(),
      'enviar_aviso_orden_compra' => new sfWidgetFormInputCheckbox(),
      'fecha_estimada_entrega'    => new sfWidgetFormDate(),
      'comentario_marca'          => new sfWidgetFormTextarea(),
      'comentario_interno'        => new sfWidgetFormTextarea(),
      'ultimo_envio'              => new sfWidgetFormDateTime(),
      'hash'                      => new sfWidgetFormInputText(),
      'costo_total'               => new sfWidgetFormInputText(),
      'pagada'                    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_campana'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_campana')), 'empty_value' => $this->getObject()->get('id_campana'), 'required' => false)),
      'id_marca'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_marca')), 'empty_value' => $this->getObject()->get('id_marca'), 'required' => false)),
      'id_comercial'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('comercial'), 'required' => false)),
      'comision_comercial'        => new sfValidatorNumber(array('required' => false)),
      'apertura_marca'            => new sfValidatorInteger(array('required' => false)),
      'email_orden_compra'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'telefono_orden_compra'     => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'enviar_aviso_orden_compra' => new sfValidatorBoolean(array('required' => false)),
      'fecha_estimada_entrega'    => new sfValidatorDate(array('required' => false)),
      'comentario_marca'          => new sfValidatorString(array('required' => false)),
      'comentario_interno'        => new sfValidatorString(array('required' => false)),
      'ultimo_envio'              => new sfValidatorDateTime(array('required' => false)),
      'hash'                      => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'costo_total'               => new sfValidatorNumber(array('required' => false)),
      'pagada'                    => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('campana_marca[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'campanaMarca';
  }

}
