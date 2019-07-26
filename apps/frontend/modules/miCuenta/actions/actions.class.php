<?php

/**
 * miCuenta actions.
 *
 * @package    deluxebuys
 * @subpackage miCuenta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class miCuentaActions extends abstractMiCuentaActions
{
    public function executeInvitar(sfWebRequest $request)
    {
        $request->setParameter('seccion', 6);
        $this->forward('miCuenta', 'index');
    }
    
		
}
