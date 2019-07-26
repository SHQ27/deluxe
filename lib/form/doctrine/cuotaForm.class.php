<?php

/**
 * cuota form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuotaForm extends BasecuotaForm
{
  public function configure()
  {
      $choices = array();
      for( $i = 0 ; $i <= 100 ; $i++ ) $choices[$i] = $i . '%';
      $this->setWidget('multiplicador', new sfWidgetFormSelect( array('choices' => $choices) ) );
  }
}
