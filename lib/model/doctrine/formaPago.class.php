<?php

/**
 * formaPago
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class formaPago extends BaseformaPago
{
	const MERCADOPAGO        = 'MPAGO';
	const NPS                = 'PANPS';
	const DECIDIR            = 'DECID';
	const MERCADOLIBRE       = 'MELIB';

	public function __toString()
	{
	    return $this->getDenominacion();
	}
	
}
