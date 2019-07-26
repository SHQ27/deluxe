<?php

/**
 * campana form base class.
 *
 * @method campana getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecampanaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_campana'                   => new sfWidgetFormInputHidden(),
      'denominacion'                 => new sfWidgetFormInputText(),
      'descripcion'                  => new sfWidgetFormTextarea(),
      'texto_promocion'              => new sfWidgetFormInputText(),
      'fecha_inicio'                 => new sfWidgetFormDateTime(),
      'fecha_fin'                    => new sfWidgetFormDateTime(),
      'tiene_envio_gratis'           => new sfWidgetFormInputCheckbox(),
      'activo'                       => new sfWidgetFormInputCheckbox(),
      'estimacion_envio_fecha'       => new sfWidgetFormDate(),
      'estimacion_envio_observacion' => new sfWidgetFormTextarea(),
      'estimacion_envio_horas'       => new sfWidgetFormInputText(),
      'objetivo_facturacion'         => new sfWidgetFormInputText(),
      'mostrar_filtros'              => new sfWidgetFormInputCheckbox(),
      'total_stock'                  => new sfWidgetFormInputText(),
      'mostrar_reloj'                => new sfWidgetFormInputCheckbox(),
      'mostrar_banner'               => new sfWidgetFormInputCheckbox(),
      'mostrar_banner_hover'         => new sfWidgetFormInputCheckbox(),
      'mostrar_descripcion'          => new sfWidgetFormInputCheckbox(),
      'permitir_pago_offline'        => new sfWidgetFormInputCheckbox(),
      'resetear_al_finalizar'        => new sfWidgetFormInputCheckbox(),
      'orden'                        => new sfWidgetFormInputText(),
      'color'                        => new sfWidgetFormInputText(),
      'slug'                         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_campana'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_campana')), 'empty_value' => $this->getObject()->get('id_campana'), 'required' => false)),
      'denominacion'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'descripcion'                  => new sfValidatorString(array('required' => false)),
      'texto_promocion'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fecha_inicio'                 => new sfValidatorDateTime(array('required' => false)),
      'fecha_fin'                    => new sfValidatorDateTime(array('required' => false)),
      'tiene_envio_gratis'           => new sfValidatorBoolean(array('required' => false)),
      'activo'                       => new sfValidatorBoolean(array('required' => false)),
      'estimacion_envio_fecha'       => new sfValidatorDate(array('required' => false)),
      'estimacion_envio_observacion' => new sfValidatorString(array('required' => false)),
      'estimacion_envio_horas'       => new sfValidatorInteger(array('required' => false)),
      'objetivo_facturacion'         => new sfValidatorInteger(array('required' => false)),
      'mostrar_filtros'              => new sfValidatorBoolean(array('required' => false)),
      'total_stock'                  => new sfValidatorInteger(array('required' => false)),
      'mostrar_reloj'                => new sfValidatorBoolean(array('required' => false)),
      'mostrar_banner'               => new sfValidatorBoolean(array('required' => false)),
      'mostrar_banner_hover'         => new sfValidatorBoolean(array('required' => false)),
      'mostrar_descripcion'          => new sfValidatorBoolean(array('required' => false)),
      'permitir_pago_offline'        => new sfValidatorBoolean(array('required' => false)),
      'resetear_al_finalizar'        => new sfValidatorBoolean(array('required' => false)),
      'orden'                        => new sfValidatorInteger(array('required' => false)),
      'color'                        => new sfValidatorPass(array('required' => false)),
      'slug'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('campana[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'campana';
  }

}
