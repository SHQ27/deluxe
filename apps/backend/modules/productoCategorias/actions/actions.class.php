<?php

require_once dirname(__FILE__).'/../lib/productoCategoriasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/productoCategoriasGeneratorHelper.class.php';

/**
 * productoCategorias actions.
 *
 * @package    deluxebuys
 * @subpackage productoCategorias
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productoCategoriasActions extends autoProductoCategoriasActions
{
	
 protected function buildQuery()
  {
    $tableMethod = $this->configuration->getTableMethod();
    if (null === $this->filters)
    {
      $this->filters = $this->configuration->getFilterForm($this->getFilters());
    }

    $this->filters->setTableMethod($tableMethod);

    $query = $this->filters->buildQuery($this->getFilters());
    
    $this->addSortQuery($query);

    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_query'), $query);
    $query = $event->getReturnValue();

    return $query;
  }
	
public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

  	$idProductoCategoria = $request->getParameter('id_producto_categoria'); 

    $hayProductos = productoTable::getInstance()->hayProductosDeCategoria($idProductoCategoria);
    
    if (!$hayProductos)
    {
	    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
	
	    if ($this->getRoute()->getObject()->delete())
	    {
	      $this->getUser()->setFlash('notice', 'La categoria fue borrada correctamente.');
	    }
    }
    else
    {
 		$this->getUser()->setFlash('error', 'No se pudo borrar la categoria seleccionada debido a que existen productos de esa categoria.');
    }
    
    $this->redirect('@producto_categoria');
  }  
	
}
