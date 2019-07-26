<?php

/**
 * bonificacion filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bonificacionFormFilter extends BasebonificacionFormFilter
{
  public function configure()
  {
    $this->setWidget('id_usuario',  new sfWidgetFormInputHidden());
    $this->setValidator('id_usuario',  new sfValidatorPass(array('required' => false)));
      
  	$this->setWidget('email_usuario',  new sfWidgetFormInputText());
  	$this->setValidator('email_usuario',  new sfValidatorPass(array('required' => false)));
  	
  	$this->setWidget('vencimiento',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate())));
  }
  
  public function buildQuery(array $values)
  {
  
      $values = $this->processValues($values);
        
      $q = parent::doBuildQuery($values);
      $rootAlias = $q->getRootAlias();
      $q->innerJoin( $rootAlias .  '.usuario u');
      
  
      // Filtro por email de usuario
      if ( isset($values['email_usuario']) && $values['email_usuario'] )
      {
          $q->addWhere( 'u.email like ?',  "%" . $values['email_usuario'] . "%" );
      }
      
      return $q;
  }  
}
