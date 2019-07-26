<?php

require_once dirname(__FILE__).'/../lib/zonasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/zonasGeneratorHelper.class.php';

/**
 * zonas actions.
 *
 * @package    deluxebuys
 * @subpackage zonas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class zonasActions extends autoZonasActions
{
	
  public function executeListGoToCostos(sfWebRequest $request)
  {
  	$zona = $this->getRoute()->getObject();
  	$this->redirect('/backend/costosEnvio?id_zona=' . $zona->getIdZona());
  }

}