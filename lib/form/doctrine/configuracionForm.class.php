<?php

/**
 * configuracion form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class configuracionForm extends BaseconfiguracionForm
{
  public function configure()
  {	
      $configuracion = $this->getObject();
      
      $this->setWidget( "tipo", new sfWidgetFormInputHidden());
      $this->setWidget( "denominacion", new sfWidgetFormInputHidden());
            
      if ( $configuracion->getTipo() == configuracion::TIPO_OULET )
      {          
          $this->setWidget( "valor", new sfWidgetFormSelect( array('choices' => array( '1' => 'Sí', '0' => 'No' ))) );
      }
      if ( $configuracion->getTipo() == configuracion::TIPO_BOOLEAN )
      {
          $this->setWidget( "valor", new sfWidgetFormSelect( array('choices' => array( '1' => 'Sí', '0' => 'No' ))) );
      }
      else if ( $configuracion->getTipo() == configuracion::TIPO_TEXTO )
      {
          $this->setWidget( "valor", new sfWidgetFormTextarea() );
      }
      else if ( $configuracion->getTipo() == configuracion::TIPO_IMAGEN )
      {
          $this->setWidget( "valor", new sfWidgetFormInputFileEditable( array( 'is_image' => true, 'with_delete' => false, 'file_src' => $configuracion->getImage() ) ) );
      }
      
      $this->setValidator('valor', new sfValidatorPass() );
      
  }
  
  protected function doSave($con = null)
  {
      $configuracion = $this->getObject();
              
      if ( $configuracion->getTipo() == configuracion::TIPO_IMAGEN )
      {
          $valor = $this->getValue('valor');
          move_uploaded_file( $valor['tmp_name'], $configuracion->getPath());
      }
      else
      {
          $this->updateObject();
      }
      
      $configuracion->save($con);
      
  }
  
}
;