<?php

/**
 * tipoBonificacion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class tipoBonificacion extends BasetipoBonificacion
{
	CONST INVITACION = 'INVIT';
	const ALTA_USUARIO = 'ALTAU';
	const REINTEGRO = 'REINT';
    const SUSCRIPCION = 'SUSCR';
    const CANJE = 'CANJE';
    const PREMIO = 'PREMI';
	
    public function __toString()
    {
        return $this->getDenominacion();
    }
}
