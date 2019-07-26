<?php

/**
 * recuperoCarrito filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaserecuperoCarritoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_pedido'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => true)),
      'mail_enviado'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'hash'                => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_pedido'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedido'), 'column' => 'id_pedido')),
      'mail_enviado'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'hash'                => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recupero_carrito_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'recuperoCarrito';
  }

  public function getFields()
  {
    return array(
      'id_recupero_carrito' => 'Number',
      'id_pedido'           => 'ForeignKey',
      'mail_enviado'        => 'Boolean',
      'hash'                => 'Text',
    );
  }
}
