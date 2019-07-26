<?php

require_once dirname(__FILE__).'/../lib/bonificacionesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bonificacionesGeneratorHelper.class.php';

/**
 * bonificaciones actions.
 *
 * @package    deluxebuys
 * @subpackage bonificaciones
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bonificacionesActions extends autoBonificacionesActions
{

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $bonificacion = $this->getRoute()->getObject();
    
    $estaAsociada = pedidoBonificacionTable::getInstance()->estaAsociada( $bonificacion->getIdBonificacion() );
    
    if (!$estaAsociada)
    {
	    if ($bonificacion->delete())
	    {
	      $this->getUser()->setFlash('notice', 'La bonificacion fue eliminada correctamente.');
	    }
    }
    else 
    {
    	$this->getUser()->setFlash('error', 'No se pudo borrar la bonificacion seleccionada debido a que esta asociada a un pedido.');
    }

    $this->redirect('@bonificacion');
  }
	
}
