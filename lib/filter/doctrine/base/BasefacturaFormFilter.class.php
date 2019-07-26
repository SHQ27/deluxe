<?php

/**
 * factura filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasefacturaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_pedido'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => true)),
      'procesada'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'CAE'             => new sfWidgetFormFilterInput(),
      'CAE_vencimiento' => new sfWidgetFormFilterInput(),
      'comprobante'     => new sfWidgetFormFilterInput(),
      'resultado'       => new sfWidgetFormFilterInput(),
      'entorno'         => new sfWidgetFormFilterInput(),
      'mail_enviado'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'id_pedido'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedido'), 'column' => 'id_pedido')),
      'procesada'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'CAE'             => new sfValidatorPass(array('required' => false)),
      'CAE_vencimiento' => new sfValidatorPass(array('required' => false)),
      'comprobante'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'resultado'       => new sfValidatorPass(array('required' => false)),
      'entorno'         => new sfValidatorPass(array('required' => false)),
      'mail_enviado'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('factura_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'factura';
  }

  public function getFields()
  {
    return array(
      'id_factura'      => 'Number',
      'id_pedido'       => 'ForeignKey',
      'procesada'       => 'Boolean',
      'CAE'             => 'Text',
      'CAE_vencimiento' => 'Text',
      'comprobante'     => 'Number',
      'resultado'       => 'Text',
      'entorno'         => 'Text',
      'mail_enviado'    => 'Boolean',
    );
  }
}
