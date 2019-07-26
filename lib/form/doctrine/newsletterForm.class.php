<?php

/**
 * newsletter form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletterForm extends BasenewsletterForm
{
  public function configure()
  {    
    $this->setWidget('sexo', new sfWidgetFormChoice(array('choices' => array('h' => 'Hombre', 'm' => 'Mujer')))); 
  }
}
