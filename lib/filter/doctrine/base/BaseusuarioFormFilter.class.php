<?php

/**
 * usuario filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseusuarioFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'apellido'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sexo'               => new sfWidgetFormFilterInput(),
      'email'              => new sfWidgetFormFilterInput(),
      'password'           => new sfWidgetFormFilterInput(),
      'telefono'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'celular'            => new sfWidgetFormFilterInput(),
      'fecha_nacimiento'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tipo_documento'     => new sfWidgetFormFilterInput(),
      'documento'          => new sfWidgetFormFilterInput(),
      'activo'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fecha_alta'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fecha_confirmacion' => new sfWidgetFormFilterInput(),
      'fecha_baja'         => new sfWidgetFormFilterInput(),
      'fid'                => new sfWidgetFormFilterInput(),
      'dias_devolucion'    => new sfWidgetFormFilterInput(),
      'source'             => new sfWidgetFormFilterInput(),
      'fecha_source'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'utm_campaign'       => new sfWidgetFormFilterInput(),
      'utm_term'           => new sfWidgetFormFilterInput(),
      'id_eshop'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nombre'             => new sfValidatorPass(array('required' => false)),
      'apellido'           => new sfValidatorPass(array('required' => false)),
      'sexo'               => new sfValidatorPass(array('required' => false)),
      'email'              => new sfValidatorPass(array('required' => false)),
      'password'           => new sfValidatorPass(array('required' => false)),
      'telefono'           => new sfValidatorPass(array('required' => false)),
      'celular'            => new sfValidatorPass(array('required' => false)),
      'fecha_nacimiento'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'tipo_documento'     => new sfValidatorPass(array('required' => false)),
      'documento'          => new sfValidatorPass(array('required' => false)),
      'activo'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fecha_alta'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_confirmacion' => new sfValidatorPass(array('required' => false)),
      'fecha_baja'         => new sfValidatorPass(array('required' => false)),
      'fid'                => new sfValidatorPass(array('required' => false)),
      'dias_devolucion'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'source'             => new sfValidatorPass(array('required' => false)),
      'fecha_source'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'utm_campaign'       => new sfValidatorPass(array('required' => false)),
      'utm_term'           => new sfValidatorPass(array('required' => false)),
      'id_eshop'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
    ));

    $this->widgetSchema->setNameFormat('usuario_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'usuario';
  }

  public function getFields()
  {
    return array(
      'id_usuario'         => 'Number',
      'nombre'             => 'Text',
      'apellido'           => 'Text',
      'sexo'               => 'Text',
      'email'              => 'Text',
      'password'           => 'Text',
      'telefono'           => 'Text',
      'celular'            => 'Text',
      'fecha_nacimiento'   => 'Date',
      'tipo_documento'     => 'Text',
      'documento'          => 'Text',
      'activo'             => 'Boolean',
      'fecha_alta'         => 'Date',
      'fecha_confirmacion' => 'Text',
      'fecha_baja'         => 'Text',
      'fid'                => 'Text',
      'dias_devolucion'    => 'Number',
      'source'             => 'Text',
      'fecha_source'       => 'Date',
      'utm_campaign'       => 'Text',
      'utm_term'           => 'Text',
      'id_eshop'           => 'ForeignKey',
    );
  }
}
