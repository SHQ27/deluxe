<?php

/**
 * bannerPrincipal filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasebannerPrincipalFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'        => new sfWidgetFormFilterInput(),
      'url'                 => new sfWidgetFormFilterInput(),
      'activo'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fecha_desde'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_hasta'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'orden'               => new sfWidgetFormFilterInput(),
      'mostrar_descripcion' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'color'               => new sfWidgetFormFilterInput(),
      'off'                 => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'denominacion'        => new sfValidatorPass(array('required' => false)),
      'url'                 => new sfValidatorPass(array('required' => false)),
      'activo'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fecha_desde'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_hasta'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'orden'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mostrar_descripcion' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'color'               => new sfValidatorPass(array('required' => false)),
      'off'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('banner_principal_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'bannerPrincipal';
  }

  public function getFields()
  {
    return array(
      'id_banner_principal' => 'Number',
      'denominacion'        => 'Text',
      'url'                 => 'Text',
      'activo'              => 'Boolean',
      'fecha_desde'         => 'Date',
      'fecha_hasta'         => 'Date',
      'orden'               => 'Number',
      'mostrar_descripcion' => 'Boolean',
      'color'               => 'Text',
      'off'                 => 'Number',
    );
  }
}
