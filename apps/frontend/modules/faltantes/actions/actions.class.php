<?php

/**
 * faltantes actions.
 *
 * @package    deluxebuys
 * @subpackage faltantes
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class faltantesActions extends deluxebuysActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$idFaltante = $request->getParameter('idFaltante');
  	$faltante = faltanteTable::getInstance()->findOneByIdFaltante( $idFaltante );  	
  	
  	$this->error = false;
  	if ($faltante)
  	{  		
        $pedido = $faltante->getPedido();
        $currentUser = $this->getUser()->getCurrentUser();
        
        if ( $currentUser && $currentUser->getIdUsuario() == $pedido->getIdUsuario() )
        {
            $valor = faltanteTable::getInstance()->generarBonificacion($faltante);
            $this->valor = $valor;
        }
        else
        {
            $this->error = 'Este faltante no corresponde a la sesion de usuario en curso, por favor ingresa con el usuario correspondiente.';
        }   
  	}
  	else
  	{
  		$this->error = 'Este proceso ha sido cancelado. <br /><br />El e-mail de faltante fue enviado por error.';
  	}
  }
}
