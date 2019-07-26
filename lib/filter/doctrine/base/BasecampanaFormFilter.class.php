<?php

/**
 * campana filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecampanaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'                 => new sfWidgetFormFilterInput(),
      'descripcion'                  => new sfWidgetFormFilterInput(),
      'texto_promocion'              => new sfWidgetFormFilterInput(),
      'fecha_inicio'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_fin'                    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tiene_envio_gratis'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'activo'                       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'estimacion_envio_fecha'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'estimacion_envio_observacion' => new sfWidgetFormFilterInput(),
      'estimacion_envio_horas'       => new sfWidgetFormFilterInput(),
      'objetivo_facturacion'         => new sfWidgetFormFilterInput(),
      'mostrar_filtros'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'total_stock'                  => new sfWidgetFormFilterInput(),
      'mostrar_reloj'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mostrar_banner'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mostrar_banner_hover'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mostrar_descripcion'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'permitir_pago_offline'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'resetear_al_finalizar'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'orden'                        => new sfWidgetFormFilterInput(),
      'color'                        => new sfWidgetFormFilterInput(),
      'slug'                         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'denominacion'                 => new sfValidatorPass(array('required' => false)),
      'descripcion'                  => new sfValidatorPass(array('required' => false)),
      'texto_promocion'              => new sfValidatorPass(array('required' => false)),
      'fecha_inicio'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_fin'                    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'tiene_envio_gratis'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'activo'                       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'estimacion_envio_fecha'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'estimacion_envio_observacion' => new sfValidatorPass(array('required' => false)),
      'estimacion_envio_horas'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'objetivo_facturacion'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mostrar_filtros'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'total_stock'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mostrar_reloj'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mostrar_banner'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mostrar_banner_hover'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mostrar_descripcion'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'permitir_pago_offline'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'resetear_al_finalizar'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'orden'                        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'color'                        => new sfValidatorPass(array('required' => false)),
      'slug'                         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('campana_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'campana';
  }

  public function getFields()
  {
    return array(
      'id_campana'                   => 'Number',
      'denominacion'                 => 'Text',
      'descripcion'                  => 'Text',
      'texto_promocion'              => 'Text',
      'fecha_inicio'                 => 'Date',
      'fecha_fin'                    => 'Date',
      'tiene_envio_gratis'           => 'Boolean',
      'activo'                       => 'Boolean',
      'estimacion_envio_fecha'       => 'Date',
      'estimacion_envio_observacion' => 'Text',
      'estimacion_envio_horas'       => 'Number',
      'objetivo_facturacion'         => 'Number',
      'mostrar_filtros'              => 'Boolean',
      'total_stock'                  => 'Number',
      'mostrar_reloj'                => 'Boolean',
      'mostrar_banner'               => 'Boolean',
      'mostrar_banner_hover'         => 'Boolean',
      'mostrar_descripcion'          => 'Boolean',
      'permitir_pago_offline'        => 'Boolean',
      'resetear_al_finalizar'        => 'Boolean',
      'orden'                        => 'Number',
      'color'                        => 'Text',
      'slug'                         => 'Text',
    );
  }
}
