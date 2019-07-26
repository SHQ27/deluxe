<?php

/**
 * devolucion form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class devolucionForm extends BasedevolucionForm
{
  public function configure()
  {      
      $devolucion = $this->getObject();
      
      if ( $devolucion->getFechaEnvioOca() ||  $devolucion->getFechaRecibido() )
      {
          $this->setWidget('tipo_envio', new sfWidgetFormInputHidden() );
      }
      else
     {
         $this->setWidget('tipo_envio', new sfWidgetFormSelect( array('choices' => array(devolucion::envio_deluxe => 'Propio', devolucion::envio_oca =>  'Via OCA') )) );
      }
      
      $this->setWidget('tipo_credito', new sfWidgetFormSelect( array('choices' => array(devolucion::credito_deluxe => 'Bonificacion', devolucion::credito_mp =>  'Mercado Pago') )) );

      $this->setWidget('fecha', new sfWidgetFormInputHidden() );
      $this->setWidget('id_usuario', new sfWidgetFormInputHidden() );
  }
  
  protected function doSave($con = null)
  {        
      $devolucion = $this->getObject();
      $devolucion->setTipoCredito( $this->getValue('tipo_credito') );
      $devolucion->setTipoEnvio( $this->getValue('tipo_envio') );
      
      $devolucion->save();
  }
  
}
