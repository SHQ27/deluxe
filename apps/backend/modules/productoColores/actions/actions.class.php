<?php

require_once dirname(__FILE__).'/../lib/productoColoresGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/productoColoresGeneratorHelper.class.php';

/**
 * productoColores actions.
 *
 * @package    deluxebuys
 * @subpackage productoColores
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productoColoresActions extends autoProductoColoresActions
{
	
public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

  	$idProductoColor = $request->getParameter('id_producto_color'); 
    
    $hayProductos = productoItemTable::getInstance()->hayProductosDeColor($idProductoColor);
    
    if (!$hayProductos)
    {
	    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
	
	    if ($this->getRoute()->getObject()->delete())
	    {
	      $this->getUser()->setFlash('notice', 'El color fue borrado correctamente.');
	    }
    }
    else
    {
 		$this->getUser()->setFlash('error', 'No se pudo borrar el color seleccionado debido a que existen productos de ese color.');
    }
    
    $this->redirect('@producto_color');
  }  
	
}
