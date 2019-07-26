<?php

require_once dirname(__FILE__).'/../lib/marcaRubrosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/marcaRubrosGeneratorHelper.class.php';

/**
 * marcaRubros actions.
 *
 * @package    deluxebuys
 * @subpackage marcaRubros
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class marcaRubrosActions extends autoMarcaRubrosActions
{
	
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();   
     
  	$idMarcaRubro = $request->getParameter('id_marca_rubro'); 
    
    $hayMarcas = marcaTable::getInstance()->hayMarcasDelRubro($idMarcaRubro);
    
    if (!$hayMarcas)
    {
	    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
	
	    if ($this->getRoute()->getObject()->delete())
	    {
	      $this->getUser()->setFlash('notice', 'El rubro fue borrado correctamente.');
	    }
    }
    else
    {
 		$this->getUser()->setFlash('error', 'No se pudo borrar el rubro seleccionado debido a que existen marcas asociadas a dicho rubro.');
    }
    
    $this->redirect('@marca_rubro');
  }  
		
}
