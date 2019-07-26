<?php

require_once dirname(__FILE__).'/../lib/marcasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/marcasGeneratorHelper.class.php';

/**
 * marcas actions.
 *
 * @package    deluxebuys
 * @subpackage marcas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class marcasActions extends autoMarcasActions
{
		
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

  	$idMarca = $request->getParameter('id_marca'); 
    
    $hayProductos = productoTable::getInstance()->hayProductosDeMarca($idMarca);
    
    if (!$hayProductos)
    {
	    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
	
	    if ($this->getRoute()->getObject()->delete())
	    {
	      $this->getUser()->setFlash('notice', 'La marca fue borrada correctamente.');
	    }
	    
		$filename = imageHelper::getInstance()->getPath('marca_imagen', $this->getRoute()->getObject());
		
		if (is_file($filename))
		{
		    unlink( $filename );
		}
    }    
    else
    {
 		$this->getUser()->setFlash('error', 'No se pudo borrar la marca seleccionada debido a que existen productos de esa marca.');
    }
    
    $this->redirect('@marca');
  }  
  
	
}
